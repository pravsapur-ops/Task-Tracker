<?php
declare(strict_types=1);
$config = require __DIR__ . '/config.php';
try {
  $pdo = new PDO("mysql:host={$config['host']};port={$config['port']};charset={$config['charset']}", $config['username'], $config['password'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
  $dbName = preg_replace('/[^a-zA-Z0-9_]/','',$config['database']);
  $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
  $sql = file_get_contents(__DIR__.'/database.sql');
  $statements = preg_split('/;\s*(?:\r?\n|$)/', $sql);
  foreach($statements as $statement){$statement=trim($statement);if($statement) $pdo->exec($statement);}
  $pdo->exec("USE `{$dbName}`");

  $users = [
    ['Priya','manager@tasktracker.local','Admin@123','manager','Manager','Digital Marketing Manager','All Clients'],
    ['Priya Team Leader','leader@tasktracker.local','Admin@123','team_leader','Team Leader','Social Media & Client Delivery','All Clients'],
    ['Ravi Kumar','ravi@tasktracker.local','Member@123','team_member','Team Member','Instagram / Social Media','Client A, Client B, Client C'],
    ['Neha Sharma','neha@tasktracker.local','Member@123','team_member','Team Member','Meta Ads / Design','Client A, Client B, Client C'],
    ['Arjun Rao','arjun@tasktracker.local','Member@123','team_member','Team Member','YouTube / WhatsApp','Client A, Client B, Client C'],
  ];
  $clientUsers = [
    ['Client A','clienta@tasktracker.local','Client@123','client','Client','Client Portal','Client A'],
    ['Client B','clientb@tasktracker.local','Client@123','client','Client','Client Portal','Client B'],
    ['Client C','clientc@tasktracker.local','Client@123','client','Client','Client Portal','Client C'],
  ];
  $stmt=$pdo->prepare("INSERT INTO users(name,email,password_hash,role,role_label,field_name,client_scope) VALUES(?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE name=VALUES(name),role=VALUES(role),role_label=VALUES(role_label),field_name=VALUES(field_name),client_scope=VALUES(client_scope)");
  foreach(array_merge($users,$clientUsers) as $u){$stmt->execute([$u[0],$u[1],password_hash($u[2],PASSWORD_DEFAULT),$u[3],$u[4],$u[5],$u[6]]);}

  $clients=[
    ['Client A','Client A','Primary Contact','clienta@tasktracker.local','+91 90000 00001','https://example.com','End-to-End Owner','Active','Instagram, YouTube, WhatsApp, Meta Ads','20 posts, 4 reels, 2 videos','Ravi Kumar','Approval through client portal.'],
    ['Client B','Client B','Primary Contact','clientb@tasktracker.local','+91 90000 00002','https://example.com','Platform Experts','Active','Instagram, YouTube, WhatsApp, Meta Ads','16 posts, 4 reels, 2 campaigns','Platform Team','Platform-wise allocation.'],
    ['Client C','Client C','Primary Contact','clientc@tasktracker.local','+91 90000 00003','https://example.com','Hybrid','Active','Instagram, YouTube, WhatsApp','12 posts, 4 reels, 1 video','Arjun Rao','Hybrid delivery model.'],
  ];
  $stmt=$pdo->prepare("INSERT INTO clients(company_name,name,contact_person,email,phone,website,work_model,status,platforms,monthly_deliverables,owner,notes) VALUES(?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE name=VALUES(name),contact_person=VALUES(contact_person),email=VALUES(email),phone=VALUES(phone),website=VALUES(website),work_model=VALUES(work_model),status=VALUES(status),platforms=VALUES(platforms),monthly_deliverables=VALUES(monthly_deliverables),owner=VALUES(owner),notes=VALUES(notes)");
  // Email is not unique in clients, so avoid duplicates by checking first.
  foreach($clients as $c){$q=$pdo->prepare('SELECT id FROM clients WHERE email=? LIMIT 1');$q->execute([$c[3]]);if($q->fetchColumn()){continue;}$stmt->execute($c);}

  $clientIds=[];$q=$pdo->query('SELECT id,name FROM clients');foreach($q as $r)$clientIds[$r['name']]=(int)$r['id'];
  $seedMetrics=[['Client A','2026-07-31',31200,131,1800,9000,5.2],['Client A','2026-08-31',39400,152,2600,10800,5.9],['Client A','2026-09-24',48600,186,3920,12800,6.4],['Client B','2026-09-24',42100,164,3410,10900,6.1],['Client C','2026-09-24',35700,121,2880,9600,5.7]];
  $stmt=$pdo->prepare("INSERT INTO client_metrics(client_id,metric_date,views,leads,likes,followers,engagement_rate) VALUES(?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE views=VALUES(views),leads=VALUES(leads),likes=VALUES(likes),followers=VALUES(followers),engagement_rate=VALUES(engagement_rate)");
  foreach($seedMetrics as $m){if(isset($clientIds[$m[0]]))$stmt->execute([$clientIds[$m[0]],$m[1],$m[2],$m[3],$m[4],$m[5],$m[6]]);}
  echo '<h2>Task Tracker installation completed.</h2><p>Database and demo accounts were created. Delete or rename install.php after setup.</p><p>Login: manager@tasktracker.local / Admin@123</p><p>Team leader: leader@tasktracker.local / Admin@123</p><p>Members: ravi@tasktracker.local / Member@123</p><p>Clients: clienta@tasktracker.local / Client@123</p>';
} catch(Throwable $e){http_response_code(500);echo '<h2>Installation failed</h2><pre>'.htmlspecialchars($e->getMessage()).'</pre>';}
