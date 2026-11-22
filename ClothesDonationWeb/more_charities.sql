-- Adds the national Red Cross / Red Crescent society to every country (map pin = the capital city, approximate).
-- Then gives every charity some demo needs. Safe to run again: it never adds the same thing twice.
INSERT INTO `charities` (`name`,`country`,`city`,`address`,`lat`,`lng`)
SELECT CONCAT(c.name, ' Red Cross / Red Crescent'), c.code, v.city, '', v.lat, v.lng
FROM `countries` c
JOIN (
SELECT 'XK' AS code, 'Pristina' AS city, 42.67 AS lat, 21.17 AS lng
UNION ALL SELECT 'AL','Tirana',41.33,19.82
UNION ALL SELECT 'MK','Skopje',41.99,21.43
UNION ALL SELECT 'ME','Podgorica',42.44,19.26
UNION ALL SELECT 'RS','Belgrade',44.79,20.45
UNION ALL SELECT 'BA','Sarajevo',43.86,18.41
UNION ALL SELECT 'HR','Zagreb',45.81,15.98
UNION ALL SELECT 'SI','Ljubljana',46.06,14.51
UNION ALL SELECT 'BG','Sofia',42.70,23.32
UNION ALL SELECT 'GR','Athens',37.98,23.73
UNION ALL SELECT 'TR','Ankara',39.93,32.86
UNION ALL SELECT 'RO','Bucharest',44.43,26.10
UNION ALL SELECT 'HU','Budapest',47.50,19.04
UNION ALL SELECT 'AT','Vienna',48.21,16.37
UNION ALL SELECT 'CH','Bern',46.95,7.45
UNION ALL SELECT 'DE','Berlin',52.52,13.40
UNION ALL SELECT 'FR','Paris',48.86,2.35
UNION ALL SELECT 'IT','Rome',41.90,12.50
UNION ALL SELECT 'ES','Madrid',40.42,-3.70
UNION ALL SELECT 'PT','Lisbon',38.72,-9.14
UNION ALL SELECT 'GB','London',51.51,-0.13
UNION ALL SELECT 'IE','Dublin',53.35,-6.26
UNION ALL SELECT 'NL','Amsterdam',52.37,4.90
UNION ALL SELECT 'BE','Brussels',50.85,4.35
UNION ALL SELECT 'SE','Stockholm',59.33,18.07
UNION ALL SELECT 'NO','Oslo',59.91,10.75
UNION ALL SELECT 'PL','Warsaw',52.23,21.01
UNION ALL SELECT 'US','Washington, D.C.',38.91,-77.04
UNION ALL SELECT 'CA','Ottawa',45.42,-75.70
UNION ALL SELECT 'AU','Canberra',-35.28,149.13
UNION ALL SELECT 'AD','Andorra la Vella',42.51,1.52
UNION ALL SELECT 'AM','Yerevan',40.18,44.51
UNION ALL SELECT 'AZ','Baku',40.41,49.87
UNION ALL SELECT 'BY','Minsk',53.90,27.57
UNION ALL SELECT 'CY','Nicosia',35.19,33.38
UNION ALL SELECT 'CZ','Prague',50.08,14.44
UNION ALL SELECT 'DK','Copenhagen',55.68,12.57
UNION ALL SELECT 'EE','Tallinn',59.44,24.75
UNION ALL SELECT 'FI','Helsinki',60.17,24.94
UNION ALL SELECT 'GE','Tbilisi',41.72,44.79
UNION ALL SELECT 'IS','Reykjavik',64.15,-21.94
UNION ALL SELECT 'LV','Riga',56.95,24.11
UNION ALL SELECT 'LI','Vaduz',47.14,9.52
UNION ALL SELECT 'LT','Vilnius',54.69,25.28
UNION ALL SELECT 'LU','Luxembourg',49.61,6.13
UNION ALL SELECT 'MT','Valletta',35.90,14.51
UNION ALL SELECT 'MD','Chisinau',47.01,28.86
UNION ALL SELECT 'MC','Monaco',43.73,7.42
UNION ALL SELECT 'SK','Bratislava',48.15,17.11
UNION ALL SELECT 'SM','San Marino',43.94,12.45
UNION ALL SELECT 'UA','Kyiv',50.45,30.52
UNION ALL SELECT 'RU','Moscow',55.76,37.62
UNION ALL SELECT 'DZ','Algiers',36.75,3.06
UNION ALL SELECT 'AO','Luanda',-8.84,13.23
UNION ALL SELECT 'BJ','Porto-Novo',6.50,2.63
UNION ALL SELECT 'BW','Gaborone',-24.65,25.91
UNION ALL SELECT 'BF','Ouagadougou',12.37,-1.52
UNION ALL SELECT 'BI','Bujumbura',-3.38,29.36
UNION ALL SELECT 'CM','Yaounde',3.85,11.50
UNION ALL SELECT 'CV','Praia',14.93,-23.51
UNION ALL SELECT 'CF','Bangui',4.36,18.56
UNION ALL SELECT 'TD','N''Djamena',12.13,15.06
UNION ALL SELECT 'CG','Brazzaville',-4.27,15.28
UNION ALL SELECT 'CD','Kinshasa',-4.44,15.27
UNION ALL SELECT 'CI','Abidjan',5.36,-4.01
UNION ALL SELECT 'DJ','Djibouti',11.59,43.15
UNION ALL SELECT 'EG','Cairo',30.04,31.24
UNION ALL SELECT 'GQ','Malabo',3.75,8.78
UNION ALL SELECT 'ER','Asmara',15.34,38.93
UNION ALL SELECT 'SZ','Mbabane',-26.31,31.14
UNION ALL SELECT 'ET','Addis Ababa',9.03,38.74
UNION ALL SELECT 'GA','Libreville',0.39,9.45
UNION ALL SELECT 'GM','Banjul',13.45,-16.58
UNION ALL SELECT 'GH','Accra',5.60,-0.19
UNION ALL SELECT 'GN','Conakry',9.64,-13.58
UNION ALL SELECT 'GW','Bissau',11.86,-15.60
UNION ALL SELECT 'KE','Nairobi',-1.29,36.82
UNION ALL SELECT 'LS','Maseru',-29.31,27.48
UNION ALL SELECT 'LR','Monrovia',6.30,-10.80
UNION ALL SELECT 'LY','Tripoli',32.89,13.19
UNION ALL SELECT 'MG','Antananarivo',-18.88,47.51
UNION ALL SELECT 'MW','Lilongwe',-13.96,33.77
UNION ALL SELECT 'ML','Bamako',12.64,-8.00
UNION ALL SELECT 'MR','Nouakchott',18.09,-15.98
UNION ALL SELECT 'MU','Port Louis',-20.16,57.50
UNION ALL SELECT 'MA','Rabat',34.02,-6.84
UNION ALL SELECT 'MZ','Maputo',-25.97,32.57
UNION ALL SELECT 'NA','Windhoek',-22.56,17.08
UNION ALL SELECT 'NE','Niamey',13.51,2.11
UNION ALL SELECT 'NG','Abuja',9.08,7.40
UNION ALL SELECT 'RW','Kigali',-1.95,30.06
UNION ALL SELECT 'ST','Sao Tome',0.34,6.73
UNION ALL SELECT 'SN','Dakar',14.72,-17.47
UNION ALL SELECT 'SC','Victoria',-4.62,55.45
UNION ALL SELECT 'SL','Freetown',8.48,-13.23
UNION ALL SELECT 'SO','Mogadishu',2.05,45.32
UNION ALL SELECT 'ZA','Pretoria',-25.75,28.19
UNION ALL SELECT 'SS','Juba',4.85,31.58
UNION ALL SELECT 'SD','Khartoum',15.50,32.56
UNION ALL SELECT 'TZ','Dar es Salaam',-6.79,39.21
UNION ALL SELECT 'TG','Lome',6.13,1.22
UNION ALL SELECT 'TN','Tunis',36.81,10.18
UNION ALL SELECT 'UG','Kampala',0.35,32.58
UNION ALL SELECT 'ZM','Lusaka',-15.39,28.32
UNION ALL SELECT 'ZW','Harare',-17.83,31.05
UNION ALL SELECT 'AF','Kabul',34.53,69.17
UNION ALL SELECT 'BH','Manama',26.23,50.59
UNION ALL SELECT 'BD','Dhaka',23.81,90.41
UNION ALL SELECT 'BT','Thimphu',27.47,89.64
UNION ALL SELECT 'BN','Bandar Seri Begawan',4.89,114.94
UNION ALL SELECT 'KH','Phnom Penh',11.56,104.93
UNION ALL SELECT 'CN','Beijing',39.90,116.41
UNION ALL SELECT 'IN','New Delhi',28.61,77.21
UNION ALL SELECT 'ID','Jakarta',-6.21,106.85
UNION ALL SELECT 'IR','Tehran',35.69,51.39
UNION ALL SELECT 'IQ','Baghdad',33.31,44.37
UNION ALL SELECT 'IL','Tel Aviv',32.08,34.78
UNION ALL SELECT 'JP','Tokyo',35.68,139.65
UNION ALL SELECT 'JO','Amman',31.95,35.93
UNION ALL SELECT 'KZ','Astana',51.17,71.43
UNION ALL SELECT 'KW','Kuwait City',29.38,47.99
UNION ALL SELECT 'KG','Bishkek',42.87,74.59
UNION ALL SELECT 'LA','Vientiane',17.98,102.63
UNION ALL SELECT 'LB','Beirut',33.89,35.50
UNION ALL SELECT 'MY','Kuala Lumpur',3.14,101.69
UNION ALL SELECT 'MV','Male',4.18,73.51
UNION ALL SELECT 'MN','Ulaanbaatar',47.89,106.91
UNION ALL SELECT 'MM','Yangon',16.87,96.20
UNION ALL SELECT 'NP','Kathmandu',27.72,85.32
UNION ALL SELECT 'KP','Pyongyang',39.04,125.76
UNION ALL SELECT 'OM','Muscat',23.59,58.41
UNION ALL SELECT 'PK','Islamabad',33.68,73.05
UNION ALL SELECT 'PS','Ramallah',31.90,35.20
UNION ALL SELECT 'PH','Manila',14.60,120.98
UNION ALL SELECT 'QA','Doha',25.29,51.53
UNION ALL SELECT 'SA','Riyadh',24.71,46.68
UNION ALL SELECT 'SG','Singapore',1.35,103.82
UNION ALL SELECT 'KR','Seoul',37.57,126.98
UNION ALL SELECT 'LK','Colombo',6.93,79.86
UNION ALL SELECT 'SY','Damascus',33.51,36.28
UNION ALL SELECT 'TW','Taipei',25.03,121.57
UNION ALL SELECT 'TJ','Dushanbe',38.56,68.77
UNION ALL SELECT 'TH','Bangkok',13.76,100.50
UNION ALL SELECT 'TL','Dili',-8.56,125.57
UNION ALL SELECT 'TM','Ashgabat',37.96,58.33
UNION ALL SELECT 'AE','Abu Dhabi',24.45,54.38
UNION ALL SELECT 'UZ','Tashkent',41.30,69.24
UNION ALL SELECT 'VN','Hanoi',21.03,105.85
UNION ALL SELECT 'YE','Sanaa',15.37,44.19
UNION ALL SELECT 'AR','Buenos Aires',-34.60,-58.38
UNION ALL SELECT 'BS','Nassau',25.05,-77.36
UNION ALL SELECT 'BB','Bridgetown',13.10,-59.61
UNION ALL SELECT 'BZ','Belmopan',17.25,-88.77
UNION ALL SELECT 'BO','La Paz',-16.50,-68.15
UNION ALL SELECT 'BR','Brasilia',-15.79,-47.88
UNION ALL SELECT 'CL','Santiago',-33.45,-70.67
UNION ALL SELECT 'CO','Bogota',4.71,-74.07
UNION ALL SELECT 'CR','San Jose',9.93,-84.08
UNION ALL SELECT 'CU','Havana',23.11,-82.37
UNION ALL SELECT 'DO','Santo Domingo',18.49,-69.93
UNION ALL SELECT 'EC','Quito',-0.18,-78.47
UNION ALL SELECT 'SV','San Salvador',13.69,-89.19
UNION ALL SELECT 'GT','Guatemala City',14.63,-90.51
UNION ALL SELECT 'GY','Georgetown',6.80,-58.16
UNION ALL SELECT 'HT','Port-au-Prince',18.59,-72.31
UNION ALL SELECT 'HN','Tegucigalpa',14.07,-87.19
UNION ALL SELECT 'JM','Kingston',17.97,-76.79
UNION ALL SELECT 'MX','Mexico City',19.43,-99.13
UNION ALL SELECT 'NI','Managua',12.11,-86.24
UNION ALL SELECT 'PA','Panama City',8.98,-79.52
UNION ALL SELECT 'PY','Asuncion',-25.26,-57.58
UNION ALL SELECT 'PE','Lima',-12.05,-77.04
UNION ALL SELECT 'SR','Paramaribo',5.85,-55.20
UNION ALL SELECT 'TT','Port of Spain',10.66,-61.51
UNION ALL SELECT 'UY','Montevideo',-34.90,-56.16
UNION ALL SELECT 'VE','Caracas',10.48,-66.90
UNION ALL SELECT 'FJ','Suva',-18.14,178.44
UNION ALL SELECT 'NZ','Wellington',-41.29,174.78
UNION ALL SELECT 'PG','Port Moresby',-9.44,147.18
UNION ALL SELECT 'WS','Apia',-13.83,-171.76
UNION ALL SELECT 'SB','Honiara',-9.43,159.95
UNION ALL SELECT 'TO','Nukualofa',-21.14,-175.20
UNION ALL SELECT 'VU','Port Vila',-17.73,168.32
) v ON v.code = c.code
WHERE NOT EXISTS (SELECT 1 FROM `charities` x WHERE x.country = c.code AND x.name = CONCAT(c.name, ' Red Cross / Red Crescent'));

-- Demo needs for every charity that does not have them yet (placeholder data)
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