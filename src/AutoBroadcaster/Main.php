<?php

declare(strict_types=1);

namespace AutoBroadcaster;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

class Main extends PluginBase {

    public function onEnable() : void {
        $this->getLogger()->info("AutoBroadcaster Enabled! Plugin by DakerOmar.");
        @mkdir($this->getDataFolder());
        $this->saveResource("settings.yml");
        $this->settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->scheduler();
    }

    public function scheduler() {
        if(is_numeric($this->settings->get("seconds"))) {
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new BroadcastTask($this), $this->settings->get("seconds") * 20);
        } else {
            $this->getLogger()->warning("Plugin disabling, Seconds is not a numeric value please edit");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }
}
