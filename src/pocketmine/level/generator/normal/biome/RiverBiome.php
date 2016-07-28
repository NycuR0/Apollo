<?php

/*
Finish
*/

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\SugarCane;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\block\Block;
class RiverBiome extends WateryBiome{

	public function __construct(){
		parent::__construct();

		$sugarcane = new SugarCane();
		$tallGrass = new TallGrass();

		$this->addPopulator($sugarcane);
		$this->addPopulator($tallGrass);

		$this->setElevation(58, 62);

		$this->temperature = 0.50;
		$this->rainfall = 0.70;
	}

	public function getName() : string{
		return "River";
	}
}
