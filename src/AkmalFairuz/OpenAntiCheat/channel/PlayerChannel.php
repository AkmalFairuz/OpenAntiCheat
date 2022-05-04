<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\channel;

use pocketmine\player\Player;

class PlayerChannel extends Channel{

    public function __construct(
        private Player $player
    ) {
    }

    protected function send(string $message): void{
        $this->player->sendMessage($message);
    }
}