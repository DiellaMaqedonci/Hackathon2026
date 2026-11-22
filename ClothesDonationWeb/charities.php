<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['is_admin'])) { header("Location: dashboard.php"); exit; }

$err = '';
if (isset($_GET['delete'])) {
	$id = (int)$_GET['delete'];
	$conn->prepare("UPDATE clothes SET charity_id = NULL WHERE charity_id = :i")->execute([':i' => $id]);
	$conn->prepare("DELETE FROM charities WHERE id = :i")->execute([':i' => $id]);
	header("Location: charities.php"); exit;
}
$countries = $conn->query("SELECT * FROM countries ORDER BY name")->fetchAll();
if (isset($_POST['import_json'])) {
	header('Content-Type: application/json');
	$items = json_decode($_POST['import_json'], true); $cc = $_POST['country'] ?? '';
	$okc = false; foreach ($countries as $c) { if ($c['code'] === $cc) $okc = true; }
	$added = 0;
	if ($okc && is_array($items)) {
		$chk = $conn->prepare("SELECT 1 FROM charities WHERE country = :c AND name = :n AND ABS(lat - :la) < 0.0005 AND ABS(lng - :lo) < 0.0005 LIMIT 1");
		$ins = $conn->prepare("INSERT INTO charities(name, country, city, address, lat, lng) VALUES (:n, :c, :ci, :a, :la, :lo)");
		foreach (array_slice($items, 0, 150) as $it) {
			$n = mb_substr(trim((string)($it['name'] ?? '')), 0, 255);
			$la = $it['lat'] ?? null; $lo = $it['lng'] ?? null;
			if ($n === '' || !is_numeric($la) || !is_numeric($lo) || abs($la) > 90 || abs($lo) > 180) continue;
			$chk->execute([':c' => $cc, ':n' => $n, ':la' => $la, ':lo' => $lo]);
			if ($chk->fetch()) continue;
			$ins->execute([':n' => $n, ':c' => $cc, ':ci' => mb_substr(trim((string)($it['city'] ?? '')), 0, 120), ':a' => mb_substr(trim((string)($it['address'] ?? '')), 0, 255), ':la' => $la, ':lo' => $lo]);
			$added++;
		}
	}
	echo json_encode(['added' => $added]); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = trim($_POST['name'] ?? ''); $cc = $_POST['country'] ?? '';
	$city = trim($_POST['city'] ?? ''); $addr = trim($_POST['address'] ?? '');
	$lat = $_POST['lat'] ?? ''; $lng = $_POST['lng'] ?? '';
	$okc = false; foreach ($countries as $c) { if ($c['code'] === $cc) $okc = true; }
	if ($name === '' || !$okc) $err = 'Please enter a name and choose a country.';
	elseif (!is_numeric($lat) || !is_numeric($lng) || abs($lat) > 90 || abs($lng) > 180) $err = 'Click the map to place the charity first.';
	else {
		$st = $conn->prepare("INSERT INTO charities(name, country, city, address, lat, lng) VALUES (:n, :c, :ci, :a, :la, :lo)");
		$st->execute([':n'=>$name, ':c'=>$cc, ':ci'=>$city, ':a'=>$addr, ':la'=>$lat, ':lo'=>$lng]);
		header("Location: charities.php"); exit;
	}
}
$list = $conn->query("SELECT ch.*, co.name AS country_name FROM charities ch LEFT JOIN countries co ON co.code = ch.country ORDER BY co.name, ch.name")->fetchAll();
$my = $_COOKIE['country'] ?? 'XK';
$title = 'Charities'; $active = 'list_clothes.php';
?>
<?php
// Set $title and $active before including this file.
if (session_status() === PHP_SESSION_NONE) session_start();
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$title = $title ?? ''; $active = $active ?? '';
$in = !empty($_SESSION['username']); $adm = !empty($_SESSION['is_admin']);

