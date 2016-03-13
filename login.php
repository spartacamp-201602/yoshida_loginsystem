<?php

require_once('config.php');
require_once('function.php');

session_start();

//$_SESSION['id']の中身がある=>ログインしているのにログイン画面に来ている
//ログイン情報を破棄して、ログイン画面に飛ばす
if (!empty($_SESSION['id']))
{
    unset($_SESSION['id']);
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST['name'];
    $password = $_POST['password'];

    //バリデーション
    $errors = array();
    if (empty($name))
    {
        $errors[] = 'ユーザーネームが未入力です';
    }

    if (empty($password))
    {
        $errors[] = 'パスワードが未入力です';
    }

    //バリデーション突破時
    if (empty($errors))
    {
        $dbh = connectDatabase();
        $sql = 'select * from users where ';
        $sql.= 'name = :name and password = :password';
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        var_dump($row);

        //$rowが存在したら、$_SESSION['id']に$row連想配列のキー['id']の要素を代入する。
        if ($row)
        {
            $_SESSION['id'] = $row['id'];
            header('Location: index.php');
            exit;
        }
        else
        {
            $errors[] = 'ユーザーネームかパスワードが間違っています。';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
</head>
<body>
    <h1>ログイン画面です</h1>
    <?php if (isset($errors)): ?>
        <div class="error">
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error ?></li>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    <form action="" method="post">
        ユーザネーム: <input type="text" name="name"><br>
        パスワード: <input type="text" name="password"><br>
        <input type="submit" value="ログイン">
    </form>
    <a href="signup.php">新規ユーザー登録はこちら</a>
</body>
</html>