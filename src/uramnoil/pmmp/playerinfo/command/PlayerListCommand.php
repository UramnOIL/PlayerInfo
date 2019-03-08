<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 13:31
 */

namespace uramnoil\pmmp\playerinfo\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use uramnoil\pmmp\playerinfo\PlayerInfo;

class PlayerListCommand extends Command
{
    const COMMAND_NAME = "playerlist";
    const COMMAND_DESCRIPTION = "Sends you a form showing Player List to chose player to see player's information.";
    const COMMAND_USAGE_MESSAGE = "/" . self::COMMAND_NAME;
    const COMMAND_ALIASES = ["pl"];
    const COMMAND_PERMISSION = "playerinfo.command.playerlist";

    /**
     * @var PlayerInfo
     */
    private $plugin;

    public function __construct(PlayerInfo $plugin )
    {
        $this->plugin = $plugin;
        parent::__construct( self::COMMAND_NAME, self::COMMAND_DESCRIPTION, self::COMMAND_USAGE_MESSAGE, self::COMMAND_ALIASES );
        $this->setPermission( self::COMMAND_PERMISSION );
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if( $this->plugin->isDisabled() )
        {
            return false;
        }

        /*if( $this->testPermission( $sender ) )
        {
            return false;
        }*/

        if( !$sender instanceof Player )
        {
            $sender->sendMessage("Please use in game");
        }

        $this->plugin->getFactory()->sendPlayerListForm( $sender );

        return true;
    }
}