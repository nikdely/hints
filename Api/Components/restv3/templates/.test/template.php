<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?


$answer = json_decode($arResult['response'], true);
var_dump(count($answer));

print_r(json_encode($arResult['api']));

print_r($arResult['response']);


?>