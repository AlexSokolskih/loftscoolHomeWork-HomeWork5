<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.04.2017
 * Time: 18:22
 */

require_once 'classes.php';
$standartEngine = new Engine(87);
$transmission = new TransmissionManual();
$niva = new Niva($standartEngine, $transmission);

$niva->move(100,10,'forward');
$niva->move(100,10,'back');
echo 'пробег:'.$niva->getMileage().'<br>';
var_dump($niva);