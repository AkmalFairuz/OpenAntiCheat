<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\listener;

use AkmalFairuz\OpenAntiCheat\player\PlayerDataManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener{

    /**
     * @param PlayerLoginEvent $event
     * @priority LOWEST
     */
    public function onPlayerLogin(PlayerLoginEvent $event) {
        PlayerDataManager::new($event->getPlayer());
    }

    /**
     * @param PlayerQuitEvent $event
     * @priority HIGHEST
     */
    public function onPlayerQuit(PlayerQuitEvent $event) {
        PlayerDataManager::destroy($event->getPlayer());
    }
}