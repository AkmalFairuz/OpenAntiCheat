<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\player;

use AkmalFairuz\OpenAntiCheat\channel\ChannelAdapter;
use AkmalFairuz\OpenAntiCheat\channel\PlayerChannel;
use AkmalFairuz\OpenAntiCheat\check\Check;
use AkmalFairuz\OpenAntiCheat\check\combat\AutoClickerA;
use pocketmine\network\mcpe\protocol\ServerboundPacket;
use pocketmine\player\Player;

class PlayerData implements PlayerDataInterface{

    /** @var Check[] */
    private array $checks = [];
    /** @var ChannelAdapter */
    private ChannelAdapter $channelAdapter;
    public int $cps = 0;
    public int $resetCpsAt = 0;

    public function __construct(
        private Player $player
    ) {
        $this->channelAdapter = new ChannelAdapter([
            new PlayerChannel($this->player)
        ]);
        $this->registerCheck(new AutoClickerA($this));
    }

    private function registerCheck(Check $check) : void{
        if(!$check->isEnabled()) {
            return;
        }
        $this->checks[] = $check;
    }

    public function getPlayer(): Player{
        return $this->player;
    }

    public function handleInbound(ServerboundPacket $packet): void{
        foreach($this->checks as $check) {
            $check->inbound($packet);
        }
    }

    public function getChannelAdapter(): ChannelAdapter{
        return $this->channelAdapter;
    }

    public function getPlayerName() : string{
        return $this->player->getName();
    }
}