-- Run AFTER even_more_charities.sql.
-- Gives each NEW charity (Caritas ..., ... Community Clothing Bank, ... Warm Clothes Closet) exactly 5 different needs.
-- Different charities get different sets of 5 (picked from a pool of 20 products).
-- Step 1 removes the earlier demo needs of these charities, but ONLY those nobody has pledged to.
-- Safe to run again.

DELETE FROM clothes
WHERE charity_id IN (
  SELECT id FROM charities
  WHERE name LIKE 'Caritas %' OR name LIKE '% Community Clothing Bank' OR name LIKE '% Warm Clothes Closet'
)
AND NOT EXISTS (SELECT 1 FROM donations d WHERE d.cloth_id = clothes.id);

INSERT INTO clothes (cloth_name, cloth_desc, cloth_quantity, cloth_size, cloth_img, charity_id)
SELECT n.cloth_name, n.cloth_desc, n.qty + MOD(ch.id * 3, 7), n.sz, '', ch.id
FROM charities ch
JOIN (
  SELECT 1 AS k, 'Winter Coats' AS cloth_name, 'Warm, clean coats with working zippers' AS cloth_desc, 15 AS qty, 40 AS sz
  UNION ALL SELECT 2,  'Children''s Boots',     'Waterproof boots, clean and not damaged', 12, 32
  UNION ALL SELECT 3,  'Wool Sweaters',         'Thick sweaters, no holes or stains', 10, 42
  UNION ALL SELECT 4,  'Thermal Socks',         'New or very lightly used thermal socks', 30, 38
  UNION ALL SELECT 5,  'Women''s Jeans',        'Clean, wearable jeans without tears', 12, 38
  UNION ALL SELECT 6,  'Men''s Trousers',       'Clean, wearable trousers, any colour', 10, 44
  UNION ALL SELECT 7,  'Summer Dresses',        'Clean, no stains, light fabrics', 14, 36
  UNION ALL SELECT 8,  'Children''s Sweaters',  'Warm sweaters, clean, no stains', 18, 28
  UNION ALL SELECT 9,  'Rain Jackets',          'Waterproof jackets for adults and teens', 9, 44
  UNION ALL SELECT 10, 'Winter Hats',           'Warm hats, clean, any colour', 25, 56
  UNION ALL SELECT 11, 'Winter Gloves',         'Pairs of warm gloves, no holes', 20, 8
  UNION ALL SELECT 12, 'Children''s T-shirts',  'Cotton t-shirts, clean and not faded', 22, 30
  UNION ALL SELECT 13, 'Fleece Jackets',        'Soft fleece jackets with working zippers', 11, 46
  UNION ALL SELECT 14, 'Baby Onesies',          'Clean cotton onesies for babies', 20, 12
  UNION ALL SELECT 15, 'Thermal Underwear',     'Warm base layers, tops and bottoms', 16, 40
  UNION ALL SELECT 16, 'Work Boots',            'Sturdy boots with good soles', 8, 43
  UNION ALL SELECT 17, 'School Shirts',         'Clean white or light shirts for school', 24, 34
  UNION ALL SELECT 18, 'Pajama Sets',           'Clean, warm pajamas for adults and kids', 15, 36
  UNION ALL SELECT 19, 'Sports Shoes',          'Trainers in good condition, laces included', 10, 41
  UNION ALL SELECT 20, 'Scarves',               'Warm scarves, wool or fleece', 18, 50
) n
WHERE (ch.name LIKE 'Caritas %' OR ch.name LIKE '% Community Clothing Bank' OR ch.name LIKE '% Warm Clothes Closet')
AND MOD(n.k - 1 - MOD(ch.id, 20) + 20, 20) < 5
AND NOT EXISTS (SELECT 1 FROM clothes c WHERE c.charity_id = ch.id AND c.cloth_name = n.cloth_name);