#!/usr/bin/php
<?php

echo "Entrez un nombre: ";

while (($ret = fgets(STDIN)) != NULL)
{
$ret = rtrim($ret);
if (!is_numeric($ret))
echo "'$ret' n'est pas un chiffre\n";
else if ($ret % 2 == 0)
echo "Le chiffre $ret est Pair\n";
else
echo "Le chiffre $ret est Impair\n";
echo "Entrez un nombre: ";
}
echo "\n";

?>