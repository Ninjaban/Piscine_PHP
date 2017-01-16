<?php

if (isset($_GET["pid"])
    && isset($_GET["qtt"])
    && isset($_GET["submit"]))
{
    $id = mysqli_real_escape_string($_MYSQL, $_GET["pid"]);
    $usr = mysqli_real_escape_string($_MYSQL, $_SESSION["loggued_on_user"]);
    $qtt = mysqli_real_escape_string($_MYSQL, $_GET["qtt"]);
    if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] != "") {
        $query = "SELECT cart FROM users WHERE username='$usr'";
        if ($query = mysqli_query($_MYSQL, $query)) {
            $cart = mysqli_fetch_array($query);
            $cart = $cart["cart"];
            $cart = unserialize($cart);
            mysqli_free_result($query);
        } else
            $cart = [];
    }
    else {
        if (isset($_SESSION["cart"]) && $_SESSION["cart"] != "")
            $cart = unserialize(mysqli_real_escape_string($_MYSQL, $_SESSION["cart"]));
        else
            $cart = [];
    }
    if (isset($cart[$id])) {
        $total = intval($cart[$id]) + intval($qtt);
        $cart[$id] = $total;
    }
    else
        $cart[$id] = intval($qtt);

    $cart = serialize($cart);
    $_SESSION["cart"] = $cart;

    if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] != "") {
        $cart = mysqli_real_escape_string($_MYSQL, $cart);
        $query = "UPDATE users SET cart='$cart' WHERE username='$usr'";
        if ($query = mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The item has been added to your cart</div>";
        else
            echo "<div class='error'>The item could not be added</div>";
    }
    else
        echo "<div class='success'>The item has been added to your cart</div>";
}
