<?php
namespace pocketmine\entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\Network;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;
class PrimedTNT extends Entity implements Explosive{
	const NETWORK_ID = 65;
	public $width = 0.98;
	public $length = 0.98;
	public $height = 0.98;
	protected $gravity = 0.04;
	protected $drag = 0.02;
	protected $fuse;
	public $canCollide = false;
	private $dropItem = true;
	public function __construct(FullChunk $chunk, CompoundTag $nbt, bool $dropItem = true){
		parent::__construct($chunk, $nbt);
		$this->dropItem = $dropItem;
	}
	public function attack($damage, EntityDamageEvent $source){
		if($source->getCause() === EntityDamageEvent::CAUSE_VOID){
			parent::attack($damage, $source);
		}
	}
	protected function initEntity(){
		parent::initEntity();
		if(isset($this->namedtag->Fuse)){
			$this->fuse = $this->namedtag["Fuse"];
		}else{
			$this->fuse = 80;
		}
	}
	public function canCollideWith(Entity $entity){
		return false;
	}
	public function saveNBT(){
		parent::saveNBT();
		$this->namedtag->Fuse = new ByteTag("Fuse", $this->fuse);
	}
	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}
		$this->timings->startTiming();
		$tickDiff = $currentTick - $this->lastUpdate;
		if($tickDiff <= 0 and !$this->justCreated){
			return true;
		}
		$this->lastUpdate = $currentTick;
		$hasUpdate = $this->entityBaseTick($tickDiff);
		if($this->isAlive()){
			$this->motionY -= $this->gravity;
			$this->move($this->motionX, $this->motionY, $this->motionZ);
			$friction = 1 - $this->drag;
			$this->motionX *= $friction;
			$this->motionY *= $friction;
			$this->motionZ *= $friction;
			$this->updateMovement();
			if($this->onGround){
				$this->motionY *= -0.5;
				$this->motionX *= 0.7;
				$this->motionZ *= 0.7;
			}
			$this->fuse -= $tickDiff;
			if($this->fuse <= 0){
				$this->kill();
				$this->explode();
			}

		}
		return $hasUpdate || $this->fuse >= 0 || abs($this->motionX) > 0.00001 || abs($this->motionY) > 0.00001 || abs($this->motionZ) > 0.00001;
	}
	public function explode(){
		$this->server->getPluginManager()->callEvent($ev = new ExplosionPrimeEvent($this, 4, $this->dropItem));
		if(!$ev->isCancelled()){
			$explosion = new Explosion($this, $ev->getForce(), $this, $ev->dropItem());
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = PrimedTNT::NETWORK_ID;
		$pk->eid = $this->getId();
		$pk->x = (float) $this->x;
		$pk->y = (float) $this->y;
		$pk->z = (float) $this->z;
		$pk->speedX = (float) $this->motionX;
		$pk->speedY = (float) $this->motionY;
		$pk->speedZ = (float) $this->motionZ;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}
