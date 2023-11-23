<?php

declare(strict_types=1);

namespace AustrianNoah\EveryTime\tasks;

use AustrianNoah\EveryTime\Loader;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;

class UpdateChecker extends Task {


    public function onRun(): void
    {
        $updater = new Config(Loader::getLoaderInstance()->getDataFolder() . "settings.yml", 2);
        if ($updater->getNested("version") === "1.0.0") {
            Loader::getLoaderInstance()->getLogger()->info("Plugin is stable");
        } else {
            Loader::getLoaderInstance()->getLogger()->warning("Plugin is out of Date");
        }
    }
}