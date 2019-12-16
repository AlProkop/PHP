<?php
require_once "Element.php";
/**
 * Description of Form
 *
 * @author turunent
 */
class Span extends Element
{
    public function __construct($content)
    {
        parent::__construct("span", "", "", $content);
    }
}
