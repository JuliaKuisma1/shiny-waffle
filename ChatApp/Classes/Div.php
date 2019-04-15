<?php

require_once "Element.php";

// class for Div element
class Div extends Element
{
    public function __construct($name, $value="")
    {
        parent::__construct("div", $name, $value);
        
        $this->addAttribute("id", $name);
    }
}

