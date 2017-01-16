<?php
//var_dump($_POST);
    if ($_POST) {
        if (isset($_POST["cat_name"]) && isset($_POST["select_parent"])) {
            $cat_name = mysqli_real_escape_string($_MYSQL, $_POST["cat_name"]);
            $cat_parent = mysqli_real_escape_string($_MYSQL, $_POST["select_parent"]);
            $id = mysqli_real_escape_string($_MYSQL, $_GET["id"]) ;
            if ($cat_parent)
                $query = "UPDATE categories SET name='$cat_name', parent=$cat_parent WHERE id=$id" ;
            else
                $query = "UPDATE categories SET name='$cat_name', parent=NULL WHERE id=$id" ;
            if (mysqli_query($_MYSQL, $query))
                echo "<div class='success'>The category '$cat_name' has been updated</div>";
            else
                echo "<div class='error'>The category could not be updated</div>";
        }
        else if (  isset($_POST["itm_name"])
                && isset($_POST["itm_price"])
                && isset($_POST["itm_picture"])
                && isset($_POST["itm_description"])
        ){
            $item = [];
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
            $id = mysqli_real_escape_string($_MYSQL, $_GET["id"]);
            if($categories == "")
                $query = "UPDATE items SET name='$name', price=$price, categories=NULL, picture='$pict', description='$descr' WHERE id=$id";
            else
                $query = "UPDATE items SET name='$name', price=$price, categories='$categories', picture='$pict', description='$descr' WHERE id=$id";
            if (mysqli_query($_MYSQL, $query))
                echo "<div class='success'>The product '$name' has been updated</div>";
            else
                echo "<div class='error'>The new product could not be updated</div>";
        }
        else if ( isset($_POST["usr_name"])) {
            $error = false;
            $id = mysqli_real_escape_string($_MYSQL, $_GET["id"]);
            $name = mysqli_real_escape_string($_MYSQL, $_POST["usr_name"]);
            $name = trim($name);
            $pass = "" ;
            if (isset($_POST["usr_pass"])) {
                $pass = hash('whirlpool', $_POST["usr_pass"]);
                $pass = hash('sha256', $pass);
            }
            $query = mysqli_query($_MYSQL, "SELECT * FROM users WHERE username='$name'");
            if ($user = mysqli_fetch_array($query))
                $error = true;
            if ($user['username'] == $name)
                $error = false;
            if ($pass == "")
                $query = "UPDATE users SET username='$name' WHERE id=$id";
            else
                $query = "UPDATE users SET username='$name', mdp='$pass' WHERE id=$id";

            if (!$error && mysqli_query($_MYSQL, $query))
                echo "<div class='success'>The new user '$name' has been added</div>";
            else
                echo "<div class='error'>The new user could not be added</div>";
        }
    }
    $error = 0;
    switch ($_GET["type"]) {
        case "cat":
            $table = "categories" ;
            break ;
        case "itm":
            $table = "items" ;
            break ;
        case "usr":
            $table = "users" ;
            break ;
        default:
            $error = 1;
            break ;
    }
    $id = mysqli_real_escape_string($_MYSQL, $_GET["id"]);
    if (!$error) {
        if($table == "categories") {
            $query = "SELECT * FROM $table WHERE id=$id";
            $thiscat = mysqli_fetch_array(mysqli_query($_MYSQL, $query));
            ?>

            <form name="edit-category" action="admin.php?page=edt&type=cat&id=<?php echo $thiscat["id"]; ?>" method="post">
                Edit the following category : <br>
                <input name="cat_id" type="number" value="<?php echo $thiscat["id"]; ?>" disabled>
                <input name="cat_name" type="text" value="<?php echo $thiscat["name"]; ?>">
                <select title="select_parent" name="select_parent">
                    <option value="0" name="0">No parent</option>
                    <?php
                    $categories = mysqli_query($_MYSQL, "SELECT * FROM categories");
                    while ($cat = mysqli_fetch_array($categories)) {
                        if ($cat["id"] == $thiscat["parent"])
                            echo "<option value='" . $cat["id"] . "' selected>" . $cat["name"] . "</option>";
                        else if ($thiscat["id"] != $cat["id"] && $cat["parent"] != $thiscat["id"])
                            echo "<option value='" . $cat["id"] . "'>" . $cat["name"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="OK">
            </form>
            <?php
        }
        else if ($table == "items") {
            $query = "SELECT * FROM $table WHERE id=$id" ;
            $itm = mysqli_fetch_array(mysqli_query($_MYSQL, $query));
            ?>
        <form name="edit-item" action="admin.php?page=edt&type=itm&id=<?php echo $itm["id"]; ?>" method="post">
            Edit the following product :<br>
            <input name="itm_id" type="number" value="<?php echo $itm["id"]; ?>" disabled>
            <input type="text" name="itm_name" value="<?php echo $itm["name"] ; ?>">
            Price : <input type="number" placeholder="10" name="itm_price" min="0" value="<?php echo $itm["price"] ;?>">€<br>
            Image url : <input type="text" placeholder="www..." name="itm_picture" value="<?php echo $itm["picture"] ; ?>"><br>
            Categories :
            <?php
            $categories = mysqli_query($_MYSQL, "SELECT * FROM categories");
            $itmcat = explode(",", $itm["categories"]);
            while ($cat = mysqli_fetch_array($categories)) {
                if (haveCat($itmcat, $cat["id"]))
                    echo "<input type='checkbox' name='" . $cat["name"] . "' value='" . $cat["id"] . "' checked>" . $cat["name"] . "</option>";
                else
                    echo "<input type='checkbox' name='" . $cat["name"] . "' value='" . $cat["id"] . "' >" . $cat["name"] . "</option>";
            }
            ?>
            <br><textarea placeholder="Description" name="itm_description"><?php echo $itm["description"] ; ?></textarea>
            <br><input type="submit" value="OK">
            </form>
        <?php
        }
        else if ($table = "users") {
            $query = "SELECT * FROM $table WHERE id=$id" ;
            $usr = mysqli_fetch_array(mysqli_query($_MYSQL, $query)) ;
            ?>
            <form name="user-add" action="admin.php?page=edt&type=usr&id=<?php echo $usr["id"]; ?>" method="post">
                Edit the following user :
                <input name="usr_id" type="number" value="<?php echo $usr["id"]; ?>" disabled>
                <input type="text" placeholder="name" title="username" name="usr_name" value="<?php echo $usr["username"] ; ?>">
                <input type="password" title="password" name="usr_pass">
                <input type="submit" value="OK">
            </form>
            <?php
        }
    }
    else
        echo "<div class='error'>There was a problem accessing the editor</div>";