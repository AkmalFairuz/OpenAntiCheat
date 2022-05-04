<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\player;

use pocketmine\player\Player;
use function spl_object_hash;

class PlayerDataManager{

    /** @var PlayerData[] */
    private static array $data = [];

    public static function get(Player $player) : ?PlayerData{
        return self::$data[spl_object_hash($player)] ?? null;
    }

    public static function new(Player $player) : void{
        self::$data[spl_object_hash($player)] = new PlayerData($player);
    }

    public static function destroy(Player $player) : void{
        unset(self::$data[spl_object_hash($player)]);
    }

    /**
     * @return PlayerData[]
     */
    public static function getAll(): array{
        return self::$data;
    }
}