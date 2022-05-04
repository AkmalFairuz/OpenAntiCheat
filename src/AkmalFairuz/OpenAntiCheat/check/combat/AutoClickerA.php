<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\check\combat;

use AkmalFairuz\OpenAntiCheat\check\Check;
use AkmalFairuz\OpenAntiCheat\utils\Config;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\ServerboundPacket;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\network\mcpe\protocol\types\LevelSoundEvent;

/**
 * Checks if the players cps goes beyond a threshold
 */

class AutoClickerA extends Check{

    const CONFIG_PREFIX = "checks.auto_clicker.a.";

    private int $maxCps;

    public function init(): void{
        $this->maxCps = (int) Config::get(self::CONFIG_PREFIX . "max_cps", 16);
    }

    public function isEnabled(): bool{
        return (bool) Config::get(self::CONFIG_PREFIX . "enabled", true);
    }

    public function inbound(ServerboundPacket $packet): void{
        if(($packet instanceof InventoryTransactionPacket && $packet->trData instanceof UseItemOnEntityTransactionData) || ($packet instanceof LevelSoundEventPacket && $packet->sound === LevelSoundEvent::ATTACK_NODAMAGE)) {
            $this->data->cps++;
            if(($tick = $this->getTick()) > $this->data->resetCpsAt + 20) {
                $this->data->resetCpsAt = $tick;
                if(($cps = $this->data->cps) >= $this->maxCps) {
                    $this->flag(["cps" => $cps]);
                }
                $this->data->cps = 0;
            }
        }
    }
}