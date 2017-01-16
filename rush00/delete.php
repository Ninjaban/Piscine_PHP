<?php
function check ($del)
{
    if ($del == true)
        header("Location: logout.php?del=1", true, 302);
    else
        header("Location: del.php?code=ERROR", true, 302);
}

session_start();
include "config/database.php";

$name = mysqli_real_escape_string($_MYSQL, $_SESSION['loggued_on_user']);

$tmp = array();
$result = mysqli_query($_MYSQL, "SELECT * FROM users WHERE username = '$name'");
while ($product = mysqli_fetch_array($result)) {
    array_push($tmp, $product);
}
mysqli_free_result($result);

$passwd = $_GET['passwd'];

$key = hash('whirlpool', $passwd);
$key = hash('sha256', $key);

if ($tmp[0]['mdp'] === $key) {
    $result = mysqli_query($_MYSQL, "DELETE FROM users WHERE username = '$name'");
    check(true);
}
else
    check(false);

?>

<?php mysqli_close($_MYSQL); ?>
