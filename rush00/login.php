<?php
function check ($del)
{
    if ($del == true)
        header("Location: index.php?login=1", true, 302);
    else
        header("Location: index.php?login=0", true, 302);
}

session_start();
include "config/database.php";

$login = $_GET["login"];
$passwd = $_GET["passwd"];

if ($login == NULL || $passwd == NULL)
    return ;

$login = trim($login);
$passwd = trim($passwd);

if ($login == NULL || $passwd == NULL) {
    header("Location: index.php?login=0", true, 302);
    return ;
}

$key = hash('whirlpool', $passwd);
$key = hash('sha256', $key);

$result = mysqli_query($_MYSQL, "SELECT * FROM users");
while ($user = mysqli_fetch_array($result)) {
    if ($user['username'] == $login && $user['mdp'] == $key) {
        mysqli_free_result($result);
        $_SESSION["loggued_on_user"] = $login;

        $login = mysqli_real_escape_string($_MYSQL, $login);

        $result = mysqli_query($_MYSQL, "SELECT cart FROM users WHERE username = '" . $login . "'");
        $tmp = mysqli_fetch_array($result);
        mysqli_free_result($result);

        $tmp = unserialize($tmp['cart']);
        $cart = unserialize($_SESSION['cart']);

        if ($_SESSION['cart'])
            foreach ($tmp as $key => $value) {
                $bool = false;
                foreach (unserialize($_SESSION['cart']) as $nkey => $nvalue) {
                    if ($key == $nkey) {
                        $bool = true;
                        $cart[$key] += $value;
                    }
                }
                if ($bool == false) {
                    $cart[$key] = $value;
                }
            }
        $cart = serialize($cart);

        $_SESSION['cart'] = $cart;

        $cart = mysqli_real_escape_string($_MYSQL, $cart);
        $tlogin = mysqli_real_escape_string($_MYSQL, $_SESSION['loggued_on_user']);

        mysqli_query($_MYSQL, "UPDATE users SET cart = '$cart' WHERE username = '$tlogin'");
        check(true);
        return ;
    }
    check(false);
}
mysqli_free_result($result);
$_SESSION["loggued_on_user"] = "";
return ;
?>

<?php
include "includes/footer.php"
?>