<?php
require_once "Element.php";
/**
 * Description of Text
 *
 * @author turunent
 */
class Textarea extends Element
{
    public function __construct($name, $value="")
    {
        parent::__construct("textarea", $name, $value);
    }
}
