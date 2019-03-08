<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 11:50
 */

namespace uramnoil\pmmp\playerinfo;


use pocketmine\plugin\PluginBase;
use uramnoil\pmmp\playerinfo\api\FormFactory;
use uramnoil\pmmp\playerinfo\api\IFormFactory;
use uramnoil\pmmp\playerinfo\command\PlayerListCommand;

final class PlayerInfo extends PluginBase
{
    /**
     * @var IFormFactory
     */
    private $factory;

    public function onLoad()
    {
        $this->factory = new FormFactory();
    }

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register( "PlayerInfo", new PlayerListCommand( $this ) );
    }

    /**
     * @return IFormFactory
     */
    public function getFactory(): IFormFactory
    {
        return $this->factory;
    }
}