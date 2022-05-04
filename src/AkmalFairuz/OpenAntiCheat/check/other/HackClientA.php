<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\check\other;

use AkmalFairuz\OpenAntiCheat\check\Check;
use AkmalFairuz\OpenAntiCheat\utils\Config;
use pocketmine\network\mcpe\protocol\types\DeviceOS;
use function explode;
use function strtoupper;

/**
 * Checks if the players using Toolbox (a popular MCPE hack client)
 */

class HackClientA extends Check{

    const CONFIG_PREFIX = "checks.hack_client.a.";

    public function isEnabled(): bool{
        return (bool) Config::get(self::CONFIG_PREFIX . "enabled", true);
    }

    public function onJoin(): void{
        $playerInfo = $this->getPlayer()->getNetworkSession()->getPlayerInfo();
        $extraData = $playerInfo->getExtraData();

        $deviceOS = $extraData["DeviceOS"];
        if($deviceOS !== DeviceOS::ANDROID) {
            return;
        }
        $deviceModel = $extraData["DeviceModel"];
        $first = explode(" ", $deviceModel)[0];
        if($first !== strtoupper($first)) {
            $this->flag(["device_model" => $deviceModel]);
        }
    }
}