<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
$id = (int)($_GET['id'] ?? 0);
$st = $conn->prepare("SELECT clothes.*, ch.name AS charity_name, ch.city AS charity_city, ch.address AS charity_address FROM clothes LEFT JOIN charities ch ON ch.id = clothes.charity_id WHERE clothes.id=:id"); $st->bindParam(":id", $id, PDO::PARAM_INT); $st->execute();
$cloth_data = $st->fetch();
if (!$cloth_data) { header("Location: list_clothes.php"); exit; }
$_SESSION['cloth_id'] = $id;
$title = $cloth_data['cloth_name']; $active = 'list_clothes.php'; ?>
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

<div class="band"><div class="container"><a class="text-white-50 small" href="list_clothes.php">← All needs</a><h1 class="mt-2"><?= e($cloth_data['cloth_name']) ?></h1><?php if(!empty($cloth_data['charity_name'])): ?><p><i class="bi bi-geo-alt"></i> <?= e($cloth_data['charity_name']) ?><?= $cloth_data['charity_city'] ? ' · '.e($cloth_data['charity_city']) : '' ?><?= $cloth_data['charity_address'] ? ' · '.e($cloth_data['charity_address']) : '' ?></p><?php endif; ?></div></div>
<div class="container pull"><div class="row g-4">
 <div class="col-lg-7"><div class="cl" style="transform:none"><div class="ph" style="aspect-ratio:4/3"><i class="bi bi-handbag"></i><?php if(!empty($cloth_data['cloth_img'])): ?><img src="<?= e($cloth_data['cloth_img']) ?>" alt="" onerror="this.remove()"><?php endif; ?><span class="sz">Size <?= e($cloth_data['cloth_size']) ?></span></div>
  <div class="bd p-4"><span class="pill mb-3"><?= (int)$cloth_data['cloth_quantity'] ?> pieces needed</span><p class="mb-0 fs-5"><?= nl2br(e($cloth_data['cloth_desc'])) ?></p></div></div></div>
 <div class="col-lg-5"><form method="post" action="donate.php" class="panel">
  <h2 class="h4 mb-4">Pledge &amp; book a drop-off</h2>
  <div class="mb-3"><label class="form-label" for="nr_donations">How many pieces?</label><input type="number" class="form-control" id="nr_donations" name="nr_donations" min="1" max="<?= (int)$cloth_data['cloth_quantity'] ?>" value="1" required></div>
  <div class="mb-3"><label class="form-label" for="date">Drop-off day</label><input type="date" class="form-control" id="date" name="date" required></div>
  <div class="mb-4"><span class="form-label d-block">Time</span><div class="d-flex flex-wrap gap-2">
   <?php foreach(['09:00','10:00','11:00','14:00','16:00'] as $i=>$t): ?><input type="radio" class="btn-check" name="time" id="t<?= $i ?>" value="<?= $t ?>" <?= $i?'':'checked' ?>><label class="btn btn-outline-primary slot" for="t<?= $i ?>"><?= $t ?></label><?php endforeach; ?>
  </div></div>
  <button class="btn btn-sun w-100 py-3">Confirm pledge</button>
 </form></div>
</div></div>
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