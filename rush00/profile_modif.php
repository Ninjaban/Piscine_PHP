<?php

$pagename = "Profile";

function check ($del)
{
    if ($del == true)
        header("Location: index.php?change=1", true, 302);
    else
        header("Location: profile.php?code=ERROR", true, 302);
}

session_start();
include "config/database.php";

$oldlogin = $_SESSION["loggued_on_user"];
if ($oldlogin == NULL)
    return ;

$newlogin = $_GET["login"];
$oldpasswd = $_GET["oldpasswd"];
$newpasswd = $_GET["newpasswd"];

if ($newlogin == NULL || $oldpasswd == NULL || $newpasswd == NULL) {
    header("Location: profile.php?code=ERROR", true, 302);
    return ;
}

$newlogin = trim($newlogin);
$oldpasswd = trim($oldpasswd);
$newpasswd = trim($newpasswd);

if ($newlogin == NULL || $oldpasswd == NULL || $newpasswd == NULL) {
    header("Location: profile.php?code=ERROR", true, 302);
    return ;
}

$key = hash('whirlpool', $oldpasswd);
$key = hash('sha256', $key);

$nkey = hash('whirlpool', $newpasswd);
$nkey = hash('sha256', $nkey);

$result = mysqli_query($_MYSQL, "SELECT * FROM users");
while ($user = mysqli_fetch_array($result)) {
    if ($user['username'] == $oldlogin && $user['mdp'] == $key) {
        mysqli_free_result($result);
        $_SESSION["loggued_on_user"] = $newlogin;

        $newlogin = mysqli_real_escape_string($_MYSQL, $newlogin);
        $nkey = mysqli_real_escape_string($_MYSQL, $nkey);
        $oldlogin = mysqli_real_escape_string($_MYSQL, $oldlogin);

        mysqli_query($_MYSQL, "UPDATE users SET username = '$newlogin', mdp = '$nkey' WHERE username = '$oldlogin'");

        check(true);
        return ;
    }
}
mysqli_free_result($result);
check(false);
return ;
?>

<?php
include "includes/footer.php"
?>