<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\channel;

class ChannelAdapter{

    /** @var Channel[] $channels */
    private array $channels;

    /**
     * @param Channel[] $channels
     */
    public function __construct(array $channels) {
        $this->channels = $channels;
    }

    public function debug(string $message) : void {
        foreach($this->channels as $channel) {
            $channel->debug($message);
        }
    }

    public function info(string $message) : void {
        foreach($this->channels as $channel) {
            $channel->info($message);
        }
    }

    public function notice(string $message) : void {
        foreach($this->channels as $channel) {
            $channel->notice($message);
        }
    }
}