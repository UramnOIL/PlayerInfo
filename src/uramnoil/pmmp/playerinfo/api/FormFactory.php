<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 12:35
 */

namespace uramnoil\pmmp\playerinfo\api;

use Frago9876543210\EasyForms\elements\Button;
use Frago9876543210\EasyForms\elements\Element;
use Frago9876543210\EasyForms\elements\Label;
use Frago9876543210\EasyForms\forms\CustomForm;
use Frago9876543210\EasyForms\forms\CustomFormResponse;
use Frago9876543210\EasyForms\forms\MenuForm;
use Frago9876543210\EasyForms\forms\ModalForm;
use pocketmine\Player;
use pocketmine\Server;

class FormFactory implements IFormFactory
{
    public function createPlayerListForm(): MenuForm
    {
        /** @var Player[] $players */
        $players = Server::getInstance()->getOnlinePlayers();
        $menu = [];

        foreach( $players as $player )
        {
            $menu[] = new Button( $player->getName() );
        }

        return new MenuForm("PlayerList", "Choose Player", $menu,
            function( Player $player, Button $selected ) use( $players )
            {
                $target = $players[ $selected->getValue() ];

                if( $target->isOnline() )
                {
                    $player->sendForm( $this->createPlayerInfoForm( $target ) );
                }
                else
                {
                    $player->sendForm( $this->createPlayerUnexistsForm() );
                }

                $this->createPlayerInfoForm( $target );
            }
        );
    }

    public function createPlayerInfoForm( Player $target ): CustomForm
    {
        return new CustomForm( $target->getName(), $this->createNormalElements( $target ),
            function( Player $player, CustomFormResponse $response): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            }
        );
    }

    /**
     * @return ModalForm
     */
    protected function createPlayerUnexistsForm(): CustomForm
    {
        return new CustomForm( "Player Does not exists", [],
            function( Player $player, CustomFormResponse $response ): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            }
        );
    }

    /**
     * @param Player $target
     * @return Element[]
     */
    protected function createNormalElements( Player $target ): array
    {
        $elements = [];
        $elements[] = new Label( "GAMEMODE: " . $target->getGAMEMODE() );
        $elements[] = new Label( "PING: " . $target->getPing() );
        $elements[] = new Label( "HP: " . $target->getHealth() . "/" . $target->getMaxHealth() );
        $elements[] = new Label( "ARMOR POINT: " . $target->getArmorPoints() );
        $elements[] = new Label( "FOOD: " . $target->getFood() . "/" . $target->getMaxFood() );
        $elements[] = new Label( "EXP:" );
        $elements[] = new Label( "  LEVEL: " . $target->getXpLevel() );
        $elements[] = new Label( "  TOTAL: " . $target->getCurrentTotalXp());
        $elements[] = new Label( "EFFECTS:");
        foreach( $target->getEffects() as $effectInstance )
        {
             $elements[] = new Label( "  " . $effectInstance->getType()->getName(). "(" . $effectInstance->getId() . ") " . "LV." . $effectInstance->getEffectLevel() );
        }
        $elements[] = new Label( "POSITION:");
        $elements[] = new Label( "  WORLD: " . $world = $target->getLevel()->getFolderName() );
        $elements[] = new Label( "  X: " . $x = $target->getX() );
        $elements[] = new Label( "  Y: " . $y = $target->getY() );
        $elements[] = new Label( "  Z: " . $z = $target->getZ() );

        return $elements;
    }
}