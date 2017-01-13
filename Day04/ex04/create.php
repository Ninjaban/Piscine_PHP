<?php
   header("Location: index.html", true, 302);

   $submit = $_POST["submit"];
   if ($submit === "OK" && $_POST["login"] != NULL && $_POST["passwd"] != NULL)
   {
   $key = hash('whirlpool', $_POST["passwd"]);
   $key = hash('whirlpool', $key);
   $account = array();

   if (file_exists("../private/") == false)
   mkdir("../private/");
   if (file_exists("../private/passwd") == true)
   {
   $file = file_get_contents("../private/passwd");
   $account = unserialize($file);
   }
   $verif = true;
   $tab = array("login" => $_POST["login"], "passwd" => $key);
foreach($account as $str)
if ($str["login"] == $tab["login"])
$verif = false;

if ($verif == true)
{
array_push($account, $tab);
file_put_contents("../private/passwd", serialize($account));
   echo "OK\n";
}
else
   echo "ERROR\n";
   }
   else
   echo "ERROR\n";
   ?>
