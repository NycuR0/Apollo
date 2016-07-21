<?php
namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Utils;

class UpdateServerCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.updateserver.description",
			"%pocketmine.command.updateserver.usage",
			["serverupdate"]
		);
		$this->setPermission("pocketmine.command.updateserver");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		$branch = 'master';//Currently for testing
		$build = max(Utils::getURL('https://circleci.com/gh/NycuRO/Apollo/tree/'.$branch));
		$sender->sendMessage($build);
	}
}