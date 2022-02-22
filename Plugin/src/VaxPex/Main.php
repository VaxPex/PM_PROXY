<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\command\PluginCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase{
	use SingletonTrait;

	protected function onEnable() : void{
		self::setInstance($this);
		if(is_file($this->getDataFolder() . "proxy.js")){
			unlink($this->getDataFolder(). "proxy.js");
		}
		$this->saveResource("proxy.js");
		$this->saveResource("package.json");
		$this->saveResource("package-lock.json");
//		$this->copyDir($this->getResource("node_modules"), $this->getDataFolder());
		$this->getServer()->getCommandMap()->register("hack", new PluginCommand("hack", $this, new TestCommand()));
	}

	public function copyDir($source, $destination){
		if(!is_dir($destination)){
			$oldumask = umask(0);
			mkdir($destination, 01777); // so you get the sticky bit set
			umask($oldumask);
		}
		$dir_handle = @opendir($source);
		while($file = readdir($dir_handle)){
			if($file != "." && $file != ".." && !is_dir("$source/$file")) //if it is file
				copy("$source/$file", "$destination/$file");
			if($file != "." && $file != ".." && is_dir("$source/$file")) //if it is folder
				$this->copydir("$source/$file", "$destination/$file");
		}
		closedir($dir_handle);
	}
}