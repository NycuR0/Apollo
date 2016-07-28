<?php

/*
Finish
*/

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\block\Sapling;

class IcePlainsBiome extends SnowyBiome{

	public function __construct(){
		parent::__construct();

		$tallGrass = new TallGrass();

		$trees = new Tree(Sapling::SPRUCE);
		$this->addPopulator($trees);

		$this->addPopulator($tallGrass);

		$this->setElevation(63, 74);

		$this->temperature = 0.05;
		$this->rainfall = 0.80;
	}

	public function getName() : string{
		return "Ice Plains";
	}
}
