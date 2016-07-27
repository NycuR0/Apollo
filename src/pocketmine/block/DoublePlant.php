<?php
/*
From Nukkit and Genisys. Thanks
*/
namespace pocketmine\block;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
class DoublePlant extends Flowable{
	protected $id = self::DOUBLE_PLANT;
	
	const SUNFLOWER = 0;
	const LILAC = 1;
	const DOUBLE_TALLGRASS = 2;
	const LARGE_FERN = 3;
	const ROSE_BUSH = 4;
	const PEONY = 5;
	public function __construct($meta = 0){
		$this->meta = $meta;
	}
        public function DoublePlant(int $meta){
                return super($meta);
        }
	public function canBeReplaced(){
		return $this->meta == 2 || $this->meta == 3;
	}
	public function getName() : string{
		static $names = [
			0 => "Sunflower",
			1 => "Lilac",
			2 => "Double Tallgrass",
			3 => "Large Fern",
			4 => "Rose Bush",
			5 => "Peony"
		];
		return $names[$this->meta & 0x07];
	}
	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if(($this->meta & 0x08) == 8){
			//top
				if(!($this->getDown(0) instanceof DoublePlant)){
                                   $this->getLevel()->useBreakOn($this);
                                   return Level::BLOCK_UPDATE_NORMAL;
                                }
			}else{
				if($this->getDown(0)->isTransparent() || !$this->getSide(1) instanceof DoublePlant){ //Replace with common break method
				   $this->getLevel()->useBreakOn($this);
				   return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return 0;
	}
	/*public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getDown(0);
		$up = $this->getSide(1);
		if($down->getId() === self::GRASS or $down->getId() === self::DIRT){
			$this->getLevel()->setBlock($block, $this, true);
			$this->getLevel()->setBlock($up, Block::get($this->id, $this->meta ^ 0x08), true);
			return true;
		}
		return false;
	}*/
	public function getDrops(Item $item) : array{
		if(($this->meta & 0x08) !== 0x08){
			return [[Item::DOUBLE_PLANT, $this->meta, 1]];
		}else{
			return [];
		}
	}
	public function getColor(){
                return BlockColor::FOLIAGE_BLOCK_COLOR;
    }
}
