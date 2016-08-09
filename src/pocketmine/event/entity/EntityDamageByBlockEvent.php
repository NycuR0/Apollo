<?php
namespace pocketmine\event\entity;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
class EntityDamageByBlockEvent extends EntityDamageEvent{
	private $damager;
	public function __construct(Block $damager, Entity $entity, $cause, $damage){
		$this->damager = $damager;
		parent::__construct($entity, $cause, $damage);
	}
	public function getDamager(){
		return $this->damager;
	}
}
