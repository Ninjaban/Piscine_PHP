<?php

$pagename = "Products";

include "includes/header.php";
?>

<?php

$tmp = array();
if ($_GET['id'])
    $result = mysqli_query($_MYSQL, "SELECT * FROM items WHERE id = " . mysqli_real_escape_string($_MYSQL, $_GET['id']));
while ($product = mysqli_fetch_array($result)) {
    array_push($tmp, $product);
}
mysqli_free_result($result);

if (!count($tmp)) {
    echo "<H1>404 - Item not found</H1>";
}
else {
    $idlst = explode(",", $tmp[0]['categories']);
    $cat = "";
    foreach ($idlst as $id) {
        $result = mysqli_query($_MYSQL, "SELECT * FROM categories WHERE id = '" . mysqli_real_escape_string($_MYSQL, $id) . "'");
        while ($product = mysqli_fetch_array($result)) {
            $cat = $cat . "<a href='products.php?id=" . $product['id'] . "' class='btn'>" . $product['name'] . "</a> ";
        }
        mysqli_free_result($result);
    }
    $cat = trim($cat);

    echo "<div class='product-details'><H1>" . $tmp[0]['name'] . "</H1></div>";
    echo "<div class='product-details'><H4>" . $cat . "</H4></div>";
    echo "<div class='product-details'><img src='" . $tmp[0]['picture'] . "' /></div>";
    echo "<div class='product-details'><H2>Price : " . $tmp[0]['price'] . " €</H2></div>";
    echo "<div class='product-details'>" . $tmp[0]['description'] . "</div>";

    echo "<div class='product-details'>";
    echo "<td>";
    echo "<form method='get' action='products.php'>";
    echo "<input type='number' value='" . $tmp[0]['id'] . "' name='pid' hidden>";
    echo "<input type='number' min='1' name='qtt' value='0'><br />";
    echo "<input type='submit' name='submit' value='Add to Cart' class='btn btn-act btn-base'>";
    echo "</form>";
    echo "</td>";
    echo "</div>";
}
?>

<?php
include "includes/footer.php";
?>
