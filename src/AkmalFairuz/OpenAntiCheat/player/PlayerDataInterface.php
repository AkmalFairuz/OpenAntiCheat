<?php

namespace AkmalFairuz\OpenAntiCheat\player;

use pocketmine\network\mcpe\protocol\ServerboundPacket;

interface PlayerDataInterface{

    public function handleInbound(ServerboundPacket $packet) : void;
}