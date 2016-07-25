<?php

/*
Test
*/

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\Sugarcane;

class BeachBiome extends SandyBiome{

	public function __construct(){
		parent::__construct();

		$sugarcane = new Sugarcane();
		$sugarcane->setBaseAmount(6);

		$this->addPopulator($sugarcane);
		$this->temperature = 0.80;
		$this->rainfall = 0.00;

		$this->setElevation(62, 66);
	}
	public function getName() : string{
		return "Beach";
	}
}
