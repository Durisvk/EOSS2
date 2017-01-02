<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 11/30/16
 * Time: 5:51 PM
 */

namespace Forms\Controls;


/**
 * Every form element/control should implement this.
 *
 * @author Juraj Čarnogurský
 * Interface IElement
 * @package Forms\Controls
 */
interface IElement
{

    /**
     * Should render the element.
     * @return string
     */
    public function __toString();

}