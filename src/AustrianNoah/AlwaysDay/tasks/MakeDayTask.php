<?php


/**
 * Task for Making Day :)
 */

declare(strict_types=1);

namespace AustrianNoah\AlwaysDay\tasks;

use AustrianNoah\AlwaysDay\Loader;
use pocketmine\event\EventPriority;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\SetTimePacket;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\World;

class MakeDayTask extends Task {


    public function onRun(): void
    {


        Loader::getLoaderInstance()->getServer()->getPluginManager()->registerEvent(DataPacketSendEvent::class, function(DataPacketSendEvent $event): void {
            foreach ($event->getPackets() as $packet) {
                if ($packet instanceof SetTimePacket) {
                    $settings = new Config(Loader::getLoaderInstance()->getDataFolder() . "settings.yml", 2);
                    if ($settings->getNested("AlwaysDay.Status") === "day") {
                        $packet->time = World::TIME_DAY;
                    } else if ($settings->getNested("AlwaysDay.Status") === "night") {
                        $packet->time = World::TIME_NIGHT;
                    }
                }
            }
        }, EventPriority::HIGHEST, Loader::getLoaderInstance());
    }
}