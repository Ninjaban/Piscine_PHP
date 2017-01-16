<?php

    function displayCart($_MYSQL, $cart, $link = true){
        $user = mysqli_fetch_array(mysqli_query($_MYSQL, "SELECT * FROM users WHERE id=" . $cart["user_id"]));
        echo '<tr>';
        echo '<td>' . $cart["id"] . '</td>' ;
        echo '<td>(' . $user["id"] . ') ' . $user["username"] . '</td>' ;
        echo '<td>' . $cart["total"] . '€</td>' ;
        echo '<td>' . $cart["creation"] . '</td>' ;
        if ($link)
            echo '<td><a class="btn btn-act" href="admin.php?page=crt&id=' . $cart["id"] . '">details</a><a class="btn btn-del" href="admin.php?page=crt&del=' . $cart["id"] . '">delete</a></td>' ;
        echo '</tr>';
    }

    if ($_POST["submit"] == 'OK' && isset($_POST["select-user"])) {
        $uid = mysqli_real_escape_string($_MYSQL, $_POST["select-user"]) ;
        $content = [1 => 0];
        $content = serialize($content);
        if (mysqli_query($_MYSQL, "INSERT INTO carts (user_id,content,total) VALUES($uid,'$content',0)"))
            echo "<div class='success'>The cart has been created</div>";
        else
            echo "<div class='error'>The cart could not be created</div>";
    }

    if (isset($_GET["del"])) {
        $id = mysqli_real_escape_string($_MYSQL, $_GET["del"]);
        if ($query = mysqli_query($_MYSQL, "DELETE FROM carts WHERE id=$id"))
            echo "<div class='success'>The cart has been deleted</div>";
        else
            echo "<div class='error'>The cart could not be deleted</div>";
    }

    if (isset($_GET["id"]) && isset($_POST["new_qtt"]) && isset($_POST["id"])) {
        $cid = mysqli_real_escape_string($_MYSQL, $_GET["id"]);
        $pid = mysqli_real_escape_string($_MYSQL, $_POST["id"]);
        $new_qtt = mysqli_real_escape_string($_MYSQL, $_POST["new_qtt"]);

        if ($query = mysqli_query($_MYSQL, "SELECT content FROM carts WHERE id=$cid")) {
            $cart = mysqli_fetch_array($query);
            $contents = unserialize($cart["content"]);
            if ($_POST["submit"] == "add")
                $contents[$pid] = intval($contents[$pid]) + intval($new_qtt);
            else
               $contents[$pid] = $new_qtt;
            $total = 0;
            foreach ($contents as $itm => $qtt){
                if ($query = mysqli_query($_MYSQL, "SELECT price FROM items WHERE id=$itm")){
                    $price = mysqli_fetch_array($query);
                    $total += $price["price"] * $qtt;
                }
            }
            $contents = serialize($contents);
            if ($query = mysqli_query($_MYSQL, "UPDATE carts SET content='$contents' WHERE id=$cid")) {
                echo "<div class='success'>The cart has been updated</div>";
                mysqli_query($_MYSQL, "UPDATE carts SET total=$total WHERE id=$cid");
                }
            else
                echo "<div class='error'>The cart could not be updated</div>";
        }
        else
            echo "<div class='error'>The cart could not be updated</div>";

    }

    if (isset($_GET["id"])) {
        $id = mysqli_real_escape_string($_MYSQL, $_GET["id"]);
        if ($query = mysqli_query($_MYSQL, "SELECT * FROM carts WHERE id=$id")) {
            $cart = mysqli_fetch_array($query);
            ?>
            <table>
                <tr>
                    <th>id</th>
                    <th>user</th>
                    <th>total</th>
                    <th>date</th>
                </tr>
                <?php displayCart($_MYSQL, $cart, false); ?>
            </table>
            <?php
                $contents = unserialize($cart["content"]);
            ?>
            <table>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>quantities</th>
                    <th>price unit</th>
                    <th>price total</th>
                    <th>action</th>
                </tr>
            <?php
            $total = 0;
            foreach ($contents as $itm => $qtt) {
                $query = "SELECT * FROM items WHERE id=$itm";
                $item = mysqli_fetch_array(mysqli_query($_MYSQL, $query));
                if ($qtt) {
                    ?>
                        <form name="edit_cart_item" method="post" action="admin.php?page=crt&id=<?=$id?>"><tr>
                            <td><input name="id" type="number" min="0" value="<?= $itm ?>" hidden><input name="id" type="number" min="0" value="<?= $itm ?>" disabled> </td>
                            <td><?= $item['name'] ?></td>
                            <td><input name="new_qtt" type="number" min="0" value="<?= $qtt ?>"></td>
                            <td><?= $item['price'] ?>€</td>
                            <td><?= ($item['price'] * $qtt) ?>€</td>
                            <td><input type="submit" name="submit" value="edit"></td>
                        </tr></form>

                    <?php
                    $total += ($item['price'] * $qtt);
                }
            }
            ?>
                <form name="add_cart_item" method="post" action="admin.php?page=crt&id=<?=$id?>">
                    <tr>
                        <td><input type="number" min="1" name="id"></td>
                        <td></td>
                        <td><input type="number" min="1" name="new_qtt" value="1"></td>
                        <td></td>
                        <td></td>
                        <td><input type="submit" name="submit" value="add"></td>
                    </tr>
                </form>
            </table>
        <?php }
        else
            echo "<div class='error'>We could not find the cart you were looking for.</div>";
    }
    else {
?>
<form name="cart_add" method="post">
    Add a new cart :
    <select title="select-user" name="select-user">
        <?php
            $users = mysqli_query($_MYSQL, "SELECT * FROM users");
            while ($usr = mysqli_fetch_array($users)) {
                echo "<option value='" . $usr["id"] . "'>" . $usr["username"] . "</option>";
            }
                ?>
            </select>
            <input type="submit" name="submit" value="OK">
</form>

<table>
    <tr>
        <th>id</th>
        <th>user</th>
        <th>total</th>
        <th>date</th>
        <th>action</th>
    </tr>

    <?php
    $query = mysqli_query($_MYSQL, "SELECT * FROM carts");

    while ($cart = mysqli_fetch_array($query))
        displayCart($_MYSQL, $cart);
    ?>

</table>
<?php } ?>