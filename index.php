<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.04.2017
 * Time: 18:22
 */

require_once 'classes.php';
$standartEngine = new Engine(87);
$niva = new Niva($standartEngine);

$niva->move(1007,10,'forward');
var_dump($niva);