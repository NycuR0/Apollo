<?php
/*
Finish
*/
namespace pocketmine\level\generator\normal\biome;
use pocketmine\level\generator\populator\Sugarcane;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\block\Sapling;
use pocketmine\block\Block;
class SavannaBiome extends GrassyBiome{
	public function __construct(){
		parent::__construct();
		$sugarcane = new Sugarcane();
		$tallGrass = new TallGrass();
		$trees = new Tree(Sapling::ACACIA);
		$this->addPopulator($sugarcane);
		$this->addPopulator($tallGrass);
		$this->addPopulator($trees);
		$this->setElevation(62, 74);
		$this->temperature = 1.20;
		$this->rainfall = 0.20;
	}
	public function getName() : string{
		return "Savanna";
	}
	public function getColor(){
		return 0xBFA243;
	}
}
