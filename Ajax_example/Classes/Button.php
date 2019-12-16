<?php
require_once "Element.php";
/**
 * Description of Form
 *
 * @author turunent
 */
class Button extends Element
{
    public function __construct($id, $label, $onclick)
    {
        parent::__construct("button", "", "", $label);
        $this->addAttribute("id", $id);
        $this->addAttribute("onclick", $onclick);
    }
}
