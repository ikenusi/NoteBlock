<?php

namespace NoteBlock;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

use pocketmine\plugin\PluginBase;

use pocketmine\scheduler\Task;

use pocketmine\network\protocol\BlockEventPacket;

use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\block\Block;

use pocketmine\scheduler\CallbackTask;


class NoteBlock extends PluginBase implements Listener{

	public function onLoad(){
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if(!file_exists($this->getDataFolder())) @mkdir($this->getDataFolder());
		if(!file_exists($this->getDataFolder()."config.yml")) file_put_contents($this->getDataFolder()."config.yml", "Test");
		$this->config = file_get_contents($this->getDataFolder()."config.yml");
		if(!file_exists($this->getDataFolder().$this->config)) return $this->getServer()->getPluginManager()->disablePlugin($this);
		$this->BGM = file($this->getDataFolder().$this->config, FILE_IGNORE_NEW_LINES);
		$this->count = count($this->BGM) - 1;
		$this->play = 0;
		$this->sch = $this->getServer()->getScheduler();
		$this->doing = false;
	}

	public function onDisable(){
	}

	public function onInteract(PlayerInteractEvent $ev){
		$b = $ev->getBlock();
		if($b->getID() === Block::NOTEBLOCK){
			if($this->doing){
				$this->doing = false;
			}else{
				$this->doing = true;
				$this->playBGM($b->x, $b->y, $b->z);
				$ev->setCancelled(true);
			}
		}
	}

	public function playBGM($x, $y, $z){
		if(!$this->doing) return;
		if(count($this->getServer()->getOnlinePlayers()) !== 0){
			foreach($this->getServer()->getOnlinePlayers() as $p){
				$play = $this->play;
				if(!empty($this->BGM[$play])){
					$bgm = explode("|", $this->BGM[$play]);
					foreach($bgm as $stren){
						$inst = 0;
						if($stren < 0){
							$stren += 24;
							$inst = 4;
						}
						$pk = new BlockEventPacket();
						$pk->x = $x;
						$pk->y = $y;
						$pk->z = $z;
						$pk->case1 = $inst;
						$pk->case2 = $stren;
						$p->dataPacket($pk);
					}
				}
			}
			$this->play++;
			if($play >= $this->count) $this->play = 0;
		}
		$this->sch->scheduleDelayedTask(new CallbackTask([$this, "playBGM"], [$x, $y, $z]), 1);
	}

}