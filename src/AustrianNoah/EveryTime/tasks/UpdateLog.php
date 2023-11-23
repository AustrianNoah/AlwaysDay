<?php

declare(strict_types=1);

namespace AustrianNoah\EveryTime\tasks;

use AustrianNoah\EveryTime\Loader;
use pocketmine\scheduler\Task;

class UpdateLog extends Task {


    public function onRun(): void
    {
        Loader::getLoaderInstance()->getLogger()->info("Checking for Updates...");
    }
}
