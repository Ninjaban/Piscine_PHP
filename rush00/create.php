<?php
$pagename = "Create";

include("includes/header.php");
?>

    <form action="create_user.php" method="POST">
        <input type="text" name="login" placeholder="Votre login" value=""><BR />
        <input type="password" name="passwd" placeholder="Votre mot de passe" value=""><BR />
        <input type="submit" name="submit" value="OK">
    </form>

<?php
include("includes/footer.php");
?>