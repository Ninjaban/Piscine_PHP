</div>
<div id="blank"></div>
<footer>
    <HR width="100%">
    Piscine PhP - Rush 00 - janvier 2017 - 42
    <?php
    if ($_SESSION['loggued_on_user'] != NULL)
        echo "<div><a href='del.php' class='btn btn-del'>Delete your account</a></div>";
    ?>
</footer>
</body>
</html>
<?php mysqli_close($_MYSQL); ?>