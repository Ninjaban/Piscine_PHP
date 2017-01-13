<?php
   $submit = $_POST["submit"];

   if ($submit === "OK" && $_POST["login"] != NULL && $_POST["oldpw"] != NULL && $_POST["newpw"] != NULL)
   {
   $oldkey = hash('whirlpool', $_POST["oldpw"]);
   $oldkey = hash('whirlpool', $oldkey);
   $newkey = hash('whirlpool', $_POST["newpw"]);
   $newkey = hash('whirlpool', $newkey);

   if (file_exists("../private/passwd") == true)
   {
   $file = file_get_contents("../private/passwd");
   $account = unserialize($file);

   $n = 0;
   foreach($account as $str)
   {
   if ($str["login"] == $_POST["login"] && $str["passwd"] == $oldkey)
   {
   $account[$n]["passwd"] = $newkey;
   file_put_contents("../private/passwd", serialize($account));
   echo "OK\n";
   return ;
   }
   $n = $n + 1;
   }
   }

   }
   echo "ERROR\n";
   ?>
