<?php
require_once "Element.php";

// class for passwords
class Password extends Element
{
    // constructor
    public function __construct($name, $value="")
    {
        // parent constructor in element class
        parent::__construct("input", $name, $value);
        
        // adding new attribute
        $this->addAttribute("type", "password");
    }
}
