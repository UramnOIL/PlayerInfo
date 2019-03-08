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
use uramnoil\pmmp\playerinfo\command\PlayerListCommand;
use uramnoil\pmmp\playerinfo\presenter\IPresener;
use uramnoil\pmmp\playerinfo\presenter\Presenter;

final class PlayerInfo extends PluginBase
{
    /**
     * @var IPresener
     */
    private $presenter;

    public function onLoad()
    {
        $this->presenter = new Presenter( new FormFactory() );
    }

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register( "PlayerInfo", new PlayerListCommand( $this ) );
    }

    /**
     * @return IPresener
     */
    public function getPresenter(): IPresener
    {
        return $this->presenter;
    }
}