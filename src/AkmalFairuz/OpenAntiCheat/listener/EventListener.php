<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\listener;

use AkmalFairuz\OpenAntiCheat\player\PlayerDataManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

class EventListener implements Listener{

    /**
     * @param PlayerLoginEvent $event
     * @priority MONITOR
     */
    public function onPlayerLogin(PlayerLoginEvent $event) : void{
        PlayerDataManager::new($event->getPlayer());
    }

    /**
     * @param PlayerQuitEvent $event
     * @priority MONITOR
     */
    public function onPlayerQuit(PlayerQuitEvent $event) : void{
        PlayerDataManager::destroy($event->getPlayer());
    }

    /**
     * @param PlayerJoinEvent $event
     * @priority MONITOR
     */
    public function onPlayerJoin(PlayerJoinEvent $event) : void{
        PlayerDataManager::get($event->getPlayer())?->handleJoin();
    }

    /**
     * @param DataPacketReceiveEvent $event
     * @priority MONITOR
     */
    public function onDataPacketReceive(DataPacketReceiveEvent $event) : void{
        $player = $event->getOrigin()->getPlayer();
        if($player === null) {
            return;
        }
        $packet = $event->getPacket();
        PlayerDataManager::get($player)?->handleInbound($packet);
    }
}