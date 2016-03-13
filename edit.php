<?php

require_once('config.php');
require_once('function.php');

session_start();

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


//ユーザー情報の編集
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$dbh = connectDatabase();
// $sql = 'select * from users'
$sql = 'select name from users';
$stmt = $dbh->prepare($sql);
// 名前の同一バリデーション

// $stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();

$users = $stmt->fetchALL(PDO::FETCH_ASSOC);
// var_dump($user);
    $name = $_POST['name'];
    $password = $_POST['password'];

    $errors = array();

    if ($name == '') {
        $errors[] = 'ユーザネームが未入力です';
    }

    if ($password == '') {
        $errors[] = 'パスワードが未入力です';
    }
    if ($user["name"] != $name){
    foreach ($users as $user) {
    if ($user["name"] == $name){
        $errors[] = "同じユーザーネームが存在します";

    }
}
}




    //同一のユーザー名のバリデーション
    // if ($name_validation == $name) {
    //     $errors[] = '同一のユーザー名が登録されています。'
    // }

    if (empty($errors)) {
        $dbh = connectDatabase();

        $sql = "update users set name = :name, password = :password, created_at = now() where id = :id";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();

        header('Location: index.php');
        exit;
    }
}




?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザ情報編集画面</title>
</head>
<style>
.error {
    color: red;
    list-style: none;
}
</style>
<body>
    <h1>ユーザ情報編集</h1>
    <?php if (isset($errors)) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <form action="" method="post">
        ユーザネーム: <input type="text" name="name" value="<?php echo h($user['name']); ?>"><br>
        パスワード: <input type="text" name="password" value="<?php echo h($user['password']); ?>"><br>
        <input type="submit" value="編集する">
    </form>
    <a href="index.php">戻る</a>
</body>
</html>
