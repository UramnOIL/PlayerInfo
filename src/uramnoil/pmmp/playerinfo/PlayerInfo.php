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
    private $presenter;

    public function onLoad()
    {
        $this->presenter = new FormFactory();
    }

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register( "PlayerInfo", new PlayerListCommand( $this ) );
    }

    /**
     * @return IFormFactory
     */
    public function getPresenter(): IFormFactory
    {
        return $this->presenter;
    }
}