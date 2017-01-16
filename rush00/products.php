<?php

$pagename = "Products";

include "includes/header.php";

include "add_to_cart.php";
?>

<table class="product-table">
    <tr class="product-title">
        <td><a href="products.php?order=name&&type=<?php echo ($_GET['type'] == 'ASC') ? "DESC" : "ASC"; if ($_GET['id']) { echo "&&id=" . $_GET['id']; }?>">Name</a></td>
        <td>Picture</td>
        <td>Description</td>
        <td><a href="products.php?order=price&&type=<?php echo ($_GET['type'] == 'ASC') ? "DESC" : "ASC"; if ($_GET['id']) { echo "&&id=" . $_GET['id']; }?>">Price</a></td>
        <td>Info</td>
        <td>Buy</td>
    </tr>

<?php

$tmp = array();
$result = mysqli_query($_MYSQL, "SELECT * FROM categories");
while ($categories = mysqli_fetch_array($result)) {
    array_push($tmp, $categories);
}
mysqli_free_result($result);

$class = array();
$idlist = array(0);

function ft_search_c($class, $tabl, $idlist, $name, $id)
{
    foreach ($tabl as $tmptab) {
        if (array_search($tmptab['id'], $idlist) === false && $tmptab['parent'] == $id) {
            array_push($class, array('id' => $tmptab['id'], 'name' => $tmptab['name'], 'parent' => $id));
            array_push($idlist, $tmptab['id']);
            $class = ft_search_c($class, $tabl, $idlist, $tmptab['name'], $tmptab['id']);
        }
    }
    return $class;
}

foreach ($tmp as $tab) {
    if (array_search($tab['id'], $idlist) === false && !$tab['parent']) {
        array_push($class, $tab);
        $class = ft_search_c($class, $tmp, $idlist, $tab['name'], $tab['id']);
    }
}


$tmp = array();
$order = mysqli_real_escape_string($_MYSQL, ($_GET['order']) ? $_GET['order'] : 'id');

if (!$_GET['type'] || $_GET['type'] == 'ASC')
    $result = mysqli_query($_MYSQL, "SELECT * FROM items ORDER BY $order ASC");
else
    $result = mysqli_query($_MYSQL, "SELECT * FROM items ORDER BY $order DESC");
while ($product = mysqli_fetch_array($result)) {
    array_push($tmp, $product);
}
mysqli_free_result($result);

$product = array();
$idlist = array(0);

function ft_search_p($product, $tabl, $idlist, $name, $id)
{
    foreach ($tabl as $tmptab) {
        if (array_search($tmptab['id'], $idlist) === false && $tmptab['parent'] == $id) {
            array_push($product, array('id' => $tmptab['id'], 'name' => $tmptab['name'], 'parent' => $name));
            array_push($idlist, $tmptab['id']);
            $product = ft_search_p($product, $tabl, $idlist, $tmptab['name'], $tmptab['id']);
        }
    }
    return $product;
}

foreach ($tmp as $tab) {
    if (array_search($tab['id'], $idlist) === false && !$tab['parent']) {
        array_push($product, $tab);
        $product = ft_search_p($product, $tmp, $idlist, $tab['name'], $tab['id']);
    }
}

function ft_get_child($categories, $id)
{
    $tab = array($id);
    foreach ($categories as $tmp) {
        if ($tmp['parent'] === $id)
            array_push($tab, $tmp['id']);
    }
    return $tab;
}

function ft_check_child($idlist, $id)
{
    foreach ($idlist as $tmp) {
        if (array_search($tmp, $id) !== false)
            return true;
    }
    return false;
}

foreach ($product as $tab) {
    $cat = explode(",", $tab['categories']);
    $desc = substr($tab['description'], 0, 40);
    if (strlen($tab['description']) > 40)
        $desc = $desc . "...";
    if ($_GET['id'] == NULL || ft_check_child(ft_get_child($class, $_GET['id']), $cat) !== false) {
?>
        <tr>
            <td>
                <a href="products_detail.php?id=<?=$tab['id']?>"><?=$tab['name']?></a>
            </td>
            <td>
                <img src="<?=$tab['picture']?>"></td>
            <td><?=$desc?></td>
            <td><?=$tab['price']?>€</td>
            <td>
                <a href="products_detail.php?id=<?=$tab['id']?>" class='btn btn-act'>More Details</a>
            </td>
            <td>
                <form method="get" action="products.php">
                    <input type="number" value="<?=$tab['id']?>" name="pid" hidden>
                    <input type="number" min="0" name="qtt" value="0">
                    <input type="submit" name="submit" value="Add to Cart">
                </form>
            </td>
        </tr>
<? }} ?>

</table>


<ul class="product-menu">
    <li><a href="products.php">All</a></li>
    <?php
    function ft_list($class, $id, $n)
    {
        $i = 0;
        $prev = NULL;
        echo "<li><a>";
        foreach ($class as $tab) {
            if ($i >= $n) {
                if ($tab['parent'] == $id) {
                    echo "</a></li><li><a href='products.php?id=" . $tab['id'] . "'>" . $tab['name'];
                }
                else if ($tab['parent'] == $prev) {
                    echo "<ul>";
                    $n = ft_list($class, $tab['parent'], $i);
                    echo "</ul>";
                }
                else {
                    echo "</a></li>";
                    return $i;
                }
            }
            $prev = $tab['id'];
            $i = $i + 1;
        }
        echo "</li>";
        return $i;
    }
    $n = 0;
    $i = 0;
    echo "<li><a>";
    foreach ($class as $tab) {
        if ($tab['parent'] && $n >= $i) {
            echo "<ul>";
            $i = ft_list($class, $tab['parent'], $n);
            echo "</ul>";
        }
        else if ($n >= $i)
            echo "</a></li><li><a href='products.php?id=" . $tab['id'] . "'>" . $tab['name'];
        $n = $n + 1;
    }
    echo "</a></li>";
    ?>
</ul>


<?php
include "includes/footer.php";
?>
