<?php

   $Vuser = "zaz";
   $Vpass = "jaimelespetitsponeys";

   $user = $_SERVER["PHP_AUTH_USER"];
   $pass = $_SERVER["PHP_AUTH_PW"];


   if ($Vuser == $user && $Vpass == $pass)
   $access = true;
   else
   $access = false;

   if ($access == true)
   {
   header("Content-Type: text/html");
   echo "<html><body>\nBonjour Zaz<br />\n<img src='data:image/png;base64,";
   echo base64_encode(file_get_contents("/Users/jcarra/http/MyWebSite/j03/img/42.png"));
   echo "'>\n</body></html>";
   }
   else
   {
   header("Content-Type: text/html");
   header("WWW-Authenticate: Basic realm=''Espace membres''");
   header("Connection: close");
   echo "<html><body>Cette zone est accessible uniquement aux membres du site</body></html>";
   }
   ?>
