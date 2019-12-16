<?php
require_once "Element.php";
/**
 * Description of Text
 *
 * @author turunent
 */
class Password extends Element
{
    public function __construct($name, $value="")
    {
        parent::__construct("input", $name, $value);
        
        $this->addAttribute("type", "password");
    }
}
