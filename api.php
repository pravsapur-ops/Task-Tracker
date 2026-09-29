<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/db.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function out(array $data, int $status=200): never { http_response_code($status); echo json_encode($data, JSON_UNESCAPED_UNICODE); exit; }
function input(): array { $raw=file_get_contents('php://input'); $j=json_decode($raw,true); return is_array($j)?$j:$_POST; }
function userId(): ?int { return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null; }
function requireLogin(): int { $id=userId(); if(!$id) out(['ok'=>false,'message'=>'Login required'],401); return $id; }
function currentUser(PDO $pdo): ?array { $id=userId(); if(!$id)return null; $s=$pdo->prepare('SELECT id,name,email,role,role_label,field_name,client_scope,phone,whatsapp_no,status FROM users WHERE id=?');$s->execute([$id]);return $s->fetch()?:null; }
function canManage(array $u): bool { return in_array($u['role'],['manager','team_leader'],true); }
function clientByName(PDO $pdo,string $name): ?int { $s=$pdo->prepare('SELECT id FROM clients WHERE name=? OR company_name=? LIMIT 1');$s->execute([$name,$name]);$v=$s->fetchColumn();return $v?(int)$v:null; }
function userByName(PDO $pdo,string $name): ?int { $s=$pdo->prepare('SELECT id FROM users WHERE name=? LIMIT 1');$s->execute([$name]);$v=$s->fetchColumn();return $v?(int)$v:null; }
function usersSafe(PDO $pdo): array { return $pdo->query("SELECT id,name,email,role,role_label,field_name AS field,client_scope AS client,phone,whatsapp_no,status FROM users ORDER BY name")->fetchAll(); }
function clients(PDO $pdo): array { return $pdo->query("SELECT id,company_name,name,contact_person,email,phone,whatsapp_no,website,work_model,status,platforms,monthly_deliverables,owner,notes FROM clients ORDER BY name")->fetchAll(); }
function members(PDO $pdo): array { return $pdo->query("SELECT id,name,email,phone,whatsapp_no,role,field_name AS field,field_name AS skills,work_model,status,client_scope AS notes FROM users WHERE role IN ('manager','team_leader','team_member') ORDER BY name")->fetchAll(); }
function tasks(PDO $pdo): array { $sql="SELECT t.id,t.title,t.platform,t.content_type,t.task_type,t.publish_at,t.due_date,t.status,t.approval_chain,t.notes,t.work_url,t.proof_url,t.attachment_link,c.name AS client,u.name AS assigned,t.created_at FROM tasks t LEFT JOIN clients c ON c.id=t.client_id LEFT JOIN users u ON u.id=t.assigned_user_id ORDER BY COALESCE(t.publish_at,CAST(t.due_date AS DATETIME)) DESC,t.id DESC";return $pdo->query($sql)->fetchAll(); }
function campaigns(PDO $pdo): array { $sql="SELECT c.id,c.title,c.platform,c.type,c.start_at,c.end_at,c.schedule_rule,c.objective,c.status,c.created_at,cl.name AS client,DATE_FORMAT(c.start_at,'%Y-%m-%d') AS date FROM campaigns c LEFT JOIN clients cl ON cl.id=c.client_id ORDER BY COALESCE(c.start_at,c.created_at) DESC,c.id DESC";return $pdo->query($sql)->fetchAll(); }
function meetings(PDO $pdo): array { $sql="SELECT m.id,DATE_FORMAT(m.meeting_date,'%Y-%m-%d') AS date,TIME_FORMAT(m.meeting_time,'%h:%i %p') AS time,m.title,m.participants,m.agenda,m.notes,m.followups,m.status,c.name AS client FROM meetings m LEFT JOIN clients c ON c.id=m.client_id ORDER BY m.meeting_date DESC,m.meeting_time DESC,m.id DESC";return $pdo->query($sql)->fetchAll(); }
function connections(PDO $pdo): array { $rows=$pdo->query("SELECT id,client_id,platform,account_name AS account,status,DATE_FORMAT(connected_on,'%Y-%m-%d') AS connectedOn,available_actions AS actions FROM client_connections ORDER BY client_id,platform")->fetchAll();$out=[];foreach($rows as $r){$out[(string)$r['client_id']][]=$r;}return $out; }
function approvals(PDO $pdo): array { $sql="SELECT a.id,a.item,a.approval_chain,a.approval_rule,a.current_step,a.status,a.created_at,c.name AS client,u.name AS creator FROM approvals a LEFT JOIN clients c ON c.id=a.client_id LEFT JOIN users u ON u.id=a.creator_user_id ORDER BY a.created_at DESC";return $pdo->query($sql)->fetchAll(); }
function notifications(PDO $pdo): array { $s=$pdo->prepare("SELECT id,title,message,source,is_read,created_at FROM notifications WHERE user_id IS NULL OR user_id=? ORDER BY created_at DESC LIMIT 50");$s->execute([userId()]);return $s->fetchAll(); }

