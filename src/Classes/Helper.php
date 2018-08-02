<?php

namespace App\Classes;

/**
 * Class Helper
 * @package App\Classes
 */
class Helper {

	/**
	 * @param array $city1
	 * @param array $city2
	 * @param string $unit
	 * @return float
	 */
	public static function calcDistance(array $city1, array $city2, $unit = 'k') {
		$lon1 = $city1['longitude'];
		$lat1 = $city1['latitude'];
		$lon2 = $city2['longitude'];
		$lat2 = $city2['latitude'];

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}

}