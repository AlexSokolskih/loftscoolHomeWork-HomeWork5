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


    public function __construct(Engine $engine, Transmission $transmission)
    {
        $this->engine = $engine;
        $this->transmission = $transmission;
        $this->mileage = 0;
    }


    public function __toString()
    {
        $str = 'Движок:' . $this->engine . ' Коробка:' . $this->transmission;
        return $str;
    }


    //abstract public function move($distance, $speed, $trend);

    public function getMileage()
    {
        return $this->engine->mileage;

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

class Niva extends Car
{

}

class Audi extends Car
{

}

abstract class Transmission
{
    const FORWARD = 'forward';
    const BACK = 'back';
    const NEUTRAL = 'neutral';

    abstract public function changeGears($trend, $speed);


}

class TransmissionAuto extends Transmission
{
    public $gears = array('forward' => false, 'back' => false, 'neutral' => true);

    public function changeGears($trend, $speed = 0)
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


    public function __toString()
    {
        $str = " Коробка передач автоматическая ";
        foreach ($this->gears as $index => $item) {
            if ($this->gears[$index] === true) {
                $str .= ' Включена передача: ' . $index;
            };
        }

        return $str;
    }


}

class TransmissionManual extends Transmission
{
    public $gears;

    public function changeGears($trend, $speed = 0)
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


    public function __toString()
    {
        $str = " Коробка передач механическая Включена передача: ";
        switch ($this->gears) {
            case 1 :
                $str .= 'первая';
                break;
            case 2 :
                $str .= 'вторая';
                break;
            case 3 :
                $str .= 'третья';
                break;
            case 0 :
                $str .= 'нейтральная';
                break;
            case -1 :
                $str .= 'задняя';
                break;
            default:
                $str .= 'неизвестная';
                break;
        }

        return $str;
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

    public function __toString()
    {
        $str = 'Параметры двигателя ( Кол-во лошадиных сил: ' . $this->countHorsePower . ' Текущая температура: ' .
            $this->temperature . ' Пробег: ' . $this->mileage . ' Включен? ' . ($this->inJob ? 'да' : 'нет') . ' Текущая дистанция: ' . $this->distance . ')';
        return $str;
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