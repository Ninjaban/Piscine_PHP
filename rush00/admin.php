<?php $pagename = "Admin";

include "includes/header.php" ;


function getCategories($_MYSQL, $item) {
    if (!$item)
        return NULL;
    $cats = explode(',', $item);
    $ret = [];
    foreach ($cats as $cat) {
        $cat = mysqli_query($_MYSQL, "SELECT name FROM categories WHERE id=" . $cat);
        $cat = mysqli_fetch_array($cat);
        $ret[] = $cat["name"];
    }
    return $ret;
}

function categoryExist($_MYSQL, $name) {
    $cat = mysqli_query($_MYSQL, "SELECT name FROM categories WHERE name='$name'");
    $cat = mysqli_fetch_array($cat);
    return $cat ;
}

function haveCat($item, $cat) {
    foreach ($item as $key => $value) {
        if ($value == $cat)
            return true;
    }
    return false;
}

if ($_SESSION["loggued_on_user"] == "admin")
{
?>
<nav>
    <ul>
        <li class="<?php if($_GET["page"] == "cat") {echo "active";} ?>"><a href="?page=cat" class="tab">Categories</a></li>
        <li class="<?php if($_GET["page"] == "itm") {echo "active";} ?>"><a href="?page=itm" class="tab">Products</a></li>
        <li class="<?php if($_GET["page"] == "usr") {echo "active";} ?>"><a href="?page=usr" class="tab">Users</a></li>
        <li class="<?php if($_GET["page"] == "crt") {echo "active";} ?>"><a href="?page=crt" class="tab">Payed Carts</a></li>
        <li class="<?php if($_GET["page"] == "edt") {echo "active";} else {echo "grayed_out";} ?>"><a href="#" class="tab">Editor</a></li>
    </ul>
</nav>
<div class="tab-content">
    <?php if ($_GET["page"] == "cat") {
        include "admin/categories.php" ;
    } else if ($_GET["page"] == "itm") {
        include "admin/products.php" ;
    } else if ($_GET["page"] == "usr"){
        include "admin/users.php" ;
    } else if ($_GET["page"] == "edt") {
        include "admin/editor.php" ;
    } else if ($_GET["page"] == "crt") {
        include "admin/cart.php" ;
    }?>
</div>
<?php }
else {
    echo "You should be admin to see this page." ;
}

include "includes/footer.php" ; ?>