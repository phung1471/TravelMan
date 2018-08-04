<?php

namespace App\Classes;

class TravelMan {

	/**
	 * @var string
	 */
	private $pattern = '/^(\D*)\s*(\-?\d+(\.\d+)?)\s*(\-?\d+(\.\d+)?)$/';

	/**
	 * @var string
	 */
	private $shortestPath = '';

	/**
	 * @var array
	 */
	private $cityList = [];

	/**
	 * @var array
	 */
	private $startPoint = [];

	/**
	 * @var string
	 */
	private $errMessage = '';

	/**
	 * TravelMan constructor.
	 * @param $file
	 */
	public function __construct($file)	{
		$this->getListCityFromFile($file);
	}

	/**
	 * @param $file
	 */
	protected function getListCityFromFile($file) {
		try {
			$handle = fopen($file, "r");
			$isStart = false;

			while (($line = fgets($handle)) !== false) {
				$data = $this->getCityData(trim($line));

				if (!$isStart) {
					$this->startPoint[$data['name']] = [
						'latitude' => $data['latitude'],
						'longitude' => $data['longitude']
					];

					$isStart = true;
					continue;
				}

				$this->cityList[$data['name']] = [
					'latitude' => $data['latitude'],
					'longitude' => $data['longitude']
				];
			}

			fclose($handle);
		} catch (\Exception $e) {
			$this->errMessage .= '<p>' . $e->getMessage() . '</p>';
		}
	}


	/**
	 * @param $strData
	 * @return array
	 * @throws \Exception
	 */
	protected function getCityData($strData) {
		if (!preg_match($this->pattern, $strData)) {
			throw new \Exception('Wrong data format!');
		}

		$raw = explode(' ', $strData);
		$data = [];
		$data['name'] = '';

		foreach ($raw as $item) {
			if (is_numeric(trim($item))) {
				(isset($data['latitude'])) ? $data['longitude'] = $item : $data['latitude'] = $item;
			} else {
				$data['name'] .= ' ' . trim($item);
			}
		}

		$data['name'] = trim($data['name']);

		return $data;
	}

	/**
	 * @return string
	 */
	protected function getClosestCities() {
		$arrKeys = array_keys($this->cityList);
		if (count($arrKeys) == 1) return  ' -> ' . $arrKeys[0];

		$listDistance = $this->listDistance();
		$closestCity = array_keys($listDistance, min($listDistance), '===')[0];
        $this->startPoint = [];
        $this->startPoint[$closestCity] = $this->cityList[$closestCity];
		unset($this->cityList[$closestCity]);

		$this->shortestPath = $closestCity . $this->getClosestCities() . ' -> ' . $this->shortestPath;
	}

	/**
	 * @return array
	 */
	protected function listDistance() {
		$listDistance = [];
		$startPointName = key($this->startPoint);
		foreach ($this->cityList as $name => $data) {
			$listDistance[$name] = Helper::calcDistance($this->startPoint[$startPointName], $this->cityList[$name]);
		}

		return $listDistance;
	}

	/**
	 * @return string
	 */
	public function getShortestPath() {
		$this->getClosestCities();
		return $this->shortestPath;
	}

	/**
	 * @return array
	 */
	public function getCityList() {
		return $this->cityList;
	}

	/**
	 * @return string
	 */
	public function getStrCityList() {
		$list = '';

		foreach ($this->cityList as $name => $data) {
			$list .=  (empty($list)) ? $name : ', ' . $name;
		}

		return $list;
	}

	/**
	 * @return string
	 */
	public function getErrMessage() {
		return $this->errMessage;
	}

	/**
	 * @return string
	 */
	public function getStartPoint() {
		$keys = array_keys($this->startPoint);
		return $keys[0];
	}
}