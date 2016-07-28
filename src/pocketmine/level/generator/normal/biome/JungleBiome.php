<?php

/*
Finish
*/

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\Sugarcane;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\generator\populator\Melon;
use pocketmine\level\generator\populator\CocoaBeans;
use pocketmine\block\Sapling;

class JungleBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$sugarcane = new Sugarcane();
		$tallGrass = new TallGrass();
		$trees = new Tree(Sapling::JUNGLE);
		
		$melon = new Melon();
		$this->addPopulator($melon);
		
		$cocoaBeans = new CocoaBeans();
		$this->addPopulator($cocoaBeans);

		$this->addPopulator($sugarcane);
		$this->addPopulator($tallGrass);
		$this->addPopulator($trees);

		$this->setElevation(64, 90);
		
		$this->temperature = 0.95;
		$this->rainfall = 0.80;
	}

	public function getName() : string{
		return "Jungle";
	}
	public function getColor(){
		return 0x92bc59;
	}
}
