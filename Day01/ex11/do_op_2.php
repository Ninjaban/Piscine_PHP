#!/usr/bin/php
<?php

if ($argc != 2)
{
echo "Incorrect Parameters\n";
return ;
}

$op = ' ';
if (strstr($argv[1], "+") != NULL)
$op = '+';
if (strstr($argv[1], "-") != NULL)
{
if ($op != ' ')
{
echo "Syntax Error\n";
return ;
}
$op = '-';
}
if (strstr($argv[1], "*") != NULL)
{
if ($op != ' ')
{
echo "Syntax Error\n";
return ;
}
$op = '*';
}
if (strstr($argv[1], "/") != NULL)
{
if ($op != ' ')
{
echo "Syntax Error\n";
return ;
}
$op = '/';
}
if (strstr($argv[1], "%") != NULL)
{
if ($op != ' ')
{
echo "Syntax Error\n";
return ;
}
$op = '%';
}

$tab = explode($op, $argv[1]);

$num1 = trim(trim($tab[0]));
$num2 = trim(trim($tab[1]));

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