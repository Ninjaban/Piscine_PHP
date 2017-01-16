<?php

$pagename = "Slave Shop dot com";

include "includes/header.php" ;
include "add_to_cart.php" ;

if ($_GET) {
    if (isset($_GET["login"])){
        if ($_GET["login"])
            echo "<div class='success'>You were successfully logged in</div>";
        else
            echo "<div class='error'>Log in failed</div>";
    }
    if (isset($_GET["signin"])){
        if ($_GET["signin"])
            echo "<div class='success'>Your account was successfully created</div>";
        else
            echo "<div class='error'>There was an error creating your account</div>";
    }
    if (isset($_GET["logout"])){
        if ($_GET["logout"])
            echo "<div class='success'>You were successfully logged out</div>";
        else
            echo "<div class='error'>Log out failed</div>";
    }
    if (isset($_GET["del"])){
        if ($_GET["del"])
            echo "<div class='success'>Your account was successfully deleted</div>";
        else
            echo "<div class='error'>Your account could not be deleted</div>";
    }
    if (isset($_GET["change"])){
        if ($_GET["change"])
            echo "<div class='success'>Your password was successfully changed</div>";
        else
            echo "<div class='error'>Your password could not be changed</div>";
    }
}

$sotw = 2;

$query = mysqli_query($_MYSQL, "SELECT * FROM items WHERE id=$sotw");
$sotw = mysqli_fetch_array($query);
$cats = explode(",", $sotw["categories"]);
$tags = [] ;
foreach ($cats as $id) {
    $query = mysqli_query($_MYSQL, "SELECT id,name FROM categories WHERE id=$id");
    $cat = mysqli_fetch_array($query);
    $tags[$id] = $cat["name"] ;
}
?>

<div id="weekly_slave" style="text-align: center;">
    <img class="slave_of_the_week" src="<?=$sotw["picture"]?>">
    <h1 style="text-align: center;">Slave of the Week</h1>
    <h2 style="text-align: center;"><?=$sotw["name"]?></h2>
    <p style="text-align: center;"><?=$sotw["description"]?></p>
    <p style="text-align: center;"><?php
        foreach ($tags as $tid => $tnm) {
            echo "<a class='btn' href='products.php?id=$tid'>$tnm</a>" ;
        }
        ?></p>
    <a class="btn btn-act" href="products_detail.php?id=<?=$sotw["id"]?>">Buy now for <?=$sotw["price"]?>€</a>
    <a class="btn btn-act" href="products.php">Browse all products</a>
</div>

<div id="certification">
    <img class="faire-trade" src="http://fairtradeusa.org/sites/all/files/wysiwyg/imagemanager/logo/Fair_Trade_Certified_Logo-CMYK.png">
    All of our slaves are Fair Trade Certified. That means that their are willingly given away by their families or friends, and they are payed accordingly. That way, you do not have to worry about them !
    Plus, you are helping families in need, because we offer them a slave every thousand euros of revenue.
    <?php
        $query = mysqli_query($_MYSQL, "SELECT * FROM carts");
        $rev = 0;
        while ($cart = mysqli_fetch_array($query)) {
            $rev += intval($cart["total"]);
        }
        $rev = $rev % 1000;
    ?>
    <div class="progress"><div class="progress-inside" style="width: <?=($rev / 10)?>%"><span><?=$rev?></span></div> </div>
</div>
<div id="why">
    <img id="whyslave" src="http://t0.gstatic.com/images?q=tbn:ANd9GcRg7SQe6RTlUjWJIG1YHFAgNYKTkztfdDExXLbKC9g3nBc49KJNVpUJigs">
    <h2>Why should you get a slave ?</h2>
    Slaves are handy. They can help you to all sort of tasks, like house chores, teaching your kids, gathering cotton... Some may also entertain the whole family ! People have bought and used slaves for centuries now, why wouldn't you ?
</div>


<?php include "includes/footer.php" ; ?>
