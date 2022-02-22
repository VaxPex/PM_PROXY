<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Process;

class TestCommand implements CommandExecutor{

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if($sender instanceof Player){
			if($args[0] === "join"){
				$proxy_path = Main::getInstance()->getDataFolder()."proxy.js";
				$new_address = $args[1];
				$new_port = $args[2];
				file_put_contents($proxy_path, str_replace(
					["let proxy_address = '';", "let proxy_port = 19132;"],
					["let proxy_address = '$new_address';", "let proxy_port = $new_port;"], file_get_contents($proxy_path)));
				$sender->getNetworkSession()->transfer("127.0.0.1", 19133); // dont move
				exec("node " . $proxy_path);
			}
			if($args[0] === "closehost"){
				Process::kill(Process::pid(), true);
			}
		}
		return true;
	}
}
