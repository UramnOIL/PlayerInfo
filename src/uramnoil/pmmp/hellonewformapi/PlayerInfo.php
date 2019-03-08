<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 11:50
 */

namespace uramnoil\pmmp\hellonewformapi;


use pocketmine\plugin\PluginBase;
use uramnoil\pmmp\hellonewformapi\api\FormFactory;
use uramnoil\pmmp\hellonewformapi\presenter\IPresener;
use uramnoil\pmmp\hellonewformapi\presenter\Presenter;

final class PlayerInfo extends PluginBase
{
    /**
     * @var IPresener
     */
    private $presenter;

    public function onEnable()
    {
        $this->presenter = new Presenter( new FormFactory() );
    }

    /**
     * @return IPresener
     */
    public function getPresenter(): IPresener
    {
        return $this->presenter;
    }
}