<?php
   function auth($login, $passwd)
   {
   $key = hash('whirlpool', $passwd);
   $key = hash('whirlpool', $key);

   if (file_exists("../private/passwd") == true)
   {
   $file = file_get_contents("../private/passwd");
   $account = unserialize($file);

   $n = 0;
   foreach($account as $str)
   {
   if ($str["login"] == $login && $str["passwd"] == $key)
   return true;
   $n = $n + 1;
   }
   }

   }

   return false;
   ?>
