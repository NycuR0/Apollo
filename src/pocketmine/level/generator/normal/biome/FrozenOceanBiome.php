<?php

/*
Finish,in plus in future
*/

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Block;

class FrozenOceanBiome extends OceanBiome{

	public function __construct(){
		$this->setGroundCover([
			Block::get(Block::ICE, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::STILL_WATER, 0),
			Block::get(Block::DIRT, 0),
			Block::get(Block::DIRT, 0),
			Block::get(Block::DIRT, 0),
		]);
	        $this->temperature = 0.00;
		$this->rainfall = 0.00;
	}
	public function getName() : string{
		return "Frozen Ocean";
	}
}
