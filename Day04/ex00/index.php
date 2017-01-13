<?php

   session_start();

   $submit = $_GET["submit"];
   if ($submit === "OK")
   {
   $_SESSION["login"] = $_GET["login"];
   $_SESSION["passwd"] = $_GET["passwd"];
   }
   ?>
<html>
  <head>
	<title>Ex00</title>
  </head>
  <body>
	<form action="" methode="GET">
	  <input type="text" name="login" placeholder="Votre login" value="<?=$_SESSION['login']; ?>"><BR />
	  <input type="password" name="passwd" placeholder="Votre mot de passe" value="<?=$_SESSION['passwd']; ?>"><BR />
	  <input type="submit" name="submit" value="OK">
	</form>
  </body>
</html>
