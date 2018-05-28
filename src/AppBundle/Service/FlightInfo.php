<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 28/05/18
 * Time: 10:11
 */

namespace AppBundle\Service;


class FlightInfo
{
    /**
     * @var string
     */
    private $unit;

    /**
     * FlightInfo constructor.
     * @param string $unit Defined in config.yml
     */
    public function __construct($unit)
    {
        $this->unit= $unit;
    }

    /**
     * Distance calculation between latitude/longitude based on Harnive's formula
     * http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe#PHP
     *
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $latitudeTo
     * @param $longitudeTo
     *
     * @return float
     */
    public function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $d = 0;
        $earth_radius = 6371;
        $dLat = deg2rad($latitudeTo - $latitudeFrom);
        $dLon = deg2rad($longitudeTo - $longitudeFrom);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));

        switch ($this->unit) {
            case 'km':
                $d = $c * $earth_radius;
                break;
            case 'mi':
                $d = $c * $earth_radius / 1.609344;
                break;
            case 'nmi':
                $d = $c * $earth_radius / 1.852;
                break;
        }

        return $d;
    }


    /**
     * Time calculation with distance and speed
     *
     * @param $distance
     * @param $speed
     *
     * @return float
     */
    public function getTime($distance, $speed)
    {
        $time=$distance/$speed;
        return $time;
    }

}