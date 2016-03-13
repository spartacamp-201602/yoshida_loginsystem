<?php

define('DSN', 'mysql:host=localhost;dbname=login_system;charset=utf8');
define('DB_USER', 'testuser');
define('DB_PASSWORD', '9999');
//noticeエラーを便宜上表示させないようにする
//なくてもプログラム自体は動く
error_reporting(E_ALL & ~E_NOTICE);