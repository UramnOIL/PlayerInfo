<?php
/**
 * Created by PhpStorm.
 * User: UramnOIL
 * Date: 2019/03/08
 * Time: 12:36
 */

namespace uramnoil\pmmp\playerinfo\api;


use Frago9876543210\EasyForms\forms\CustomForm;
use Frago9876543210\EasyForms\forms\MenuForm;
use pocketmine\Player;

interface IFormFactory
{
    /**
     * @return MenuForm
     */
    public function createPlayerListForm(): MenuForm;

    /**
     * @param Player $target
     * @return CustomForm
     */
    public function createPlayerInfoForm( Player $target ): CustomForm;

    /**
     * @param Player $target
     * @return CustomForm
     */
    public function createEditPlayerForm( Player $target ): CustomForm;
}