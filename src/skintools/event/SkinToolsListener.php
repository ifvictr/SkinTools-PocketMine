<?php

namespace skintools\event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use skintools\SkinTools;

class SkinToolsListener implements Listener{
    /** @var SkinTools */
    private $plugin;
    /**
     * @param SkinTools $plugin
     */
    public function __construct(SkinTools $plugin){
        $this->plugin = $plugin;
    }
    /** 
     * @param EntityDamageEvent $event 
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function onEntityDamage(EntityDamageEvent $event){
        if($event instanceof EntityDamageByEntityEvent){
            if(($damager = $event->getDamager()) instanceof Player and ($entity = $event->getEntity()) instanceof Player){
                switch($this->plugin->getTouchMode($damager)){
                    case SkinTools::GIVE:
                        $event->setCancelled(true);
                        $this->plugin->setStolenSkin($entity, $damager);
                        $entity->sendMessage(TextFormat::GREEN.$damager->getName()." gave you their skin!");
                        $damager->sendMessage(TextFormat::GREEN.$entity->getName()." has your skin now!");
                        break;
                    case SkinTools::STEAL:
                        $event->setCancelled(true);
                        $this->plugin->setStolenSkin($damager, $entity);
                        $event->getDamager()->sendMessage(TextFormat::GREEN."You got ".$entity->getName()."'s skin.");
                        break;
                }
            }
        }
    }
    /** 
     * @param PlayerJoinEvent $event 
     * @priority HIGHEST
     */
    public function onPlayerJoin(PlayerJoinEvent $event){
        $this->plugin->storeSkinData($event->getPlayer());
        $this->plugin->setTouchMode($event->getPlayer(), SkinTools::NONE);
    }
    /** 
     * @param PlayerQuitEvent $event 
     * @priority MONITOR
     */
    public function onPlayerQuit(PlayerQuitEvent $event){
        if($this->plugin->isSkinStored($event->getPlayer())){
            $this->plugin->removeSkinData($event->getPlayer());
        }
        $this->plugin->clearTouchMode($event->getPlayer());
    }
}
