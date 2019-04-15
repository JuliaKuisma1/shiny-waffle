<?php

// class fromhandling which handles form actions
// such as post and get
// but using filters to be safe from sql injections
class FormHandling
{
    // required variables
    protected $postVariables, $getVariables, $tempVariables;
    
    // inserted calling parameter $method
    // basic constructor
    public function __construct($method="post", $filter="")
    {
        // creating array of input post ($_POST)
        $this->postVariables = $method=="post" || method == "both"? filter_input_array(INPUT_POST,
                $filter?$filter:FILTER_SANITIZE_FULL_SPECIAL_CHARS):array();
        // creating array of input get ($_GET)
        $this->getVariables = $method="get" || $method == "both"?filter_input_array(INPUT_GET,
                $filter?$filter:FILTER_SANITIZE_FULL_SPECIAL_CHARS):array();
        // creating array for tempvariables
        $this->tempVariables = array();
    }
    
    // cheking values
    public function __get($name)
    {
        if ($this->postVariables && isset($this->postVariables[$name]))
        {
            return $this->postVariables[$name];
        }
        if ($this->getVariables && isset($this->getVariables[$name]))
        {
            return $this->getVariables[$name];
        }
        if ($this->tempVariables && isset($this->tempVariables[$name]))
        {
            return $this->tempVariables[$name];
        }
        return "";
    }
    
    // linking name and value in arrays
    public function __set($name, $value)
    {
        // if postvariables[name] is set, then add value to array linked to name
        // doing this same operation with other variables
        if (isset($this->postVariables[$name]))
        {
            $this->postVariables[$name] = $value;
        }
        if (isset($this->getVariables[$name]))
        {
            $this->getVariables[$name] = $value;
        }
        else
        {
            $this->tempVariables[$name] = $value;
        }
        // do nothing
        return; 
    }
    
    // testing are every variable set
    public function __isset($name)
    {
        // getting variable and checking if array is set
        return $this->postVariables &&
                isset($this->postVariables[$name]) ||
                $this->getVariables &&
                isset($this->getVariables[$name]) ||
                $this->tempVariables &&
                isset($this->tempVariables[$name]);
    }
    
    // call function
    public function __call($name, $args)
    {
        // checking that isset and returning string containing 
        // postvariables and getvariables array
        if ($this->postVariables && isset($this->postVariables[$name]))
        {
            return " value='{$this->postVariables[$name]}']";
        }
        if ($this->getVariables && isset($this->getVariables[$name]))
        {
            return " value='{$this->getVariables[$name]}']";
        }
        // return empty
        return "";
    }
}
