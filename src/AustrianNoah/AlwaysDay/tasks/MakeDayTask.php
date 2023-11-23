<?php


/**
 * Task for Making Day :)
 */

declare(strict_types=1);

namespace AustrianNoah\AlwaysDay\tasks;

use AustrianNoah\AlwaysDay\Loader;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\world\World;

class MakeDayTask extends Task {


    public function onRun(): void
    {
        foreach (Server::getInstance()->getWorldManager()->getWorlds() as $worlds) {
            $worlds->setTime(World::TIME_DAY);
            $worlds->stopTime();
            Loader::getLoaderInstance()->getLogger()->debug("Plugin makes Day :)");
        }
    }
}
