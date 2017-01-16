<?php

session_start();
include "config/database.php";

if ($_SESSION['loggued_on_user'] == NULL)
    header("Location: index.php?logout=0", true, 302);

while (count($_SESSION))
    array_pop($_SESSION);
$_SESSION["loggued_on_user"] = "";

if ($_GET['del'] === 1) {
    header("Location: index.php?del=1", true, 302);
}
else {
    header("Location: index.php?logout=1", true, 302);
}

?>

<?php
include "includes/footer.php"
?>