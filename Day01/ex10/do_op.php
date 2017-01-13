#!/usr/bin/php
<?php

if ($argc != 4)
{
echo "Incorrect Parameters\n";
return ;
}

$num1 = trim($argv[1]);
$num2 = trim($argv[3]);
$op = trim($argv[2]);

if ($op == "+")
print($num1 + $num2);
if ($op == "-")
print($num1 - $num2);
if ($op == "*")
print($num1 * $num2);
if ($op == "/")
print($num1 / $num2);
if ($op == "%")
print($num1 % $num2);
echo "\n";
?>