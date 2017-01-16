<?php
$pagename = "Delete";

include "includes/header.php";
?>

<?php
if ($_GET['code'] != "ERROR")
    echo "<div class='notice'>Enter your password to delete your account</div>";
else
    echo "<div class='error'>Your account was not deleted</div>";
?>

    <form action="delete.php">
        <input type="password" name="passwd" placeholder="Votre mot de passe" value=""><BR />
        <input type="submit" name="submit" value="OK">
    </form>

<?php
include "includes/footer.php";
?>