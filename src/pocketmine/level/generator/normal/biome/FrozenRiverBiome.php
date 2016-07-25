<?php
/*
Finish ,more in future
*/

namespace pocketmine\level\generator\normal\biome;
use pocketmine\block\Block;
use pocketmine\level\generator\populator\tree;
use pocketmine\block\Sapling;
class FrozenRiverBiome extends SnowyBiome{
	public function __construct(){
		parent::__construct();

		$trees = new Tree(Sapling::SPRUCE);
		$trees->setBaseAmount(1);
		$this->addPopulator($trees);
		
		$this->temperature = 0.0;
		$this->rainfall = 2.0;
		$this->setElevation(56, 74);
		$this->setGroundCover([
			Block::get(Block::SNOW_LAYER, 0),
			Block::get(Block::DIRT, 0),
			Block::get(Block::DIRT, 0),
			Block::get(Block::DIRT, 0),
			Block::get(Block::DIRT, 0),
 	]);
	}
	public function getName(){
		return "Frozen River";
	}
}
