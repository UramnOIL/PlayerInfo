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
use Frago9876543210\EasyForms\elements\Input;
use Frago9876543210\EasyForms\elements\Label;
use Frago9876543210\EasyForms\elements\Slider;
use Frago9876543210\EasyForms\elements\StepSlider;
use Frago9876543210\EasyForms\forms\CustomForm;
use Frago9876543210\EasyForms\forms\CustomFormResponse;
use Frago9876543210\EasyForms\forms\MenuForm;
use pocketmine\Player;
use pocketmine\Server;

class FormFactory implements IFormFactory
{
    public function createPlayerListForm(): MenuForm
    {
        /** @var Player[] $players */
        $players = Server::getInstance()->getOnlinePlayers();
        $menu = [];

        $num = 0;
        foreach( $players as $key => $player )
        {
            $menu[] = new Button( $player->getName() );
            $players[$num++] = $player;
        }

        return new MenuForm("PlayerList", "Choose Player", $menu,
            function( Player $player, Button $selected ) use( $players ): void
            {
                $target = $players[ $selected->getValue() ];

                if( $target->isOnline() )
                {
                    $player->sendForm( $player->isOp() ? $this->createEditPlayerForm( $target ) : $this->createPlayerInfoForm( $target ) );
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
            function( Player $player, CustomFormResponse $res ): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            },
            function( Player $player ): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            }
        );
    }

    public function createEditPlayerForm( Player $target ): CustomForm
    {
        return new CustomForm( $target->getName(), $this->createEditableElements( $target ),
            function( Player $player, CustomFormResponse $res ) use( $target ): void {
                $gamemode = $res->getStepSlider();
                $target->setGamemode( $gamemode->getValue() );

                $hp = $res->getSlider();
                $target->setHealth( $hp->getValue() );

                $maxHp = $res->getSlider();
                $target->setMaxHealth( $maxHp->getValue() );

                $food = $res->getSlider();
                $target->setFood( $food->getValue() );

                $xp = $res->getInput();
                if( is_numeric( $xp ) )
                {
                    $target->setCurrentTotalXp( $xp );
                }

                $player->sendForm( $this->createCompleteEditForm() );
            },
            function( Player $player ): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            }
        );
    }

    /**
     * @return CustomForm
     */
    protected function createPlayerUnexistsForm(): CustomForm
    {
        return new CustomForm( "Player does NOT exists", [],
            function( Player $player, CustomFormResponse $res ): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            },
            function( Player $player ): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            }
        );
    }

    protected function createCompleteEditForm(): CustomForm
    {
        return new CustomForm( "Complete", [],
            function( Player $player, CustomFormResponse $res ): void
            {
                $player->sendForm( $this->createPlayerListForm() );
            },
            function( Player $player ): void
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
        $elements[] = new Label( "HEALTH: " . $target->getHealth() . "/" . $target->getMaxHealth() );
        $elements[] = new Label( "ARMOR POINT: " . $target->getArmorPoints() );
        $elements[] = new Label( "FOOD: " . $target->getFood() . "/" . $target->getMaxFood() );
        $elements[] = new Label( "XP:" );
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

    /**
     * @param Player $target
     * @return Element[]
     */
    protected function createEditableElements( Player $target ): array
    {
        $elements = [];
        $elements[] = new StepSlider( "GAMEMODE", ["SURVIVAL", "CREATIVE", "ADVENTURE", "SPECTATOR"], $target->getGamemode() );
        $elements[] = new Label( "PING: " . $target->getPing() );
        $elements[] = new Slider( "HP", 0, 100, 1, $target->getHealth() );
        $elements[] = new Slider( "MAXHP", 0, 100, 1, $target->getHealth() );
        $elements[] = new Label( "ARMOR POINT: " . $target->getArmorPoints() );
        $elements[] = new Slider( "FOOD", 0, 20, 1, $target->getFood() );
        $elements[] = new Label( "EXP:" );
        $elements[] = new Label( "  LEVEL: " . $target->getXpLevel() );
        $elements[] = new Input( "  TOTAL", "NUMERIC ONRY", $target->getCurrentTotalXp() );
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