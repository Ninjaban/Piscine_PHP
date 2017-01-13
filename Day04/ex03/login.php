<?php
   include("auth.php");

   $login = $_GET["login"];
   $passwd = $_GET["passwd"];

   if (auth($login, $passwd))
   {
   session_start();
   $_SESSION["loggued_on_user"] = $login;
   echo "OK\n";
   }
   else
   {
   session_start();
   $_SESSION["loggued_on_user"] = "";
   echo "ERROR\n";
   }
   ?>
