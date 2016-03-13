<?php

require_once('config.php');
require_once('function.php');

//セッション開始
session_start();

//もし$_SESSION['id']が何もなければ、=>login.phpにリダイレクト
if (empty($_SESSION['id']))
{
    header('Location: login.php');
    exit;
}

$dbh = connectDatabase();
$sql = 'select * from users where id = :id';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($user);


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員限定画面</title>
</head>
<body>
    <h1>登録したユーザーのみ閲覧可能です！</h1>
    <h2><?php echo h($user['name']) ?>さんようこそ！</h2>
    <p><a href="logout.php">ログアウト</a></p>
</body>
</html>
