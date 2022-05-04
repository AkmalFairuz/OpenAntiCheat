<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\check;

use AkmalFairuz\OpenAntiCheat\player\PlayerData;
use AkmalFairuz\OpenAntiCheat\utils\Utils;
use pocketmine\network\mcpe\protocol\ServerboundPacket;
use pocketmine\player\Player;
use pocketmine\Server;
use ReflectionClass;
use function sprintf;

abstract class Check{

    protected int $violations = 0;
    protected string $name;

    public function __construct(
        protected PlayerData $data
    ){
        $this->name = (new ReflectionClass($this))->getShortName();
        $this->init();
    }

    public function init() : void{}

    public function inbound(ServerboundPacket $packet) : void {}

    public function getPlayerData() : PlayerData{
        return $this->data;
    }

    protected function flag(array $extraData = []) : void{
        $this->violations++;

        $this->data->getChannelAdapter()->info(sprintf("%s failed check: %s - %s", $this->data->getPlayerName(), $this->name, Utils::strArray($extraData)));
    }

    protected function getTick() : int{
        return Server::getInstance()->getTick();
    }

    public function isEnabled(): bool{
        return true;
    }

    public function onJoin() : void{}

    public function getPlayer() : Player{
        return $this->getPlayerData()->getPlayer();
    }
}