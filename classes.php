<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.04.2017
 * Time: 18:48
 */


abstract class Car{
  public $engine;
  var $transmission = 0;
  var $mileage = 0;  //пробег

  abstract  public function move($distance,$speed, $trend);

}

class Niva extends Car {
    public function __construct($engine)
    {
        $this->engine=$engine;
        
    }

    public function move($distance,$speed, $trend)
    {
        $this->engine->on();
        $this->engine->job($distance,$speed);
        $this->engine->off();
        
    }
}

abstract class Transmission{
    
}

class Engine{
    public $countHorsePower, $temperature, $mileage;
    public $inJob = false;
    public $distance = 0;

    public function __construct($countHorsePower)
    {
        $this->$countHorsePower = $countHorsePower;

    }


    public function on()
    {
        $this->inJob=true;
        $this->distance=0;

    }

    public function off()
    {
        $this->inJob=false;
    }

    public function cold()
    {
        $this->temperature = $this->temperature - 10;

    }

    public function job($distance, $speed)
    {
        for ($i = 1; $i <= $distance; $i++) {
            $this->distance += 1;
            if ($this->temperature == 90){
                $this->cold();
            }

            if (($this->distance % 10) == 0 ){
                $this->temperature += 5;
            }

            if (($this->countHorsePower * 2) < $speed){
                throw  new Exception('превышена максимально возможная скорость');
            }
        }

    }

}