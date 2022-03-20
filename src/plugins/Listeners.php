<?php declare(strict_types = 1);
namespace plugins;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class Listeners extends Forms implements Listener {

    public function __construct(private Loader $plugin) {
        parent::__construct($this->plugin);
    }
    
    public function onPlayerJoinEvent(PlayerJoinEvent $event) {
        if ($this->plugin->getValueShowUI()) {
        	$this->sendToPlayer($event->getPlayer());
        }
    }
}