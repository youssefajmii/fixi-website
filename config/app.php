<?php
declare(strict_types=1);
define('FIXI_BASE_URL','http://localhost/FIXI');
define('FIXI_DEV_MODE',true); // false en production
if(session_status()!==PHP_SESSION_ACTIVE){ini_set('session.use_strict_mode','1');session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']),'samesite'=>'Lax']);session_start();}
