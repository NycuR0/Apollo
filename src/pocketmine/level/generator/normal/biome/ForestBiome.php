<?php

/*
Finish
*/

namespace pocketmine\level\generator\normal\biome;
use pocketmine\block\Block;
use pocketmine\block\Sapling;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\generator\populator\Flower;
use pocketmine\level\generator\populator\Pumpkin;

class ForestBiome extends GrassyBiome{

	const TYPE_NORMAL = 0;
	const TYPE_BIRCH = 1;

	public $type;

	public function __construct($type = self::TYPE_NORMAL){
		parent::__construct();

		$this->type = $type;

		$trees = new Tree($type === self::TYPE_BIRCH ? Sapling::BIRCH : Sapling::OAK);
		$this->addPopulator($trees);
		
		$flower = new Flower();
		$flower->addType([Block::DANDELION, 0]);
		$this->addPopulator($flower);

		$tallGrass = new TallGrass();

		$this->addPopulator($tallGrass);
		
		$pumpkin = new Pumpkin();
		$this->addPopulator($pumpkin);

		$this->setElevation(63, 68);

		if($type === self::TYPE_BIRCH){
			$this->temperature = 0.60;
			$this->rainfall = 0.50;
		}else{
			$this->temperature = 0.70;
			$this->rainfall = 0.50;
		}
	}

	public function getName() : string{
		return $this->type === self::TYPE_BIRCH ? "Birch Forest" : "Forest";
	}
	public function getColor(){
		return 0x8CBB5F;
	}

}
