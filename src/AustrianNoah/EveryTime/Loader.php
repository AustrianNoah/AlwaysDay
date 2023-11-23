<?php

declare(strict_types=1);

/**
 * @author AustrianNoah
 */

namespace AustrianNoah\EveryTime;

use AustrianNoah\EveryTime\commands\EveryTimeCommand;
use AustrianNoah\EveryTime\tasks\MakeDayTask;
use AustrianNoah\EveryTime\tasks\UpdateChecker;
use AustrianNoah\EveryTime\tasks\UpdateLog;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Loader extends PluginBase {


    private static Loader $loaderInstance;

    public function onLoad(): void {
        self::$loaderInstance = $this;
        @mkdir($this->getDataFolder());
        $this->saveResource("settings.yml");
        $this->saveResource("commands.yml");
    }

    public function onEnable(): void {
        $this->getLogger()->info("Plugin was enabled.");
        $settings = new Config($this->getDataFolder() . "settings.yml", 2);
        if ($settings->getNested("EveryTime.Enabled")) {
            self::startDayTask();
            //$this->getLogger()->warning("Task is in Config Enabled");
        } else {
            //$this->getLogger()->warning("Task is in Config Disabled!");
        }

        if ($settings->getNested("EveryTime.UpdateCheck")) {
            self::checkUpdate();
        } else {
            // todo: nothing
        }

        self::initCommands();

        $cmd = new Config($this->getDataFolder() . "commands.yml", 2);
        if ($cmd->getNested("Main.EveryTime.Enabled")) {
            $this->getLogger()->warning("Command is Enabled");
        } else {
            $this->getLogger()->warning("Not Enabled Command detected");
        }


    }

    private function initCommands(){
        $cmd = new Config($this->getDataFolder() . "commands.yml", 2);
        $perm = PermissionManager::getInstance();
        $perm->addPermission(new Permission($cmd->getNested("Main.EveryTime.Permissions")));
        $map = Server::getInstance()->getCommandMap();
        $map->registerAll("everytime", [
            new EveryTimeCommand()
        ]);
    }

    private function startDayTask(): void {
        $this->getLogger()->warning("Starting MakeDayTask :)");

        $this->getScheduler()->scheduleRepeatingTask(new MakeDayTask(), 40);
    }

    private function checkUpdate(): void {
        $this->getScheduler()->scheduleDelayedTask(new UpdateLog(), 20);
        $this->getScheduler()->scheduleDelayedTask(new UpdateChecker(), 60);
    }

    /**
     *
     * Gets the Instance of Plugin
     */
    public static function getLoaderInstance(): self {
        return self::$loaderInstance;
    }

}
