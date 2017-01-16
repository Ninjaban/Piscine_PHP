<?php
$pagename = "Pay";

include "includes/header.php" ;

if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] != "") {
    $usr = mysqli_real_escape_string($_MYSQL, $_SESSION["loggued_on_user"]);
    $query = mysqli_query($_MYSQL, "SELECT * FROM users WHERE username='$usr'") ;
    if ($query) {
        $user = mysqli_fetch_array($query);
        mysqli_free_result($query);
        $cart = unserialize($user["cart"]);
        $total = 0;
        if ($cart) {
            foreach ($cart as $itm => $qtt) {
                $query = mysqli_query($_MYSQL, "SELECT price FROM items WHERE id=$itm");
                $item = mysqli_fetch_array($query);
                $total += $item["price"] * $qtt;
            }
            $cart = serialize($cart);
            $query = "INSERT INTO carts (user_id,content,total) VALUES(" . $user["id"] . ", '$cart',$total)";
            mysqli_query($_MYSQL, $query);
            echo "<div class='success'>Thank you ! Your command was successfully saved. We are shipping it as soon as possible.</div>";
            mysqli_query($_MYSQL, "UPDATE users SET cart=NULL WHERE id=" . $user["id"]);
        }
        else
            echo "<div class='error'>An error occured. Please try again.</div>";
    }
    else
        echo "<div class='error'>An error occured. Please try again.</div>";
}
else
    echo "<div class='error'>An error occured. Please try again.</div>";

include "includes/footer.php" ;