<?php
require_once __DIR__.'/../config/bootstrap.php';$error=null;$success=flash('success');$flashError=flash('error');
if($_SERVER['REQUEST_METHOD']==='POST'){csrf_check();$email=strtolower(trim($_POST['email']??''));$pass=$_POST['password']??'';$q=$pdo->prepare('SELECT id,account_type,full_name,email,password_hash,is_email_verified,account_status FROM users WHERE email=? LIMIT 1');$q->execute([$email]);$u=$q->fetch();
 if(!$u||!password_verify($pass,$u['password_hash']))$error='Adresse e-mail ou mot de passe incorrect.';
 elseif(!(int)$u['is_email_verified'])$error='Confirmez votre adresse e-mail avant la connexion.';
 elseif(in_array($u['account_status'],['blocked','rejected'],true))$error='Ce compte ne peut pas accéder à FIXI.';
 elseif($u['account_type']==='artisan'&&$u['account_status']!=='active')$error='Votre e-mail est confirmé. Votre profil attend la validation de FIXI.';
 elseif($u['account_status']!=='active')$error='Compte non activé.';
 else{session_regenerate_id(true);$_SESSION['user']=['id'=>(int)$u['id'],'type'=>$u['account_type'],'name'=>$u['full_name'],'email'=>$u['email']];if($u['account_type']==='admin')redirect('../admin/index.php');if($u['account_type']==='artisan')redirect('../artisan/index.php');redirect('../client/index.php');}}
$pageTitle='Connexion';require __DIR__.'/../includes/header.php';?>
<main class="container py-5"><div class="auth-card mx-auto"><span class="eyebrow">BIENVENUE SUR FIXI</span><h1 class="h2 mt-2">Connexion</h1><p class="text-secondary">Connectez-vous à votre espace.</p><?php if($success):?><div class="alert alert-success"><?=e($success)?></div><?php endif;?><?php if($flashError):?><div class="alert alert-danger"><?=e($flashError)?></div><?php endif;?><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?>
<form method="post" class="mt-4"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><label class="form-label">Adresse e-mail</label><input class="form-control mb-3" type="email" name="email" required><label class="form-label">Mot de passe</label><input class="form-control mb-3" type="password" name="password" required><button class="btn btn-fixi w-100">Connexion</button></form><p class="small text-secondary mt-3">Pas encore de compte ? <a href="register.php">Inscription</a></p></div></main><?php require __DIR__.'/../includes/footer.php';?>
