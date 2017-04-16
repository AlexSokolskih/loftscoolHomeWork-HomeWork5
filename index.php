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



$niva->move(100, 10, Transmission::FORWARD);
$niva->move(100, 10, Transmission::BACK);
echo 'пробег:' . $niva->getMileage() . '<br>';
echo $niva;

$transmissionAuto = new TransmissionAuto();
$forseEngine = new Engine(200);
$audi = new Audi($forseEngine, $transmissionAuto);

$audi->move(1000,200,$transmission::FORWARD);
echo '<br>'.$audi;