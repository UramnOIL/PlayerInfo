<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 12:57
 */

namespace uramnoil\pmmp\hellonewformapi\presenter;


use pocketmine\Player;
use pocketmine\Server;
use uramnoil\pmmp\hellonewformapi\api\IFormFactory;

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

    public function sendPlayerListForm( Player $target ): void
    {
        $form = $this->factory->createPlayerListForm( Server::getInstance()->getOnlinePlayers() );
        $target->sendForm( $form );
    }
    public function sendPlayerInfoForm(Player $target, Player $source): void
    {
        // TODO: Implement sendPlayerInfoForm() method.
    }
}