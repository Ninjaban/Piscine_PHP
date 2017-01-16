<div id="menu-top">
    <ul id="menu-deroulant">
        <li><img src="menu.png" />
            <ul>
                <a href="index.php"><li>Accueil</li></a>
                <a href="categories.php"><li>Categories</li></a>
                <a href="products.php"><li>Products</li></a>
            </ul>
        </li>
    </ul>
    <div id="menu-name"><h1><?php echo $pagename; ?></h1></div>
    <?php
    if ($_SESSION["loggued_on_user"] == NULL) {
        echo "<div id = 'menu-login' class='button' ><a href = 'log.php' > Login</a ></div>";
        echo "<div id = 'menu-signin' class='button' ><a href = 'create.php' > Signin</a ></div>";
    }
    else if ($_SESSION["loggued_on_user"] == "admin") {
        echo "<div id='menu-admin' class='button'><a href='admin.php'>Admin</a></a></div>";
        echo "<div id='menu-logout' class='button'><a href='logout.php'>Logout</a></a></div>";
    }
    else {
        echo "<div id='menu-profile' class='button'><a href='profile.php'>Profile</a></a></div>";
        echo "<div id='menu-logout' class='button'><a href='logout.php'>Logout</a></a></div>";
    }
    ?>

    <style type="text/css">
        #menu-cart {
        <?php
if ($_SESSION['loggued_on_user'] == NULL)
    echo "right: 285px;";
else if ($_SESSION['loggued_on_user'] == "admin")
    echo "right: 300px;";
else
    echo "right: 300px;";
?>}
    </style>
    <div id="menu-cart" class="button"><a href="cart.php">Cart</a></div>
</div>