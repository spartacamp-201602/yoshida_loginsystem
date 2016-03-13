<?

function connectDb()
{
    try{
        $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
        return $dbh;
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
        exit;
    }
}

function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}