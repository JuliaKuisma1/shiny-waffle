<?php
require_once "Element.php";

// submit class, for input elements in the html code
class Submit extends Element
{
    // constructor
    public function __construct($name, $value="")
    {
        // parent constructor
        parent::__construct("input", $name, $value);
        
        // adding attribute, <input type = "submit">...
        $this->addAttribute("type", "submit");
    }
}
