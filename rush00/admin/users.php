<?php

if (isset($_GET["del"])) { //delete smth
    if ($_GET["page"] == "usr") {
        $id = mysqli_real_escape_string($_MYSQL, $_GET["del"]);
        $query = "DELETE FROM users WHERE id=$id";
        if (mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The user n.$id has been deleted</div>";
        else
            echo "<div class='error'>The user could not be deleted</div>";
    }
}

if ($_POST) {
    $error = 0;
    if (   $_GET["page"] == "usr"
        && $_POST["usr_name"]
        && $_POST["usr_pass"]
    ) {
        $name = mysqli_real_escape_string($_MYSQL, $_POST["usr_name"]);
        $pass = hash('whirlpool', $_POST["usr_pass"]);
        $pass = hash('sha256', $pass);
        $name = trim($name);
        $query = mysqli_query($_MYSQL, "SELECT username FROM users WHERE username='$name'");
        if ($user = mysqli_fetch_array($query))
            $error = true;
        $query = "INSERT INTO users (username, mdp) VALUES('$name','$pass')";

        if (!$error && mysqli_query($_MYSQL, $query))
            echo "<div class='success'>The new user '$name' has been added</div>";
        else
            echo "<div class='error'>The new user could not be added</div>";
    }
}

?>

<form name="user-add" action="admin.php?page=usr" method="post">
    New user :
        <input type="text" placeholder="name" title="username" name="usr_name">
        <input type="password" title="password" name="usr_pass">
        <input type="submit" value="OK">
        </form>
        <hr>
        <table>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>action</th>
            </tr>
            <?php
            $users = mysqli_query($_MYSQL, "SELECT * FROM users");
            while ($usr = mysqli_fetch_array($users)) {
                echo "<tr>" ;
                echo "<td>" . $usr["id"] . "</td>";
                echo "<td>" . $usr["username"] . "</td>";
                echo "<td>  <a class='btn btn-del' href='admin.php?page=usr&del=" . $usr["id"] . "'>delete</a>
                            <a class='btn btn-act' href='admin.php?page=edt&type=usr&id=" . $usr["id"] . "'>edit</a></td>";
                echo "</tr>" ;
            }
            ?>
</table>