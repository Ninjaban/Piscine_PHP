<?php

if (isset($_GET["del"])) { //delete smth
    if ($_GET["page"] == "cat") {
        $id = mysqli_real_escape_string($_MYSQL, $_GET["del"]);
        $query = "DELETE FROM categories WHERE id=$id";
        if (mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The category n.$id has been deleted</div>";
        else
            echo "<div class='error'>The category could not be deleted</div>";
    }
}

if ($_POST) {
    $error = 0;
    if (   $_GET["page"] == "cat"
        && $_POST["cat-name"]
        && isset($_POST["select_parent"])
    ) {
        $name = mysqli_real_escape_string($_MYSQL, $_POST["cat-name"]);
        $parent = mysqli_real_escape_string($_MYSQL, $_POST["select_parent"]);
        $name = trim($name);
        if (categoryExist($_MYSQL, $name))
            $error = 1;
        if ($name == $parent)
            $error = 2;
        if ($name == '')
            $error = 3;
        if ($parent) {
            $query = "INSERT INTO categories (name, parent) VALUES('$name',$parent)";
        }
        else { $query = "INSERT INTO categories (name) VALUES('$name')" ; }

        if (!$error && mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The new category '$name' has been added</div>";
        else
            echo "<div class='error'>The new category could not be added</div>";
    }
}

?>
<form title="category-add" name="category-add" action="admin.php?page=cat" method="post">
    New category :
            <input type="text" placeholder="name" name="cat-name">
            <select title="select_parent" name="select_parent">
                <option value="0" name="0">No parent</option>
                <?php
                    $categories = mysqli_query($_MYSQL, "SELECT * FROM categories");
                    while ($cat = mysqli_fetch_array($categories)) {
                        echo "<option value='" . $cat["id"] . "'>" . $cat["name"] . "</option>";
                    }
                ?>
            </select>
<input type="submit" value="OK">
</form>
<hr>
<table>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>parent</th>
        <th>actions</th>
    </tr>
    <?php
    $categories = mysqli_query($_MYSQL, "SELECT * FROM categories");
    while ($cat = mysqli_fetch_array($categories)) {
        echo "<tr>" ;
        echo "<td>" . $cat["id"] . "</td>";
        echo "<td>" . $cat["name"] . "</td>";
        $parent = "";
        if ($parent = mysqli_query($_MYSQL, "SELECT id,name FROM categories WHERE id=" . $cat["parent"])) {
            $parent = mysqli_fetch_array($parent);
            echo "<td> (" . $parent["id"] . ")" . $parent["name"] . "</td>";
        }
        else { echo "<td></td>"; }
        echo "<td>  <a class='btn btn-del' href='admin.php?page=cat&del=" . $cat["id"] . "'>delete</a>
                                <a class='btn btn-act' href='admin.php?page=edt&type=cat&id=" . $cat["id"] . "'>edit</a></td>";
        echo "</tr>" ;
    }
    ?>
</table>