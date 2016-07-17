<?php
namespace pocketmine\level\generator\normal\biome;
use pocketmine\block\Block;
class FrozenRiverBiome extends NormalBiome{
	public function __construct(){
		$this->temperature = 0.0;
		$this->rainfall = 2.0;
		$this->setElevation(56, 74);
		$this->setGroundCover([
			Block::get(Block::SNOW_LAYER, 0),
			Block::get(Block::ICE, 0),
			Block::get(Block::SNOW_BLOCK, 0),
			Block::get(Block::SNOW_BLOCK, 0),
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
