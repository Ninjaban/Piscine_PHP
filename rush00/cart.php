<?php

$pagename = "Cart";

include "includes/header.php";




if (isset($_POST["pid"]) && isset($_POST["new_qtt"]))
{
    $id = mysqli_real_escape_string($_MYSQL, $_POST["pid"]);
    $usr = mysqli_real_escape_string($_MYSQL, $_SESSION["loggued_on_user"]);
    $qtt = mysqli_real_escape_string($_MYSQL, $_POST["new_qtt"]);

    if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] != "") {
        $query = "SELECT cart FROM users WHERE name=$usr";
        if ($query = mysqli_query($_MYSQL, $query)) {
            $cart = mysqli_fetch_array($query);
            $cart = $cart["cart"];
            $cart = unserialize($cart);
            mysqli_free_result($query);
        }
    }
    else {
        if (isset($_SESSION["cart"]) && $_SESSION["cart"] != "")
            $cart = unserialize(mysqli_real_escape_string($_MYSQL, $_SESSION["cart"]));
    };
    $cart[$id] = intval($qtt);

    $cart = serialize($cart);
    $_SESSION["cart"] = $cart;

    if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] != "") {
        $cart = mysqli_real_escape_string($_MYSQL, $cart);
        $query = "UPDATE users SET cart='$cart' WHERE username='$usr'";
        if ($query = mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The item has been modified</div>";
        else
            echo "<div class='error'>The item could not be modified</div>";
    }
    else
        echo "<div class='success'>The item has been modified</div>";
}


?>

<table class="cart-table">
   <tr class="cart-title">
      <td>Name</td>
      <td>Quantities</td>
       <td>Price unit</td>
       <td>Price total</td>
       <td>Action</td>
   </tr>
<?php
$usr = mysqli_real_escape_string($_MYSQL, $_SESSION["loggued_on_user"]);

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
$total = 0;
if ($cart == [])
    echo "<div class='notice'>Your cart appears to be empty. Please <a href='products.php'>browse</a> our products and add some !</div>";
else {
    foreach ($cart as $itm => $qtt) {
        $query = "SELECT * FROM items WHERE id=$itm";
        $item = mysqli_fetch_array(mysqli_query($_MYSQL, $query));
        if ($qtt) {
            ?>
            <form action='cart.php' method='post'>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><input type="number" value="<?= $item['id'] ?>" name="pid" hidden><input type="number" min="0"
                                                                                                 value="<?= $qtt ?>"
                                                                                                 name="new_qtt"></td>
                    <td><?= $item['price'] ?>€</td>
                    <td><?= ($item['price'] * $qtt) ?>€</td>
                    <td><input type="submit" name="submit" value="edit"></td>
                </tr>
            </form>
            <?php
            $total += ($item['price'] * $qtt);
        }
    }
}
?>
   <tr>
      <td colspan="2">Total :</td>
      <td colspan="2"><?php echo $total; ?> €</td>
   </tr>
   <tr class="cart-foot">
      <td colspan="2" class="cart-hide"></td>
      <td colspan="2">
          <form name="cart-archive" action="cart.php?archive=1">
              <?php echo "<a href='" ;
            if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] != "")
                 echo "pay.php' class='btn btn-act'>Pay</a>" ;
            else
                echo "#' class='btn btn-out'>Pay</a><br>You should be connected to access payment." ; ?>
          </form>
      </td>
   </tr>
</table>

<?php
include "includes/footer.php";
?>
