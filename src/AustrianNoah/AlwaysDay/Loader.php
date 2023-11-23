<?php

declare(strict_types=1);

/**
 * @author AustrianNoah
 */

namespace AustrianNoah\AlwaysDay;

use AustrianNoah\AlwaysDay\tasks\MakeDayTask;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Loader extends PluginBase {


    private static Loader $loaderInstance;

    public function onLoad(): void {
        self::$loaderInstance = $this;
        $this->saveResource("settings.yml");
    }

    public function onEnable(): void {
        $this->getLogger()->info("Plugin was enabled.");
        $settings = new Config($this->getDataFolder() . "settings.yml", 2);
        if ($settings->getNested("AlwaysDay.Enabled")) {
            self::startDayTask();
            $this->getLogger()->warning("Task is in Config Enabled");
        } else {
            $this->getLogger()->warning("Task is in Config Disabled!");
        }

    }

    private function startDayTask(): void {
        $this->getLogger()->warning("Starting MakeDayTask :)");
        $this->getScheduler()->scheduleRepeatingTask(new MakeDayTask(), 40);
    }

    /**
     *
     * Gets the Instance of Plugin
     */
    public static function getLoaderInstance(): self {
        return self::$loaderInstance;
    }

}