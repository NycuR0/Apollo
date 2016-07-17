<?php
namespace pocketmine\level\generator\normal\biome;
use pocketmine\block\Block;
use pocketmine\level\generator\populator\Cactus;
use pocketmine\level\generator\populator\TallCacti;
use pocketmine\level\generator\populator\DeadBush;
class DesertBiome extends GrassyBiome{
	public function __construct(){
		parent::__construct();
		$cactus = new Cactus();
		$cactus->setBaseAmount(1);
		$tallCacti = new TallCacti();
		$tallCacti->setBaseAmount(1);
		$deadBush = new DeadBush();
		$deadBush->setBaseAmount(1);
		$this->addPopulator($cactus);
		$this->addPopulator($tallCacti);
		$this->addPopulator($deadBush);
		$this->temperature = 2.0;
		$this->rainfall = 0.0;
		$this->setElevation(56, 71);
		$this->setGroundCover([
			Block::get(Block::SAND, 0),
			Block::get(Block::SAND, 0),
			Block::get(Block::SAND, 0),
			Block::get(Block::SANDSTONE, 0),
			Block::get(Block::SANDSTONE, 0),
			Block::get(Block::SANDSTONE, 0),
			Block::get(Block::SANDSTONE, 0),
			Block::get(Block::SANDSTONE, 0),
		]);
	}
	public function getName() {
		return "Desert";
	}
}
