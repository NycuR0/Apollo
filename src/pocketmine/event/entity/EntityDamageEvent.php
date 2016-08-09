<?php
namespace pocketmine\event\entity;
use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\inventory\PlayerInventory;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\item\enchantment\enchantment;
class EntityDamageEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;
	const MODIFIER_BASE = 0;
	const MODIFIER_RESISTANCE = 1;
	const MODIFIER_ARMOR = 2;
	const MODIFIER_PROTECTION = 3;
	const MODIFIER_STRENGTH = 4;
	const MODIFIER_WEAKNESS = 5;

	const CAUSE_CONTACT = 0;
	const CAUSE_ENTITY_ATTACK = 1;
	const CAUSE_PROJECTILE = 2;
	const CAUSE_SUFFOCATION = 3;
	const CAUSE_FALL = 4;
	const CAUSE_FIRE = 5;
	const CAUSE_FIRE_TICK = 6;
	const CAUSE_LAVA = 7;
	const CAUSE_DROWNING = 8;
	const CAUSE_BLOCK_EXPLOSION = 9;
	const CAUSE_ENTITY_EXPLOSION = 10;
	const CAUSE_VOID = 11;
	const CAUSE_SUICIDE = 12;
	const CAUSE_MAGIC = 13;
	const CAUSE_CUSTOM = 14;
	const CAUSE_STARVATION = 15;
	const CAUSE_LIGHTNING = 16;
	private $cause;
	private $EPF = 0;
	private $fireProtectL = 0;
	private $modifiers;
	private $ratemodifiers = [];
	private $originals;
	private $use_armors = [];
	public function __construct(Entity $entity, $cause, $damage){
		$this->entity = $entity;
		$this->cause = $cause;
		if(is_array($damage)){
			$this->modifiers = $damage;
		}else{
			$this->modifiers = [
				self::MODIFIER_BASE => $damage
			];
		}
		$this->originals = $this->modifiers;

		if(!isset($this->modifiers[self::MODIFIER_BASE])){
			throw new \InvalidArgumentException("BASE Damage modifier missing");
		}
		if($cause !== self::CAUSE_VOID and $cause !== self::CAUSE_SUICIDE){
			if($entity->hasEffect(Effect::DAMAGE_RESISTANCE)){
				$RES_level = 1 - 0.20 * ($entity->getEffect(Effect::DAMAGE_RESISTANCE)->getAmplifier() + 1);
				if($RES_level < 0){
					$RES_level = 0;
				}
				$this->setRateDamage($RES_level, self::MODIFIER_RESISTANCE);
			}
		}
		if($entity instanceof Player and $entity->getInventory() instanceof PlayerInventory){
			switch($cause){
				case self::CAUSE_CONTACT:
				case self::CAUSE_ENTITY_ATTACK:
				case self::CAUSE_PROJECTILE:
				case self::CAUSE_FIRE:
				case self::CAUSE_LAVA:
				case self::CAUSE_BLOCK_EXPLOSION:
				case self::CAUSE_ENTITY_EXPLOSION:
				case self::CAUSE_LIGHTNING:
					$points = 0;
					foreach($entity->getInventory()->getArmorContents() as  $i){
						if($i->isArmor()){
							$points += $i->getArmorValue();
						}
					}
					if($points !== 0){
						$this->setRateDamage(1 - 0.04 * $points, self::MODIFIER_ARMOR);
						$this->use_armors = $entity->getInventory()->getArmorContents();
					}
					$spe_Prote = null;
					switch ($cause){
						case self::CAUSE_ENTITY_EXPLOSION:
						case self::CAUSE_BLOCK_EXPLOSION:
							$spe_Prote = Enchantment::TYPE_ARMOR_EXPLOSION_PROTECTION;
							break;
						case self::CAUSE_FIRE:
						case self::CAUSE_LAVA:
							$spe_Prote = Enchantment::TYPE_ARMOR_FIRE_PROTECTION;
							break;
						case self::CAUSE_PROJECTILE:
							$spe_Prote = Enchantment::TYPE_ARMOR_PROJECTILE_PROTECTION;
							break;
						default;
							break;
					}
					foreach($this->use_armors as  $i){
						if($i->isArmor()){
							$this->EPF += $i->getEnchantmentLevel(Enchantment::TYPE_ARMOR_PROTECTION);
							$this->fireProtectL = max($this->fireProtectL, $i->getEnchantmentLevel(Enchantment::TYPE_ARMOR_FIRE_PROTECTION));
							if($spe_Prote !== null){
								$this->EPF += 2 * $i->getEnchantmentLevel($spe_Prote);
							}
						}
					}
					break;
				case self::CAUSE_FALL:
					$i = $entity->getInventory()->getBoots();
					if($i->isArmor()){
						$this->EPF += $i->getEnchantmentLevel(Enchantment::TYPE_ARMOR_PROTECTION);
						$this->EPF += 3 * $i->getEnchantmentLevel(Enchantment::TYPE_ARMOR_FALL_PROTECTION);
					}
					break;
				case self::CAUSE_FIRE_TICK:
				case self::CAUSE_SUFFOCATION:
				case self::CAUSE_DROWNING:
				case self::CAUSE_VOID:
				case self::CAUSE_SUICIDE:
				case self::CAUSE_MAGIC:
				case self::CAUSE_CUSTOM:
				case self::CAUSE_STARVATION:
					break;
				default:
					break;
			}
			if($this->EPF !== 0){
				$this->EPF = min(20, ceil($this->EPF * mt_rand(50, 100) / 100));
				$this->setRateDamage(1 - 0.04 * $this->EPF, self::MODIFIER_PROTECTION);
			}
		}
	}
	public function getCause(){
		return $this->cause;
	}
	public function getOriginalDamage($type = self::MODIFIER_BASE){
		if(isset($this->originals[$type])){
			return $this->originals[$type];
		}
		return 0;
	}
	public function getDamage($type = self::MODIFIER_BASE){
		if(isset($this->modifiers[$type])){
			return $this->modifiers[$type];
		}
		return 0;
	}
	public function setDamage($damage, $type = self::MODIFIER_BASE){
		$this->modifiers[$type] = $damage;
	}
	public function getRateDamage($type = self::MODIFIER_BASE){
		if(isset($this->ratemodifiers[$type])){
			return $this->ratemodifiers[$type];
		}
		return 1;
	}
	public function setRateDamage($damage, $type = self::MODIFIER_BASE){
		$this->ratemodifiers[$type] = $damage;
	}
	public function isApplicable($type){
		return isset($this->modifiers[$type]);
	}
	public function getFinalDamage(){
		$damage = $this->modifiers[self::MODIFIER_BASE];
		foreach($this->ratemodifiers as $type => $d){
			$damage *= $d;
		}
		foreach($this->modifiers as $type => $d){
			if($type !== self::MODIFIER_BASE){
				$damage += $d;
			}
		}
		return $damage;
	}
	public function getUsedArmors(){
		return $this->use_armors;
	}
	public function getFireProtectL(){
		return $this->fireProtectL;
	}
	public function useArmors(){
		if($this->entity instanceof Player){
			if($this->entity->isSurvival() and $this->entity->isAlive()){
				foreach ($this->use_armors as $index=>$i){
					if($i->isArmor()){
						$i->useOn($i);
						$this->entity->getInventory()->setArmorItem($index, $i);
					}
				}
			}
			return true;
		}
		return false;
	}
}
