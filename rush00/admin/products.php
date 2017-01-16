<?php

if (isset($_GET["del"])) { //delete smth
    if ($_GET["page"] == "itm") {
        $id = mysqli_real_escape_string($_MYSQL, $_GET["del"]);
        $query = "DELETE FROM items WHERE id=$id";
        if (mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The product n.$id has been deleted</div>";
        else
            echo "<div class='error'>The product could not be delete</div>";
    }
}

//var_dump($_POST);
if ($_POST) {
    $error = 0;
    if (   $_GET["page"] == "itm"
        && $_POST["itm_name"]
        && $_POST["itm_price"]
        && $_POST["itm_picture"]
        && $_POST["itm_description"]
        ) {
        $item = [];
        $categories = [];
        foreach ($_POST as $key => $value) {
            $item[$key] = mysqli_real_escape_string($_MYSQL, $value);
            if ($key != "itm_name" && $key != "itm_price" && $key != "itm_picture" && $key != "itm_description")
                $categories[] = $value;
        }
        $categories = implode(",", $categories);
        $name = $item["itm_name"];
        $price = $item["itm_price"];
        $descr = $item["itm_description"];
        $pict = $item["itm_picture"];
        if($categories == "")
            $query = "INSERT INTO items (name, price, picture, description) VALUES('$name', $price, '$pict', '$descr')";
        else
            $query = "INSERT INTO items (name, price, picture, categories, description) VALUES('$name', $price, '$pict', '$categories', '$descr')";
        if (mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The new product '$name' has been added</div>";
        else {
            echo "<div class='error'>The new product could not be added</div>";
        }
    }
    else
        echo "<div class='error'>The new product could not be added</div>";

}

?>

<form name="item-add" action="admin.php?page=itm" method="post">
    New item :
    <input type="text" name="itm_name">
    Price : <input type="number" placeholder="10" name="itm_price" min="0">€<br>
    Image url : <input type="text" placeholder="www..." name="itm_picture"><br>
    Categories :
    <?php
    $categories = mysqli_query($_MYSQL, "SELECT * FROM categories");
    while ($cat = mysqli_fetch_array($categories)) {
        echo "<input type='checkbox' name='" . $cat["name"] . "' value='" . $cat["id"] . "'>" . $cat["name"] . "</option>";
    }
    ?>
    <br><textarea placeholder="Description" name="itm_description"></textarea>
    <br><input type="submit" value="OK">
</form>
<hr>
<table>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>price</th>
        <th>picture</th>
        <th>categories</th>
        <th>description</th>
        <th>actions</th>
    </tr>
    <?php
    $items = mysqli_query($_MYSQL, "SELECT * FROM items");
    while ($itm = mysqli_fetch_array($items)) {
        echo "<tr>" ;
        echo "<td>" . $itm["id"] . "</td>" ;
        echo "<td>" . $itm["name"] . "</td>" ;
        echo "<td>" . $itm["price"] . "€</td>" ;
        echo "<td><img src='" . $itm["picture"] . "' height='20px'></td>" ;
        if ($itm["categories"]) {
            $categories = implode(', ', getCategories($_MYSQL, $itm["categories"]));
            echo "<td>" . $categories . "</td>" ;
        }
        else
            echo "<td></td>" ;
        echo "<td>" . $itm["description"] . "</td>" ;
        echo "<td>  <a class='btn btn-del' href='admin.php?page=itm&del=" . $itm["id"] . "'>delete</a>
                            <a class='btn btn-act' href='admin.php?page=edt&type=itm&id=" . $itm["id"] . "'>edit</a></td>";
        echo "</tr>" ;
    }
    ?>
</table>