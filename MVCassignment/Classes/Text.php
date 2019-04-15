<?php
require_once "Element.php";

// text class
class Text extends Element
{
    // constructor
    public function __construct($name, $value="")
    {
        // parent constructor
        parent::__construct("input", $name, $value);
        
        // adding attribute: <input type = "text">...
        $this->addAttribute("type", "text");
    }
}
