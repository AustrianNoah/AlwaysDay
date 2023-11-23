<?php

declare(strict_types=1);

namespace AustrianNoah\EveryTime\commands;

use AustrianNoah\EveryTime\Loader;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\utils\Config;

class EveryTimeCommand extends VanillaCommand {

    public function __construct(){
        $cmd = new Config(Loader::getLoaderInstance()->getDataFolder() . "commands.yml", 2);
        parent::__construct($cmd->getNested("Main.EveryTime.Name"), $cmd->getNested("Main.EveryTime.Description"));
        $this->setAliases($cmd->getNested("Main.EveryTime.Aliases"));
        $this->setPermission($cmd->getNested("Main.EveryTime.Permissions"));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $cmd = new Config(Loader::getLoaderInstance()->getDataFolder() . "commands.yml", 2);
        if (!$this->testPermission($sender)) {
            return;
        }
        if ($cmd->getNested("Main.EveryTime.Enabled")) {
            $sender->sendMessage("Any Anal");
        } else {
            Loader::getLoaderInstance()->getLogger()->warning("Command executed by " . $sender->getName() . " but Command is still disabled");
        }
    }
}
