<?php

$pagename = "Profile";

include "includes/header.php"
?>

<?php

if ($_GET['code'] === "ERROR")
    echo "<div class='error'>Your password is invalid</div>";

$login = $_SESSION['loggued_on_user'];
if ($login == NULL)
    return ;

$login = mysqli_real_escape_string($_MYSQL, $login);

$result = mysqli_query($_MYSQL, "SELECT cart FROM users WHERE username = '" . $login . "'");
$tmp = mysqli_fetch_array($result);
mysqli_free_result($result);
?>

<form action="profile_modif.php">
    <input type="text" name="login" placeholder="Votre login" value="<?=$login ?>"><BR />
    <input type="password" name="oldpasswd" placeholder="Old password" value=""><BR />
    <input type="password" name="newpasswd" placeholder="New password" value=""><BR />
    <input type="submit" name="submit" value="OK">
</form>

<?php
include "includes/footer.php"
?>