$action=$_GET['action']??input()['action']??'';
$data=input();

try {
  if($action==='login'){
    $s=$pdo->prepare('SELECT id,name,email,password_hash,role,role_label,field_name,client_scope,status FROM users WHERE LOWER(email)=LOWER(?) LIMIT 1');$s->execute([(string)($data['email']??'')]);$u=$s->fetch();
    if(!$u || !password_verify((string)($data['password']??''),$u['password_hash'])) out(['ok'=>false,'message'=>'Invalid email or password'],401);
    if($u['status']==='Inactive') out(['ok'=>false,'message'=>'User account is inactive'],403);
    $_SESSION['user_id']=(int)$u['id'];
    unset($u['password_hash']);
    out(['ok'=>true,'user'=>$u,'users'=>usersSafe($pdo)]);
  }
  if($action==='logout'){session_destroy();out(['ok'=>true]);}
  $uid=requireLogin();$me=currentUser($pdo);if(!$me)out(['ok'=>false,'message'=>'User not found'],401);

  if($action==='bootstrap'){
    out(['ok'=>true,'user'=>$me,'users'=>usersSafe($pdo),'clients'=>clients($pdo),'members'=>members($pdo),'tasks'=>tasks($pdo),'campaigns'=>campaigns($pdo),'meetings'=>meetings($pdo),'connections'=>connections($pdo),'approvals'=>approvals($pdo),'notifications'=>notifications($pdo),'metrics'=>[]]);
  }

  if($action==='create_client'){
    if(!canManage($me))out(['ok'=>false,'message'=>'Only Managers and Team Leaders can add clients'],403);
    $s=$pdo->prepare("INSERT INTO clients(company_name,name,contact_person,email,phone,whatsapp_no,website,work_model,status,platforms,monthly_deliverables,owner,notes) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $s->execute([$data['company_name'],$data['name'],$data['name'],$data['email'],$data['phone']??null,$data['whatsapp_no']??null,$data['website']??null,$data['work_model']??'End-to-End Owner',$data['status']??'Active',$data['platforms']??null,$data['monthly_deliverables']??null,$data['owner']??null,$data['notes']??null]);
    $clientId=(int)$pdo->lastInsertId();
    $email=$data['email'];$check=$pdo->prepare('SELECT id FROM users WHERE email=?');$check->execute([$email]);
    if(!$check->fetchColumn()){$p=password_hash('Client@123',PASSWORD_DEFAULT);$s=$pdo->prepare("INSERT INTO users(name,email,password_hash,role,role_label,field_name,client_scope,status) VALUES(?,?,?,?,?,?,?,?)");$s->execute([$data['name'],$email,$p,'client','Client','Client Portal',$data['company_name'],'Active']);}
    out(['ok'=>true,'clients'=>clients($pdo),'users'=>usersSafe($pdo),'client_id'=>$clientId]);
  }

  if($action==='create_member'){
    if(!canManage($me))out(['ok'=>false,'message'=>'Only Managers and Team Leaders can add members'],403);
    $roleMap=['Team Member'=>'team_member','Team Leader'=>'team_leader','Manager'=>'manager'];$role=$roleMap[$data['role']??'Team Member']??'team_member';
    $s=$pdo->prepare("INSERT INTO users(name,email,password_hash,role,role_label,field_name,client_scope,phone,whatsapp_no,status) VALUES(?,?,?,?,?,?,?,?,?,?)");$s->execute([$data['name'],$data['email'],password_hash('Member@123',PASSWORD_DEFAULT),$role,$data['role']??'Team Member',$data['field']??null,$data['notes']??'Assigned clients',$data['phone']??null,$data['whatsapp']??null,$data['status']??'Active']);
    out(['ok'=>true,'members'=>members($pdo),'users'=>usersSafe($pdo),'member_id'=>(int)$pdo->lastInsertId()]);
  }

  if($action==='create_task' || $action==='create_calendar_event'){
    $clientId=clientByName($pdo,(string)($data['client']??''));$assignedId=userByName($pdo,(string)($data['assigned']??''));
    $publish=$data['publish']??null;$due=$data['due']??null;
    if($action==='create_calendar_event' && !$due && $publish)$due=substr((string)$publish,0,10);
    $s=$pdo->prepare("INSERT INTO tasks(client_id,assigned_user_id,created_by,title,platform,content_type,task_type,publish_at,due_date,status,approval_chain,notes,work_url,proof_url,attachment_link) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $s->execute([$clientId,$assignedId,$uid,$data['title']??'Task',$data['platform']??null,$data['content_type']??null,$data['type']??'One Day Task',$publish?:null,$due?:null,$data['status']??'Planned',$data['approvals']??($data['approval_chain']??null),$data['notes']??null,$data['work_url']??null,$data['proof']??null,$data['attachmentLink']??null]);
    $taskId=(int)$pdo->lastInsertId();
    if($action==='create_calendar_event' && $publish){$ev=$pdo->prepare("INSERT INTO calendar_events(task_id,client_id,assigned_user_id,event_date,event_time,title,platform,content_type,approval_chain,status,work_url) VALUES(?,?,?,?,?,?,?,?,?,?,?)");$ev->execute([$taskId,$clientId,$assignedId,substr($publish,0,10),strlen($publish)>10?substr(str_replace('T',' ',$publish),11,8):null,$data['title']??'Task',$data['platform']??null,$data['content_type']??null,$data['approval_chain']??null,$data['status']??'Scheduled',$data['work_url']??null]);}
    out(['ok'=>true,'task_id'=>$taskId,'tasks'=>tasks($pdo)]);
  }

  if($action==='bulk_import'){
    if(!canManage($me))out(['ok'=>false,'message'=>'Only Managers and Team Leaders can import calendars'],403);
    $csv=(string)($data['csv']??'');if($csv==='')out(['ok'=>false,'message'=>'CSV is empty']);
    $clientName=(string)($data['client']??'');$defaultClientId=$clientName==='All Clients'?null:clientByName($pdo,$clientName);$month=(string)($data['month']??date('Y-m'));
    $fh=fopen('php://temp','r+');fwrite($fh,$csv);rewind($fh);$headers=fgetcsv($fh);if(!$headers)out(['ok'=>false,'message'=>'CSV header is missing']);$headers=array_map(fn($h)=>strtolower(trim((string)$h)),$headers);$count=0;
    $insert=$pdo->prepare("INSERT INTO tasks(client_id,assigned_user_id,created_by,title,platform,content_type,publish_at,due_date,status,approval_chain,work_url,notes) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
    while(($row=fgetcsv($fh))!==false){$r=[];foreach($headers as $i=>$h)$r[$h]=$row[$i]??null;if(!($r['title']??''))continue;$cid=$defaultClientId?:clientByName($pdo,(string)($r['client']??''));$aid=userByName($pdo,(string)($r['assigned_to']??''));$date=(string)($r['date']??$month.'-01');$time=(string)($r['time']??'00:00');$publish=$date.' '.($time?:'00:00:00');$insert->execute([$cid,$aid,$uid,$r['title'],$r['platform']??null,$r['content_type']??null,$publish,$date,$r['status']??'Planned',$r['approval_chain']??null,$r['work_url']??null,$data['notes']??null]);$count++;}
    $log=$pdo->prepare('INSERT INTO bulk_imports(client_id,month_key,filename,notes,imported_rows,created_by) VALUES(?,?,?,?,?,?)');$log->execute([$defaultClientId,$month,$data['filename']??'calendar.csv',$data['notes']??null,$count,$uid]);
    out(['ok'=>true,'imported'=>$count,'tasks'=>tasks($pdo)]);
  }

  if($action==='attendance'){
    $target=(int)($data['user_id']??$uid);if($target!==$uid && !canManage($me))out(['ok'=>false,'message'=>'Not allowed'],403);$today=date('Y-m-d');
    if(($data['mode']??'')==='in'){$s=$pdo->prepare("INSERT INTO attendance(user_id,attendance_date,punch_in,status) VALUES(?,?,NOW(),'Present') ON DUPLICATE KEY UPDATE punch_in=NOW(),punch_out=NULL,status='Present'");$s->execute([$target,$today]);}
    else{$s=$pdo->prepare("UPDATE attendance SET punch_out=NOW() WHERE user_id=? AND attendance_date=?");$s->execute([$target,$today]);}
    $rows=$pdo->query("SELECT a.*,u.name FROM attendance a JOIN users u ON u.id=a.user_id ORDER BY attendance_date DESC,punch_in DESC LIMIT 200")->fetchAll();out(['ok'=>true,'attendance'=>$rows]);
  }

  if($action==='create_approval'){
    $cid=clientByName($pdo,(string)($data['client']??''));$s=$pdo->prepare("INSERT INTO approvals(client_id,item,creator_user_id,approval_chain,approval_rule,current_step,status) VALUES(?,?,?,?,?,?,?)");$s->execute([$cid,$data['item'],$uid,$data['tags']??null,$data['rule']??null,'Pending','Pending']);out(['ok'=>true,'approvals'=>approvals($pdo)]);
  }

  if($action==='approval_action'){
    $aid=(int)$data['approval_id'];$act=$data['action'];if(!in_array($act,['Approved','Revision','Rejected'],true))out(['ok'=>false,'message'=>'Invalid approval action']);$s=$pdo->prepare('UPDATE approvals SET status=?,current_step=? WHERE id=?');$s->execute([$act,$act,$aid]);$s=$pdo->prepare('INSERT INTO approval_actions(approval_id,actor_user_id,action,comment) VALUES(?,?,?,?)');$s->execute([$aid,$uid,$act,$data['comment']??null]);out(['ok'=>true,'approvals'=>approvals($pdo)]);
  }

  if($action==='create_campaign'){
    $cid=clientByName($pdo,(string)$data['client']);$s=$pdo->prepare("INSERT INTO campaigns(client_id,title,platform,type,start_at,end_at,schedule_rule,objective,status,created_by) VALUES(?,?,?,?,?,?,?,?,?,?)");$s->execute([$cid,$data['title'],$data['platform'],$data['type']??null,$data['start']??null,$data['end']??null,$data['schedule']??null,$data['objective']??null,$data['status']??'Ready',$uid]);out(['ok'=>true,'campaigns'=>campaigns($pdo)]);
  }

  if($action==='save_integration'){
    if(!canManage($me))out(['ok'=>false,'message'=>'Only Managers and Team Leaders can manage integrations'],403);$cid=(int)$data['client_id'];$s=$pdo->prepare("INSERT INTO client_connections(client_id,platform,account_name,status,connected_on,available_actions) VALUES(?,?,?,?,CASE WHEN ?='Connected' THEN CURDATE() ELSE NULL END,?)");$s->execute([$cid,$data['platform'],$data['account'],$data['status']??'Not connected',$data['status']??'Not connected',$data['actions']??null]);out(['ok'=>true,'connections'=>connections($pdo)]);
  }

  if($action==='create_meeting'){
    $cid=clientByName($pdo,(string)$data['client']);$s=$pdo->prepare("INSERT INTO meetings(client_id,meeting_date,meeting_time,title,participants,agenda,notes,followups,status,created_by) VALUES(?,?,?,?,?,?,?,?,?,?)");$s->execute([$cid,$data['date'],$data['time'],$data['title'],$data['participants']??null,$data['agenda']??null,$data['notes']??null,$data['followups']??null,$data['status']??'Scheduled',$uid]);out(['ok'=>true,'meetings'=>meetings($pdo)]);
  }

  if($action==='client_growth'){
    $cid=(int)($data['client_id']??0);$s=$pdo->prepare("SELECT views,leads,likes,followers,metric_date,engagement_rate FROM client_metrics WHERE client_id=? ORDER BY metric_date DESC LIMIT 12");$s->execute([$cid]);$rows=$s->fetchAll();$latest=$rows[0]??['views'=>0,'leads'=>0,'likes'=>0,'followers'=>0];$timeline=[];foreach($rows as $r){$timeline[]=['title'=>date('M d, Y',strtotime($r['metric_date'])).' — Client metric update','description'=>number_format((int)$r['views']).' views, '.number_format((int)$r['leads']).' leads, '.number_format((int)$r['likes']).' likes, '.number_format((int)$r['followers']).' followers; engagement '.($r['engagement_rate']??'—').'%'];}out(['ok'=>true,'kpis'=>[number_format((int)$latest['views']),number_format((int)$latest['leads']),number_format((int)$latest['likes']),number_format((int)$latest['followers'])],'timeline'=>$timeline]);
  }

  if($action==='work_rates'){
    $period=$_GET['period']??$data['period']??'monthly';$month=$_GET['month']??$data['month']??date('Y-m');$start=$period==='daily'?$month.'-'.date('d'):($month.'-01');$startDate=new DateTime($start);$end=new DateTime($start);if($period==='weekly')$end->modify('+6 days');elseif($period==='monthly')$end->modify('last day of this month');elseif($period==='yearly'){$startDate=new DateTime(substr($month,0,4).'-01-01');$end=new DateTime(substr($month,0,4).'-12-31');}else $end=$startDate;
    $sql="SELECT u.name,SUM(CASE WHEN t.status='Completed' AND t.due_date BETWEEN ? AND ? THEN 1 ELSE 0 END) completed,COUNT(CASE WHEN t.due_date BETWEEN ? AND ? THEN 1 END) total FROM users u LEFT JOIN tasks t ON t.assigned_user_id=u.id WHERE u.role IN ('manager','team_leader','team_member') GROUP BY u.id,u.name ORDER BY u.name";$s=$pdo->prepare($sql);$s->execute([$startDate->format('Y-m-d'),$end->format('Y-m-d'),$startDate->format('Y-m-d'),$end->format('Y-m-d')]);$rows=$s->fetchAll();$daily=(int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE status='Completed' AND due_date=CURDATE()")->fetchColumn();$weekly=(int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE status='Completed' AND YEARWEEK(due_date,1)=YEARWEEK(CURDATE(),1)")->fetchColumn();$monthly=(int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE status='Completed' AND YEAR(due_date)=YEAR(CURDATE()) AND MONTH(due_date)=MONTH(CURDATE())")->fetchColumn();$yearly=(int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE status='Completed' AND YEAR(due_date)=YEAR(CURDATE())")->fetchColumn();$label=['daily'=>'Daily Report','weekly'=>'Weekly Report','monthly'=>'Monthly Report','yearly'=>'Yearly Report'][$period]??'Report';$html='<div class="notice"><b>'.htmlspecialchars($label).'</b> · '.htmlspecialchars($month).'</div><div class="kpis"><div class="kpi">Daily completed<b>'.$daily.'</b></div><div class="kpi">Weekly completed<b>'.$weekly.'</b></div><div class="kpi">Monthly completed<b>'.$monthly.'</b></div><div class="kpi">Yearly completed<b>'.$yearly.'</b></div></div><h3 style="font-size:14px;margin-top:20px">Team Member Output</h3><table class="table"><tr><th>Member</th><th>Completed</th><th>Total Tasks</th></tr>';foreach($rows as $r)$html.='<tr><td>'.htmlspecialchars($r['name']).'</td><td>'.(int)$r['completed'].'</td><td>'.(int)$r['total'].'</td></tr>';$html.='</table>';out(['ok'=>true,'label'=>$label,'html'=>$html]);
  }

  out(['ok'=>false,'message'=>'Unknown action'],400);
} catch(Throwable $e) {
  error_log($e->getMessage());out(['ok'=>false,'message'=>$e->getMessage()],500);
}
