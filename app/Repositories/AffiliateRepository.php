<?php

namespace App\Repositories;

use App\Models\Affiliate;
use App\Interfaces\AffiliateRepositoryInterface;
use App\Abstractions\GeolocateAbstraction;

class AffiliateRepository extends GeolocateAbstraction implements AffiliateRepositoryInterface
{
    public function filter($expected_distance) 
    {
	$all = Affiliate::all();
        $result = [];
        foreach ($all as $key => $item)
	{
            $distanceInMeters = $this->distance($item->latitude, $item->longitude);
	    $distanceInKm = $this->toUnit($distanceInMeters, "km");

	    if ($distanceInKm>0 && $distanceInKm<=$expected_distance)
            {
                $result[$item->affiliate_id] = $item->name;
	    }
	}
	//Sort affiliates by affiliate_id ascending order
	ksort($result);

        return $result;
    }
}
