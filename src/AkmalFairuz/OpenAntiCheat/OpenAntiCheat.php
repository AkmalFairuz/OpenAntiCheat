<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat;

use AkmalFairuz\OpenAntiCheat\listener\EventListener;
use AkmalFairuz\OpenAntiCheat\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class OpenAntiCheat{

    private static self $instance;

    public static function getInstance(): ?OpenAntiCheat{
        return self::$instance ?? null;
    }

    private EventListener $eventListener;

    public function __construct(
        private PluginBase $plugin
    ) {
        if(self::getInstance() !== null) {
            return;
        }
        self::$instance = $this;
        $this->init();
    }

    public function getEventListener(): EventListener{
        return $this->eventListener;
    }

    private function init() : void{
        $this->plugin->saveResource("config.yml");
        Config::load($this->plugin->getDataFolder() . "config.yml");
        Server::getInstance()->getPluginManager()->registerEvents(($this->eventListener = new EventListener()), $this->plugin);
    }
}