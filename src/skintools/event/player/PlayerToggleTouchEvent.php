<?php

namespace skintools\event\player;

use pocketmine\event\player\PlayerEvent;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerToggleTouchEvent extends PlayerEvent implements Cancellable{
    /** @var \pocketmine\event\HandlerList */
    public static $handlerList = null;
    /** @var int */
    private $oldMode;
    /** @var int */
    private $newMode;
    /**
     * @param Player $player
     * @param int $oldMode
     * @param int $newMode
     */
    public function __construct(Player $player, $oldMode, $newMode){
        $this->player = $player;
        $this->oldMode = (int) $oldMode;
        $this->newMode = (int) $newMode;
    }
    /**
     * @param Player $player
     */
    public function setPlayer(Player $player){
        $this->player = $player;
    }
    /**
     * @return int
     */
    public function getOldMode(){
        return $this->oldMode;
    }
    /**
     * @param int $mode
     */
    public function setOldMode($mode){
        $this->oldMode = (int) $mode;
    }
    /**
     * @return int
     */
    public function getNewMode(){
        return $this->newMode;
    }
    /**
     * @param int $mode
     */
    public function setNewMode($mode){
        $this->newMode = (int) $mode;
    }
}