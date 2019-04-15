<?php
// required files
require_once "Element.php";

// parent class for form is element
class Form extends Element
{
    // constructor for form 
    public function __construct($content, $method="POST")
    {
        // parent constructor, tag: "form", name:"", value: "", content: $content;
        parent::__construct("form", "", "", $content);
        
        // adding method (post) and action as attribute
        $this->addAttribute("method", $method);
        $this->addAttribute("action", htmlspecialchars($_SERVER["PHP_SELF"]));
    }
}
