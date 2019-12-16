<?php
require_once "Element.php";
/**
 * Description of Form
 *
 * @author turunent
 */
class Form extends Element
{
    public function __construct($content, $method="POST")
    {
        parent::__construct("form", "", "", $content);
        $this->addAttribute("method", $method);
        $this->addAttribute("action", htmlspecialchars($_SERVER["PHP_SELF"]));
    }
}
