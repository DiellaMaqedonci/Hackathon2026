-- Run AFTER more_charities.sql. Adds 3 more charities to every country that has a Red Cross row,
-- placed next to the capital pin (small offsets so pins don't overlap), then gives them demo needs.
-- Safe to run again: it never adds the same charity or need twice.
INSERT INTO `charities` (`name`,`country`,`city`,`address`,`lat`,`lng`)
SELECT x.nm, x.code, x.city, '', x.lat, x.lng
FROM (
  SELECT c.code, CONCAT('Caritas ', c.name) AS nm, r.city, r.lat + 0.02 AS lat, r.lng + 0.02 AS lng
  FROM `charities` r JOIN `countries` c ON c.code = r.country
  WHERE r.name = CONCAT(c.name, ' Red Cross / Red Crescent')
  UNION ALL
  SELECT c.code, CONCAT(r.city, ' Community Clothing Bank'), r.city, r.lat - 0.02, r.lng + 0.03
  FROM `charities` r JOIN `countries` c ON c.code = r.country
  WHERE r.name = CONCAT(c.name, ' Red Cross / Red Crescent')
  UNION ALL
  SELECT c.code, CONCAT(r.city, ' Warm Clothes Closet'), r.city, r.lat + 0.03, r.lng - 0.02
  FROM `charities` r JOIN `countries` c ON c.code = r.country
  WHERE r.name = CONCAT(c.name, ' Red Cross / Red Crescent')
) x
WHERE NOT EXISTS (SELECT 1 FROM `charities` y WHERE y.country = x.code AND y.name = x.nm);

-- Demo needs for every charity that has none yet (same placeholder data as more_charities.sql)
INSERT INTO clothes (cloth_name, cloth_desc, cloth_quantity, cloth_size, cloth_img, charity_id)
SELECT n.cloth_name, n.cloth_desc, n.qty + MOD(ch.id * 3, 7), n.sz, '', ch.id
FROM charities ch
JOIN (
  SELECT 1 AS k, 'Winter Coats' AS cloth_name, 'Warm, clean coats with working zippers' AS cloth_desc, 15 AS qty, 40 AS sz
  UNION ALL SELECT 2,  'Children''s Boots',    'Waterproof boots, clean and not damaged', 12, 32
  UNION ALL SELECT 3,  'Wool Sweaters',        'Thick sweaters, no holes or stains', 10, 42
  UNION ALL SELECT 4,  'Thermal Socks',        'New or very lightly used thermal socks', 30, 38
  UNION ALL SELECT 5,  'Women''s Pants',       'Clean, wearable trousers and jeans', 12, 38
  UNION ALL SELECT 6,  'Men''s Pants',         'Clean, wearable trousers and jeans', 10, 42
  UNION ALL SELECT 7,  'Summer Dresses',       'Clean, no stains, light fabrics', 14, 36
  UNION ALL SELECT 8,  'Children''s Sweaters', 'Warm sweaters, clean, no stains', 18, 28
  UNION ALL SELECT 9,  'Rain Jackets',         'Waterproof jackets for adults and teens', 9, 44
  UNION ALL SELECT 10, 'Winter Hats',          'Warm hats, clean, any colour', 25, 56
  UNION ALL SELECT 11, 'Winter Gloves',        'Pairs of warm gloves, no holes', 20, 8
  UNION ALL SELECT 12, 'Children''s T-shirts', 'Cotton t-shirts, clean and not faded', 22, 30
) n
WHERE MOD(ch.id + n.k, 3) <> 0
AND NOT EXISTS (SELECT 1 FROM clothes c WHERE c.charity_id = ch.id AND c.cloth_name = n.cloth_name);
