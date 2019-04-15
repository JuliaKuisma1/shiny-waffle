<?php

// style class for styling index...
class Style
{
    // style array
    protected $attrs;

    // key of the first attribute, val of the first attribute 
    public function __construct($key="", $val="")
    {
        if ($key && $val)
        {
            // adding key and val to attrs array
            $this->attrs = array($key => $val);
        }
        else
        {
            $this->attrs = array();
        }
    }
    
    // magic method
    public function __toString()
    {
        $str = "";
        $sp = "";
        
        // if array's length > 0
        if (count($this->attrs) > 0)
            {
            // style keyword for elements
            $str = " style=\"";

            foreach ($this->attrs as $key => $val)
            {
                $str .= "$sp$key: $val;";
                $sp = " ";
            }

            $str .= "\"";
        }
        
        return $str;
    }
    
    // key of the readable style attribute
    public function getStyleAttribute($key)
    {
        return $this-attrs[$key];
    }
    
    //key and val of witable attribute
    public function setStyleAttribute($key, $val)
    {
        $this->attrs[$key] = $val;
    }
}
