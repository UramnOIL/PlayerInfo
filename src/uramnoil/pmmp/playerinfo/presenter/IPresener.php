<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 13:01
 */

namespace uramnoil\pmmp\playerinfo\presenter;


use pocketmine\Player;
use uramnoil\pmmp\playerinfo\api\IFormFactory;

interface IPresener
{
    /**
     * @param IFormFactory $factory
     */
    public function __construct( IFormFactory $factory );

    /**
     * @param Player $source
     */
    public function sendPlayerListForm( Player $source ): void;

    /**
     * @param Player $source
     * @param Player $target
     */
    public function sendPlayerInfoForm( Player $source, Player $target ): void;
}