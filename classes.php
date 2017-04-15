<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.04.2017
 * Time: 18:48
 */
abstract class Car
{
    public $engine;
    var $transmission = 0;
    var $mileage = 0;  //пробег

    abstract public function move($distance, $speed, $trend);

    public function getMileage()
    {
        $this->mileage = $this->engine->distance;
        return $this->engine->mileage;

    }


}

class Niva extends Car
{
    public function __construct($engine, $transmission)
    {
        $this->engine = $engine;
        $this->transmission = $transmission;
        $this->mileage = 0;
    }


    public function move($distance, $speed, $trend)
    {
        $this->engine->on();
        $this->transmission->changeGears($trend, $speed);
        $this->engine->job($distance, $speed);
        $this->engine->off();
        $this->transmission->changeGears('neutral');
    }
}

abstract class Transmission
{

    abstract public function changeGears($trend, $speed);


}

class TransmissionAuto extends Transmission
{
    public $gears = array('forward' => false, 'back' => false, 'neutral' => true);

    public function changeGears($trend, $speed=0)
    {
        switch ($trend) {
            case 'forward':
                $this->nullGears($this->gears);
                $this->gears['forward'] = true;
                break;
            case 'back':
                $this->nullGears($this->gears);
                $this->gears['back'] = true;
                break;
            case 'neutral':
                $this->nullGears($this->gears);
                $this->gears['neutral'] = true;
                break;
            default:
                $this->nullGears($this->gears);
                $this->gears['neutral'] = true;
        }
    }

    protected function nullGears(&$array)
    {
        foreach ($array as $index => $item) {
            $array[$index] = false;
        }
    }


    public function getGear()
    {
        var_dump($this->$gears);
    }


}

class TransmissionManual extends Transmission
{
    public $gears;

    public function changeGears($trend, $speed=0)
    {
        if ($trend == 'forward' and ($speed < 20)) {
            $this->gears = 1;
        } elseif (($trend == 'forward') and ($speed >= 20)) {
            $this->gears = 2;
        } elseif ($trend == 'back') {
            $this->gears = -1;
        } elseif ($trend == 'neutral') {
            $this->gears = 0;
        }
    }

}

class Engine
{
    public $countHorsePower, $temperature, $mileage;
    public $inJob = false;
    public $distance = 0;

    public function __construct($countHorsePower)
    {
        $this->countHorsePower = $countHorsePower;

    }


    public function on()
    {
        $this->inJob = true;
        $this->distance = 0;
    }

    public function off()
    {
        $this->inJob = false;
        $this->mileage += $this->distance;
    }

    public function cold()
    {
        $this->temperature = $this->temperature - 10;

    }

    public function job($kilometersMustBeCrossed, $speed)
    {
        for ($i = 1; $i <= $kilometersMustBeCrossed; $i++) {
            $this->distance += 1;
            if ($this->temperature == 90) {
                $this->cold();
            }

            if (($this->distance % 10) == 0) {
                $this->temperature += 5;
            }

            if (($this->countHorsePower * 2) < $speed) {
                throw  new Exception('превышена максимально возможная скорость');
            }

        }
    }

}