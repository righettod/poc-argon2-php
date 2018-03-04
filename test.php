<?php
require_once('password_util.php');
use Eu\Righettod\Pocargon2\PasswordUtil as PUtil;
$p = new PUtil();
$password = "toto";
$hash = $p->hash($password);
var_dump($hash);
$check = $p->verify($password, $hash);
if($check){
  echo "IS EQUALS\n";
}else{
  echo "IS NOT EQUALS\n";
}
$check = $p->verify("564665", $hash);
if($check){
  echo "IS EQUALS\n";
}else{
  echo "IS NOT EQUALS\n";
}