function cloth_card($c){ ?>
<a class="cl" href="details.php?id=<?= (int)$c['id'] ?>">
  <div class="ph"><i class="bi bi-handbag"></i><?php if(!empty($c['cloth_img'])): ?><img src="<?= e($c['cloth_img']) ?>" alt="" loading="lazy" onerror="this.remove()"><?php endif; ?><span class="sz">Size <?= e($c['cloth_size']) ?></span></div>
  <div class="bd">
    <h3 class="h5 mb-1"><?= e($c['cloth_name']) ?></h3>
    <p class="text-secondary small mb-3"><?= e(mb_strimwidth((string)$c['cloth_desc'], 0, 70, '…')) ?></p>
    <span class="pill"><?= (int)$c['cloth_quantity'] ?> pieces needed</span>
  </div>
</a>
<?php } ?>
<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ? "$title · Spare Thread" : 'Spare Thread') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&family=Unbounded:wght@600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
:root{--ink:#0c1633;--ink2:#16254f;--denim:#3157c9;--sun:#ffc93c;--mint:#4fd1a1;--paper:#f3f5fb;--line:#e1e6f2;
--bs-body-bg:#f3f5fb;--bs-body-color:#0c1633;--bs-body-font-family:'Manrope',system-ui,sans-serif;--bs-primary:#3157c9;--bs-primary-rgb:49,87,201;--bs-link-color:#3157c9}
h1,h2,h3,h4,.brand,.num{font-family:'Unbounded',system-ui,sans-serif;letter-spacing:-.03em}
.btn{border-radius:99px;font-weight:700;padding:.6rem 1.4rem}
.btn-primary{--bs-btn-bg:var(--denim);--bs-btn-border-color:var(--denim);--bs-btn-hover-bg:#2444a8;--bs-btn-hover-border-color:#2444a8}
.btn-sun{--bs-btn-bg:var(--sun);--bs-btn-border-color:var(--sun);--bs-btn-color:var(--ink);--bs-btn-hover-bg:#ffd766;--bs-btn-hover-border-color:#ffd766;--bs-btn-hover-color:var(--ink);--bs-btn-active-bg:#f0b820;--bs-btn-active-color:var(--ink)}
.nav-dark{background:rgba(12,22,51,.88);backdrop-filter:blur(14px);border-bottom:1px solid rgba(255,255,255,.08)}
.brand{font-weight:800;color:#fff;font-size:1.15rem}.brand b{color:var(--sun)}
.nav-dark .nav-link{color:#c9d3f0;font-weight:600}.nav-dark .nav-link:hover{color:#fff}
.nav-dark .nav-link.active{color:var(--sun)}
.hero{background:radial-gradient(900px 520px at 88% 8%,rgba(255,201,60,.25),transparent 60%),radial-gradient(800px 600px at -5% 105%,rgba(49,87,201,.7),transparent 60%),var(--ink);color:#fff;min-height:92vh;display:flex;align-items:center;padding:4.5rem 0;position:relative;overflow:hidden}
.hero h1{font-size:clamp(2.5rem,6.6vw,5.4rem);line-height:1.02;font-weight:800}
.hero h1 em{font-style:normal;color:var(--sun)}
.hero .lead{color:#c9d3f0;max-width:34rem}
.float-tag{position:absolute;width:150px;background:#fff;color:var(--ink);border-radius:6px 6px 16px 16px;padding:1.5rem 1rem 1rem;box-shadow:0 20px 40px rgba(0,0,0,.35);animation:fl 7s ease-in-out infinite;opacity:.95}
.float-tag::before{content:"";position:absolute;top:9px;left:50%;width:12px;height:12px;margin-left:-6px;border-radius:50%;background:var(--ink)}
.float-tag .num{font-size:2rem;font-weight:800;color:var(--denim)}
.ft1{left:3%;bottom:7%;--r:-8deg}.ft2{left:38%;top:6%;--r:6deg;animation-delay:-3s}
@keyframes fl{0%,100%{transform:translateY(0) rotate(var(--r))}50%{transform:translateY(-18px) rotate(calc(var(--r) + 3deg))}}
.glass{background:rgba(255,255,255,.96);color:var(--ink);border-radius:26px;padding:2rem;box-shadow:0 30px 70px rgba(0,0,0,.4);position:relative;z-index:2}
.marquee{background:var(--sun);color:var(--ink);overflow:hidden;white-space:nowrap;padding:.9rem 0}
.marquee div{display:inline-block;animation:mq 30s linear infinite;font-family:'Unbounded';font-weight:700;font-size:1.05rem}
.marquee span{margin:0 1.6rem}
@keyframes mq{to{transform:translateX(-50%)}}
.band{background:radial-gradient(700px 300px at 90% 0,rgba(255,201,60,.22),transparent 60%),var(--ink);color:#fff;padding:3.5rem 0 4.5rem}
.band h1{font-size:clamp(1.9rem,4.5vw,3.2rem);font-weight:800;margin:0}
.band p{color:#c9d3f0;margin:.5rem 0 0}
.pull{margin-top:-2.5rem}
.panel{background:#fff;border:1px solid var(--line);border-radius:24px;padding:1.6rem;box-shadow:0 10px 30px rgba(12,22,51,.05)}
.step{background:var(--ink);color:#fff;border-radius:24px;padding:1.8rem;height:100%;position:relative;overflow:hidden}
.step .num{font-size:4.5rem;font-weight:800;color:transparent;-webkit-text-stroke:2px var(--sun);line-height:1}
.step p{color:#aebbe0;margin:0}
.statbox .num{font-size:clamp(2.2rem,4vw,3.2rem);font-weight:800;color:var(--sun);line-height:1}
.cl{display:block;background:#fff;border:1px solid var(--line);border-radius:22px;overflow:hidden;color:var(--ink);text-decoration:none;height:100%;transition:.35s}
.cl:hover{transform:translateY(-8px) rotate(-.6deg);box-shadow:0 26px 50px rgba(12,22,51,.18);color:var(--ink)}
.cl .ph{aspect-ratio:4/3;background:linear-gradient(135deg,var(--denim),var(--ink2));display:grid;place-items:center;color:var(--sun);font-size:3.4rem;position:relative;overflow:hidden}
.cl .ph img{width:100%;height:100%;object-fit:contain;background:#eef1fa;position:absolute;inset:0;transition:.5s}
.cl:hover .ph img{transform:none}
.cl .sz{position:absolute;top:12px;right:12px;background:var(--sun);color:var(--ink);font-family:'Unbounded';font-weight:800;font-size:.8rem;border-radius:12px;padding:.3rem .75rem;z-index:1}
.cl .bd{padding:1.1rem 1.25rem 1.3rem}
.pill{display:inline-block;font-size:.78rem;font-weight:700;padding:.25rem .7rem;border-radius:99px;background:#e8eefc;color:var(--denim)}
.rv{transition:opacity .7s,transform .7s}.js .rv{opacity:0;transform:translateY(30px)}.js .rv.in{opacity:1;transform:none}
.table thead th{font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;color:#6b789c;border-bottom:1px solid var(--line)}
.table>:not(caption)>*>*{padding:1rem .8rem}
.st-ok{background:#d9f5ea;color:#17694a}.st-wait{background:#e8eefc;color:var(--denim)}
.form-control,.form-select{border-radius:14px;padding:.7rem 1rem;border-color:var(--line)}
.form-control:focus,.form-select:focus{border-color:var(--denim);box-shadow:0 0 0 .22rem rgba(49,87,201,.18)}
.form-label{font-weight:700;font-size:.9rem}
.btn-check:checked+.slot{background:var(--ink);color:#fff;border-color:var(--ink)}
.footer{background:var(--ink);color:#9aa8d2}
@media(max-width:991px){.float-tag{display:none}.hero{min-height:auto}}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}.js .rv{opacity:1;transform:none}}
.leaflet-container a.btn-primary{color:#fff}.leaflet-popup-content{font-family:inherit}
</style>
</head><body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-md nav-dark sticky-top" data-bs-theme="dark"><div class="container">
  <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $in ? 'dashboard.php' : 'index.php' ?>">
    <svg width="40" height="40" viewBox="0 0 48 48" aria-hidden="true"><rect width="48" height="48" rx="14" fill="#ffc93c"/><path d="M24 21v-3.2a3.6 3.6 0 1 0-3.6-3.6" fill="none" stroke="#0c1633" stroke-width="2.6" stroke-linecap="round"/><path d="M24 21 11.5 29.6a2.2 2.2 0 0 0 1.3 4H35.2a2.2 2.2 0 0 0 1.3-4Z" fill="#0c1633"/><path d="M24 32.6l-3.2-3a2 2 0 0 1 2.9-2.8l.3.3.3-.3a2 2 0 0 1 2.9 2.8Z" fill="#ffc93c"/></svg>
    <span class="brand">Spare<b>Thread</b></span></a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Menu"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav ms-auto align-items-md-center gap-md-1">
    <?php $links = ['list_clothes.php'=>'Browse needs']; if($in){ $links['donations.php']='Pledges'; $links['dashboard.php']='Dashboard'; }
    foreach($links as $f=>$l): ?><li class="nav-item"><a class="nav-link <?= $active===$f?'active':'' ?>" href="<?= $f ?>"><?= $l ?></a></li><?php endforeach; ?>
    <?php if($in): ?>
      <li class="nav-item ms-md-2"><a class="btn btn-sun btn-sm" href="logout.php">Log out</a></li>
    <?php else: ?>
      <li class="nav-item"><a class="nav-link" href="login.php">Log in</a></li>
      <li class="nav-item ms-md-2"><a class="btn btn-sun btn-sm" href="index.php#join">Join free</a></li>
    <?php endif; ?>
  </ul></div>
</div></nav>
<main class="flex-grow-1">
<div class="band"><div class="container"><a class="text-white-50 small" href="list_clothes.php">← Browse needs</a><h1 class="mt-2">Charities</h1><p>Add a charity and click its location on the map.</p></div></div>
<div class="container pull"><div class="row g-4">
 <div class="col-lg-6"><form method="post" action="charities.php" class="panel" id="cform">
  <?php if($err): ?><div class="alert alert-danger py-2"><?= e($err) ?></div><?php endif; ?>
  <div class="row g-3">
   <div class="col-12"><label class="form-label" for="name">Charity name</label><input class="form-control" id="name" name="name" required></div>
   <div class="col-md-6"><label class="form-label" for="ccountry">Country</label><select class="form-select" id="ccountry" name="country" required><?php foreach($countries as $c): ?><option value="<?= e($c['code']) ?>" data-lat="<?= e($c['lat']) ?>" data-lng="<?= e($c['lng']) ?>" data-zoom="<?= (int)$c['zoom'] ?>" <?= $my===$c['code']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
   <div class="col-md-6"><label class="form-label" for="city">City</label><input class="form-control" id="city" name="city"></div>
   <div class="col-12"><label class="form-label" for="address">Address</label><div class="input-group"><input class="form-control" id="address" name="address" placeholder="Street and number"><button type="button" class="btn btn-outline-secondary" id="find">Find on map</button></div><div class="form-text">Type the address and press Find, or just click the map.</div></div>
   <input type="hidden" name="lat" id="lat"><input type="hidden" name="lng" id="lng">
  </div>
  <button class="btn btn-primary mt-4 px-4">Save charity</button>
 </form></div>
 <div class="col-lg-6"><div class="panel p-0 overflow-hidden"><div id="pick" style="height:420px"></div></div></div>
</div>

<div class="panel mt-4"><h2 class="h5 mb-1"><i class="bi bi-cloud-download"></i> Import real charities from OpenStreetMap</h2>
 <p class="text-secondary small">Finds real charity shops in a country (shops that take clothes) and adds them to the map. Up to 120 per click. Run it again for more.</p>
 <div class="row g-2 align-items-center"><div class="col-md-5"><select class="form-select" id="impCountry"><?php foreach($countries as $c): ?><option value="<?= e($c['code']) ?>" <?= $my===$c['code']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
 <div class="col-auto"><button type="button" class="btn btn-primary" id="imp">Import</button></div><div class="col"><span id="impOut" class="text-secondary"></span></div></div></div>

<div class="panel p-0 overflow-hidden mt-4"><div class="table-responsive"><table class="table align-middle mb-0">
 <thead><tr><th>Charity</th><th>Country</th><th>City</th><th></th></tr></thead><tbody>
 <?php foreach($list as $l): ?><tr><td class="fw-bold"><?= e($l['name']) ?></td><td><?= e($l['country_name']) ?></td><td><?= e($l['city']) ?></td>
  <td class="text-end"><a class="btn btn-sm btn-outline-danger" href="charities.php?delete=<?= (int)$l['id'] ?>" data-confirm="Delete this charity? Its needs stay but lose the charity.">Delete</a></td></tr><?php endforeach; ?>
 <?php if(!$list): ?><tr><td colspan="4" class="text-center text-secondary py-4">No charities yet.</td></tr><?php endif; ?>
</tbody></table></div></div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const sel = document.getElementById('ccountry');
const map = L.map('pick');
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'}).addTo(map);
let pin = null;
function center() { const o = sel.selectedOptions[0]; map.setView([+o.dataset.lat, +o.dataset.lng], +o.dataset.zoom); }
function place(lat, lng) {
  if (pin) pin.setLatLng([lat, lng]); else pin = L.marker([lat, lng]).addTo(map);
  document.getElementById('lat').value = lat.toFixed(6); document.getElementById('lng').value = lng.toFixed(6);
}
center(); sel.addEventListener('change', center);
map.on('click', e => place(e.latlng.lat, e.latlng.lng));
document.getElementById('find').addEventListener('click', async () => {
  const q = document.getElementById('address').value + ' ' + document.getElementById('city').value + ' ' + sel.selectedOptions[0].text;
  try {
    const r = await (await fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(q))).json();
    if (r.length) { place(+r[0].lat, +r[0].lon); map.setView([+r[0].lat, +r[0].lon], 15); } else alert('Address not found. Click the map instead.');
  } catch (e) { alert('Search failed. Click the map instead.'); }
});
document.getElementById('cform').addEventListener('submit', e => { if (!document.getElementById('lat').value) { e.preventDefault(); alert('Click the map to place the charity first.'); } });
</script>
<script>
document.getElementById('imp').addEventListener('click', async () => {
  const sel = document.getElementById('impCountry'), cc = sel.value, name = sel.selectedOptions[0].text.replace(/"/g, '');
  const out = document.getElementById('impOut'), btn = document.getElementById('imp');
  btn.disabled = true; out.textContent = 'Searching OpenStreetMap…';
  const q = area => '[out:json][timeout:60];' + area + '->.a;(node["shop"="charity"](area.a);way["shop"="charity"](area.a););out center tags 120;';
  async function run(area) {
    const r = await fetch('https://overpass-api.de/api/interpreter', {method: 'POST', body: 'data=' + encodeURIComponent(q(area))});
    return (await r.json()).elements || [];
  }
  try {
    let els = await run('area["ISO3166-1:alpha2"="' + cc + '"]');
    if (!els.length) els = await run('area["name:en"="' + name + '"]["boundary"="administrative"]');
    const items = els.map(e => { const t = e.tags || {}; return {
      name: t.name, lat: e.lat !== undefined ? e.lat : (e.center && e.center.lat), lng: e.lon !== undefined ? e.lon : (e.center && e.center.lon),
      city: t['addr:city'] || '', address: [t['addr:street'], t['addr:housenumber']].filter(Boolean).join(' ') }; })
      .filter(i => i.name && i.lat !== undefined && i.lat !== null);
    if (!items.length) { out.textContent = 'No charity shops found for ' + name + ' on OpenStreetMap. Add charities by hand instead.'; btn.disabled = false; return; }
    const fd = new FormData(); fd.append('country', cc); fd.append('import_json', JSON.stringify(items));
    const res = await (await fetch('charities.php', {method: 'POST', body: fd})).json();
    out.textContent = 'Imported ' + res.added + ' new charities (' + items.length + ' found). Reloading…';
    setTimeout(() => location.reload(), 1200);
  } catch (e) { out.textContent = 'Import failed. Check your internet connection and try again in a minute.'; btn.disabled = false; }
});
</script>
</main>
<footer class="footer py-4 mt-5"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-handbag text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© <?= date('Y') ?></span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.documentElement.classList.add('js');
document.addEventListener('DOMContentLoaded',()=>{
  const io=new IntersectionObserver(es=>es.forEach(x=>{if(x.isIntersecting){x.target.classList.add('in');io.unobserve(x.target)}}),{threshold:.12});
  document.querySelectorAll('.rv').forEach((el,i)=>{el.style.transitionDelay=(i%4)*90+'ms';io.observe(el)});
  document.querySelectorAll('[data-count]').forEach(el=>{
    const end=+el.dataset.count;let n=0;const step=Math.max(1,Math.ceil(end/40));
    const t=setInterval(()=>{n=Math.min(end,n+step);el.textContent=n;if(n>=end)clearInterval(t)},35);
  });
  const q=document.getElementById('q'),cols=document.querySelectorAll('.cl-col'),empty=document.getElementById('emptyMsg');
  q&&q.addEventListener('input',()=>{let s=0;cols.forEach(c=>{const ok=c.dataset.name.includes(q.value.toLowerCase());c.hidden=!ok;if(ok)s++});if(empty)empty.hidden=s>0});
  const pw=document.getElementById('password'),tg=document.getElementById('togglePw');
  tg&&tg.addEventListener('click',()=>{const s=pw.type==='password';pw.type=s?'text':'password';tg.innerHTML=s?'<i class="bi bi-eye-slash"></i>':'<i class="bi bi-eye"></i>'});
  const d=document.getElementById('date');d&&(d.min=new Date().toISOString().split('T')[0]);
  document.querySelectorAll('[data-confirm]').forEach(el=>el.addEventListener('click',e=>{if(!confirm(el.dataset.confirm))e.preventDefault()}));
});
</script>
</body></html>