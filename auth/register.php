<?php
require_once __DIR__.'/../config/bootstrap.php';
$errors=[];$fullName='';$email='';$phone='';$city='';$type=(($_GET['type']??$_POST['account_type']??'client')==='artisan')?'artisan':'client';
if($_SERVER['REQUEST_METHOD']==='POST'){
 csrf_check();$fullName=trim($_POST['fullname']??'');$email=strtolower(trim($_POST['email']??''));$phone=trim($_POST['phone']??'');$city=trim($_POST['city']??'');$password=$_POST['password']??'';$confirm=$_POST['password_confirm']??'';$birth=trim($_POST['birth_date']??'');
 if(mb_strlen($fullName)<3||mb_strlen($fullName)>150)$errors[]='Nom complet invalide.';
 if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]='Adresse e-mail invalide.';
 if($phone===''||mb_strlen($phone)>30)$errors[]='Téléphone invalide.';
 if($city===''||mb_strlen($city)>100)$errors[]='Ville invalide.';
 if(!password_is_valid($password))$errors[]='Mot de passe : 8 caractères minimum, majuscule, minuscule, chiffre et symbole.';
 if($password!==$confirm)$errors[]='Les mots de passe ne correspondent pas.';
 $d=DateTime::createFromFormat('Y-m-d',$birth);
 if(!$d||$d->format('Y-m-d')!==$birth||$d>(new DateTime('today'))->modify('-18 years'))$errors[]='Inscription réservée aux personnes de 18 ans ou plus.';
 if(!isset($_POST['terms']))$errors[]='Veuillez accepter les conditions.';
 $profession=trim($_POST['main_profession']??'');if($type==='artisan'&&$profession==='')$errors[]='Choisissez votre métier principal.';
 if(!$errors){$q=$pdo->prepare('SELECT id FROM users WHERE email=?');$q->execute([$email]);if($q->fetch())$errors[]='Cette adresse e-mail est déjà utilisée.';else{
  $pdo->beginTransaction();try{$q=$pdo->prepare("INSERT INTO users(account_type,full_name,email,phone,password_hash,city,birth_date,account_status,is_email_verified) VALUES(?,?,?,?,?,?,?,'pending',0)");$q->execute([$type,$fullName,$email,$phone,password_hash($password,PASSWORD_DEFAULT),$city,$birth]);$uid=(int)$pdo->lastInsertId();
   if($type==='artisan'){$q=$pdo->prepare('INSERT INTO artisan_profiles(user_id,main_profession) VALUES(?,?)');$q->execute([$uid,$profession]);}
   $token=bin2hex(random_bytes(32));$q=$pdo->prepare('INSERT INTO email_verifications(user_id,token_hash,expires_at) VALUES(?,?,DATE_ADD(NOW(),INTERVAL 24 HOUR))');$q->execute([$uid,hash('sha256',$token)]);$pdo->commit();
   $url=FIXI_BASE_URL.'/auth/verify.php?token='.urlencode($token);
   if(FIXI_DEV_MODE){$dir=__DIR__.'/../storage';if(!is_dir($dir))mkdir($dir,0700,true);file_put_contents($dir.'/mail_preview.txt',"{$email}
{$url}

",FILE_APPEND|LOCK_EX);flash('success','Compte créé. En mode local, le lien est dans storage/mail_preview.txt.');}
   else{$sent=mail($email,'Vérification FIXI',"Bonjour {$fullName}, confirmez votre e-mail : {$url}",'From: '.FIXI_MAIL_FROM);flash($sent?'success':'error',$sent?'Consultez votre e-mail pour confirmer votre compte.':'Envoi e-mail impossible. Contactez FIXI.');}
   redirect('login.php');
  }catch(Throwable $ex){if($pdo->inTransaction())$pdo->rollBack();$errors[]='Erreur lors de la création. Vérifiez le schéma SQL.';}
 }}
}
$pageTitle='Inscription';require __DIR__.'/../includes/header.php';?>
<main class="container py-5"><div class="auth-card mx-auto"><span class="eyebrow">REJOIGNEZ FIXI</span><h1 class="h2 mt-2">Créer un compte</h1><p class="text-secondary">Réservé aux personnes de 18 ans ou plus.</p>
<?php foreach($errors as $er):?><div class="alert alert-danger"><?=e($er)?></div><?php endforeach;?>
<div class="row g-2 mt-3"><div class="col-6"><a class="btn <?=$type==='client'?'btn-fixi':'btn-outline-secondary'?> w-100" href="register.php?type=client">Client</a></div><div class="col-6"><a class="btn <?=$type==='artisan'?'btn-fixi':'btn-outline-secondary'?> w-100" href="register.php?type=artisan">Artisan</a></div></div>
<form method="post" class="mt-4"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="account_type" value="<?=e($type)?>">
<label class="form-label">Nom et prénom</label><input class="form-control mb-3" name="fullname" value="<?=e($fullName)?>" required maxlength="150">
<label class="form-label">Adresse e-mail</label><input class="form-control mb-3" type="email" name="email" value="<?=e($email)?>" required>
<label class="form-label">Téléphone</label><input class="form-control mb-3" type="tel" name="phone" value="<?=e($phone)?>" required>
<label class="form-label">Ville</label><input class="form-control mb-3" name="city" value="<?=e($city)?>" required>
<?php if($type==='artisan'):?><label class="form-label">Métier principal *</label><select class="form-select mb-3" name="main_profession" required><option value="">Choisir un métier</option><?php foreach($pdo->query('SELECT name_fr FROM professions WHERE is_active=1 ORDER BY name_fr') as $p):?><option value="<?=e($p['name_fr'])?>"><?=e($p['name_fr'])?></option><?php endforeach;?><option value="Autre">Autre (à valider)</option></select><?php endif;?>
<label class="form-label">Date de naissance</label><input class="form-control mb-3" type="date" name="birth_date" max="<?=date('Y-m-d',strtotime('-18 years'))?>" required>
<label class="form-label">Mot de passe</label><input class="form-control mb-2" type="password" name="password" minlength="8" required><div class="form-text mb-3">8 caractères minimum, majuscule, minuscule, chiffre et symbole.</div>
<label class="form-label">Confirmer le mot de passe</label><input class="form-control mb-3" type="password" name="password_confirm" minlength="8" required>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="terms" id="terms" required><label class="form-check-label small" for="terms">J'accepte les conditions d'utilisation et confirme l'exactitude de mes informations.</label></div><button class="btn btn-fixi w-100" type="submit">Créer mon compte</button></form><p class="small text-secondary mt-3">Déjà inscrit ? <a href="login.php">Connexion</a></p></div></main><?php require __DIR__.'/../includes/footer.php';?>
