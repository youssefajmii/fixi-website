<?php
declare(strict_types=1);
function e(?string $v):string{return htmlspecialchars($v??'',ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function redirect(string $p):never{header('Location: '.$p);exit;}
function csrf_token():string{if(empty($_SESSION['csrf_token']))$_SESSION['csrf_token']=bin2hex(random_bytes(32));return $_SESSION['csrf_token'];}
function csrf_check():void{$s=$_POST['csrf_token']??'';if(!is_string($s)||!hash_equals($_SESSION['csrf_token']??'',$s)){http_response_code(403);exit('Requête invalide. Rechargez la page.');}}
function password_is_valid(string $p):bool{return strlen($p)>=8&&preg_match('/[A-Z]/',$p)&&preg_match('/[a-z]/',$p)&&preg_match('/[0-9]/',$p)&&preg_match('/[^A-Za-z0-9]/',$p);}
function current_user():?array{return $_SESSION['user']??null;}
function require_login():void{if(!current_user())redirect('../auth/login.php');}
function flash(string $k,?string $v=null):?string{if($v!==null){$_SESSION['flash'][$k]=$v;return null;}$x=$_SESSION['flash'][$k]??null;unset($_SESSION['flash'][$k]);return $x;}
