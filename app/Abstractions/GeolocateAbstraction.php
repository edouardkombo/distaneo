<?php

namespace App\Abstractions;

use App\Interfaces\CalculateInterface;
use App\Interfaces\ConvertInterface;

abstract class GeolocateAbstraction implements CalculateInterface, ConvertInterface
{
    /**
     * Computes the distance between two coordinates.
     *
     * Implementation based on reverse engineering of
     * <code>google.maps.geometry.spherical.computeDistanceBetween()</code>.
     *
     * @param float $lat1 Latitude from the first point.
     * @param float $lng1 Longitude from the first point.
     *
     * @return float Distance in meters.
     */
    function distance($lat1, $lng1)
    {
	$lat1 = $this->_formatLatLong($lat1, -90, 90, "Latitude");
	$lng1 = $this->_formatLatLong($lng1, -180, 180, "Longitude");
        $lat2 = $this->_formatLatLong(env("OFFICE_LATITUDE"), -90, 90, "Latitude");
	$lng2 = $this->_formatLatLong(env("OFFICE_LONGITUDE"), -180, 180, "Longitude");

        if ($lat1==false || $lng1==false || $lat2==false || $lng2==false)
	{
            return 0;
	}

        $radius = (float) env("EARTH_RADIUS");

        static $x = M_PI / 180;
        $lat1 *= $x; $lng1 *= $x;
        $lat2 *= $x; $lng2 *= $x;
        $distance = 2 * asin(sqrt(pow(sin(($lat1 - $lat2) / 2), 2) + cos($lat1) * cos($lat2) * pow(sin(($lng1 - $lng2) / 2), 2)));

        return $distance * $radius;
    }

    private function _formatLatLong($number, $min, $max, $type)
    {
	$converted_number = (float) $number;
        if (!ctype_alpha($number) && !ctype_alnum($number) && is_numeric($number) && $converted_number>=$min && $converted_number<=$max)
	{
	    return $converted_number;
	}
	else
	{
            if (app()->environment(['local', 'testing']))
            {
                throw new \InvalidArgumentException("$type number is invalid!");
            }
	    else
	    {
                return false;
            }
        }	
    }

    function toUnit($distance, $unit = "km")
    {
        switch($unit)
        {
            case "km":
                return $distance/1000;
                break;
            case "mi":
                return $distance*0.000621371;
                break;
            case "m":
                return $distance;
                break;
        }
    }

    function toDecimals($distance, $dec=2)
    {
        return round($distance, $dec);
    }    
}
