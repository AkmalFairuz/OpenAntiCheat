<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\channel;

use pocketmine\utils\TextFormat;

abstract class Channel{

    public const DEBUG = 0;
    public const INFO = 1;
    public const NOTICE = 2;

    public function debug(string $message) : void {
        $this->log(self::DEBUG, $message);
    }

    public function info(string $message) : void {
        $this->log(self::INFO, $message);
    }

    public function notice(string $message) : void {
        $this->log(self::NOTICE, $message);
    }

    public function log(int $level, string $message) : void {
        switch($level) {
            case self::DEBUG:
                $this->send(TextFormat::GRAY . "[DEBUG] " . $message);
                break;
            case self::INFO:
                $this->send(TextFormat::WHITE . "[INFO] " . $message);
                break;
            case self::NOTICE:
                $this->send(TextFormat::AQUA . "[NOTICE] " . $message);
                break;
        }
    }

    abstract protected function send(string $message) : void;
}