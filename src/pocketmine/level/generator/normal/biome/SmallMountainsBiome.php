<?php

/*
I don't search this biome . Is ready momentanly
*/

namespace pocketmine\level\generator\normal\biome;
use pocketmine\block\Block;

class SmallMountainsBiome extends MountainsBiome{

	public function __construct(){
		parent::__construct();

		$this->setElevation(63, 97);
	}

	public function getName() : string{
		return "Small Mountains";
	}
}
