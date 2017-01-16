<?php

session_start();
include "config/database.php";

$submit = $_POST["submit"];
if ($submit === "OK" && $_POST["login"] != NULL && $_POST["passwd"] != NULL && strlen($_POST['login']) < 20)
{

    $login = trim($_POST['login']);
    $passwd = trim($_POST['passwd']);

    if ($login == NULL || $passwd == NULL) {
        header("Location: index.php?signin=0", true, 302);
        return ;
    }

    $key = hash('whirlpool', $passwd);
    $key = hash('sha256', $key);

    $verif = true;
    $tab = array("login" => $login, "passwd" => $key);

    $result = mysqli_query($_MYSQL, "SELECT * FROM users");
    while ($user = mysqli_fetch_array($result)) {
        if ($user['username'] == $tab['login'])
            $verif = false;
    }
    mysqli_free_result($result);

    if ($verif == true)
    {
        $usr = mysqli_real_escape_string($_MYSQL, $tab['login']);
        $pwd = mysqli_real_escape_string($_MYSQL, $tab['passwd']);
        $query = "INSERT INTO users (username, mdp) VALUES ('$usr', '$pwd')";
        if (mysqli_query($_MYSQL, $query))
            header("Location: index.php?signin=1", true, 302);
    }
    else
        header("Location: index.php?signin=0", true, 302);
}
else
    header("Location: index.php?signin=0", true, 302);
?>

<?php
include("includes/footer.php");
?>