<?php
namespace pocketmine\level\generator\normal\biome;
use pocketmine\block\Sapling;
use pocketmine\block\Block;
use pocketmine\level\generator\populator\Tree;
class ExtremeHills extends NormalBiome{
	public function __construct(){
		parent::__construct();
		$trees = new Tree(Sapling::SPRUCE);
		$trees->setBaseAmount(1);
		$this->addPopulator($trees);
		$this->setElevation(56, 100);
		$this->temperature = 0.25;
		$this->rainfall = 0.8;
	}
	public function getName(){
		return "Extreme Hills";
	}
}
