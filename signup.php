<?php

require_once('config.php');
require_once('function.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $errors = array();

    // バリデーション
    if ($name == '') {
        $errors[] = 'ユーザネームが未入力です';
    }

    if ($password == '') {
        $errors[] = 'パスワードが未入力です';
    }

    // バリデーション突破後
    if (empty($errors)) {
        $dbh = connectDatabase();

        $sql = "insert into users (name, password, created_at) values
                (:name, :password, now());";
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $password);

        $stmt->execute();

        header('Location: login.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録画面</title>
</head>
<style>
.error {
    color: red;
    list-style: none;
}
</style>
<body>
    <h1>新規ユーザー登録</h1>

    <?php if (isset($errors)) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        ユーザネーム: <input type="text" name="name"><br>
        パスワード: <input type="text" name="password"><br>
        <input type="submit" value="新規登録">
    </form>
    <a href="login.php">ログインはこちら</a>
</body>
</html>