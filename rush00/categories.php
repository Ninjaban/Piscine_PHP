<?php
$pagename = "Categories";

include "includes/header.php";
?>

<table class="cart-table">
    <tr class="cart-title">
        <td>id</td>
        <td>name</td>
        <td>parent</td>
    </tr>

<?php

$tmp = array();
$result = mysqli_query($_MYSQL, "SELECT * FROM categories");
while ($categories = mysqli_fetch_array($result)) {
    array_push($tmp, $categories);
//    echo "<tr><td>". $categories['id'] . "</td><td>" . $categories['name'] . "</td><td>" . $categories['parent'] . "</td></tr>";
}
mysqli_free_result($result);

$class = array();
$idlist = array(0);

function ft_search($class, $tabl, $idlist, $name, $id)
{
    foreach ($tabl as $tmptab) {
        if (array_search($tmptab['id'], $idlist) === false && $tmptab['parent'] == $id) {
            array_push($class, array('id' => $tmptab['id'], 'name' => $tmptab['name'], 'parent' => $name));
            array_push($idlist, $tmptab['id']);
            $class = ft_search($class, $tabl, $idlist, $tmptab['name'], $tmptab['id']);
        }
    }
    return $class;
}

foreach ($tmp as $tab) {
    if (array_search($tab['id'], $idlist) === false && !$tab['parent']) {
        array_push($class, $tab);
        $class = ft_search($class, $tmp, $idlist, $tab['name'], $tab['id']);
    }
}

$n = 0;
foreach ($class as $tab) {
    if ($tab['id'] === $_GET['id'])
        while ($class[$n]['id'] === $_GET['id'] || $class[$n]['parent']) {
            echo "<tr><td><a href='products.php?id=" . $class[$n]['id'] . "'>" . $class[$n]['id'] . "</a></td><td><a href='products.php?id=" . $class[$n]['id'] . "'>" . $class[$n]['name'] . "</a></td><td><a href='products.php?id=" . $class[$n]['id'] . "'>" . $class[$n]['parent'] . "</a></td></tr>";
            $n = $n + 1;
        }
    if (!$_GET['id'])
        echo "<tr><td><a href='products.php?id=" . $class[$n]['id'] . "'>" . $class[$n]['id'] . "</a></td><td><a href='products.php?id=" . $class[$n]['id'] . "'>" . $class[$n]['name'] . "</a></td><td><a href='products.php?id=" . $class[$n]['id'] . "'>" . $class[$n]['parent'] . "</a></td></tr>";
    $n = $n + 1;
}
?>

</table>

<ul class="product-menu">
    <li><a href="categories.php">All</a></li>
    <?php
    function ft_list($class, $id, $n)
    {
        $i = 0;
        $prev = NULL;
        echo "<li><a>";
        foreach ($class as $tab) {
            if ($i >= $n) {
                if ($tab['parent'] == $id) {
                    echo "</a></li><li><a href='categories.php?id=" . $tab['id'] . "'>" . $tab['name'];
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
            $prev = $tab['name'];
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
            echo "</a></li><li><a href='categories.php?id=" . $tab['id'] . "'>" . $tab['name'];
        $n = $n + 1;
    }
    echo "</a></li>";
    ?>
</ul>


<?php
include "includes/footer.php";
?>
