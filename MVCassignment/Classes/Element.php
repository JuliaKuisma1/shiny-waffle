<?php
require_once "Style.php";

// base class element
class Element
{
    protected $tag; // tag name
    protected $contents; // contents array
    protected $attributes; // attributes array
    protected $styles; 
    
    // constructor
    public function __construct($tag, $name="", $value="", $content="")
    {
        // using pseudo variable this
        $this->tag = $tag;
        $this->contents = array(); // create empty array
        $this->attributes = array();
        $this->styles = new Style();
        
        // adding values to arrays
        if ($name)
        {
            $this->attributes["name"] = $name;
        }
        if ($value)
        {
            $this->attributes["value"] = $value;
        }
        if ($content)
        {
            if (is_array($content))
            {
                $this->contents = $content;
            }
            else
            {
                $this->contents[] = $content;
            }
        } 
    }
    
    // magic method for outputting 
    public function __toString()
    {
        $str = "";
        $str .= "<$this->tag";
        
        // linking key to val
        foreach ($this->attributes as $key => $val)
        {
            $str .= $val?" $key='$val'":" $key";
        }
        
        $str .= $this->styles;
        $str .= ">";
        
        // cheking contents, contents lenght is higher than zero
        if (count($this->contents) > 0)
        {
            $str .= "\n";
            
            // get content from the array
            foreach ($this->contents as $content)
            {
                // add content to output string
                $str .= "$content"; 
            }
            
            // adding ending tag
            $str .= "</$this->tag>\n";
        }
        else
        {
            $str .= "\n";
        }
        
        return $str;
    }
    
    // adding content function
    public function addContent($content)
    {
        // add content to the contents array
        $this->contents[] = $content;
        
        return $this;
    }
    
    // adding attributes -function
    public function addAttribute($key, $val="")
    {
        // add atribute, linking key (id) to val (value)
        $this->attributes[$key] = $val;
        
        return $this;
    }
    
    // adding style -function
    public function addStyle($key, $val)
    {
        // add atribute to the contents array
        $this->styles->setStyleAttribute($key, $val);
        
        return $this;
    }
}
