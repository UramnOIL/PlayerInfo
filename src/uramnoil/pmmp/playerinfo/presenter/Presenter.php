<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 12:57
 */

namespace uramnoil\pmmp\playerinfo\presenter;


use pocketmine\Player;
use pocketmine\Server;
use uramnoil\pmmp\playerinfo\api\IFormFactory;

class Presenter implements IPresener
{
    /**
     * @var IFormFactory
     */
    private $factory;

    public function __construct( IFormFactory $factory )
    {
        $this->factory = $factory;
    }

    public function sendPlayerListForm( Player $source ): void
    {
        $source->sendForm( $this->factory->createPlayerListForm() );
    }
    public function sendPlayerInfoForm(Player $source, Player $target): void
    {
        $source->sendForm( $this->factory->createPlayerInfoForm( $target ) );
    }
}