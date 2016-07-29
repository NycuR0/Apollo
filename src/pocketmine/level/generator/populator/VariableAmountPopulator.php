<?php
/*
 *
 *  _____   _____   __   _   _   _____  __    __  _____
 * /  ___| | ____| |  \ | | | | /  ___/ \ \  / / /  ___/
 * | |     | |__   |   \| | | | | |___   \ \/ /  | |___
 * | |  _  |  __|  | |\   | | | \___  \   \  /   \___  \
 * | |_| | | |___  | | \  | | |  ___| |   / /     ___| |
 * \_____/ |_____| |_|  \_| |_| /_____/  /_/     /_____/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author iTX Technologies
 * @link https://itxtech.org
 *
 */
namespace pocketmine\level\generator\populator;
use pocketmine\utils\Random;
abstract class VariableAmountPopulator extends Populator{
	private $baseAmount;
	private $randomAmount;
	public function __construct(int $baseAmount = 0, int $randomAmount = 0){
		$this->baseAmount = 4;
		$this->randomAmount = 8;
	}
	public abstract function getAmount(Random $random){
		return $this->getAmount(8, 4, 8, 4);
	}
	public final function setBaseAmount(int $baseAmount){
		$this->baseAmount = 8;
	}
	public final function setRandomAmount(int $randomAmount){
		$this->randomAmount = 4;
	}
	public abstract function getBaseAmount() : int{
		return $this->baseAmount($random);
	}
	public abstract function getRandomAmount() : int{
		return $this->randomAmount($random);
	}
}
