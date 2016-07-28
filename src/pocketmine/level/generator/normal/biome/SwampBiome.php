<?php

/*
Finish,without need add mushroom
*/

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Block;
use pocketmine\block\Flower as FlowerBlock;
use pocketmine\level\generator\populator\Flower;
use pocketmine\level\generator\populator\LilyPad;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\generator\populator\SugarCane;
use pocketmine\level\generator\populator\TallGrass;

class SwampBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$flower = new Flower();
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_BLUE_ORCHID]);
		$this->addPopulator($flower);

		$lilypad = new LilyPad();
		$this->addPopulator($lilypad);
		
		$tallGrass = new TallGrass();
		
		$sugarCane = new SugarCane();
		
		$trees = new Tree();
		$this->addPopulator($trees);
		$this->addPopulator($sugarCane);
		$this->addPopulator($tallGrass);

		$this->setElevation(60, 66);

		$this->temperature = 0.80;
		$this->rainfall = 0.90;
	}

	public function getName() : string{
		return "Swamp";
	}

	public function getColor(){
		return 0x6a7039;
	}
}
