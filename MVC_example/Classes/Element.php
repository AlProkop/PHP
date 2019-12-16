<?php
require_once "Style.php";
/**
 * Description of Element
 *
 * @author turunent
 */
class Element
{
    protected $tag; // tag name
    
    protected $contents; // of the element
    protected $attributes;
    protected $styles;
    
    /**
     * __construct - constructor
     * 
     * @param string $tag - tag name of the element
     */
    public function __construct($tag, $name="", $value="", $content="")
    {
        $this->tag = $tag;
        $this->contents = array(); // create empty array
        $this->attributes = array();
        $this->styles = new Style();
        if ($name)
            $this->attributes["name"] = $name;
        if ($value)
            $this->attributes["value"] = $value;
        if ($content)
            if (is_array($content))
                $this->contents = $content;
            else
                $this->contents[] = $content;
    }
    
    /**
     * __toString - magic method for outputting
     * 
     * @return string
     */
    public function __toString()
    {
        $str = "";
        
        $str .= "<$this->tag";
        
        foreach ($this->attributes as $key => $val)
        {
            $str .= $val?" $key='$val'":" $key";
        }
        
        $str .= $this->styles;
        
        $str .= ">";
        
        // get content from the array
        if (count($this->contents) > 0)
        {
            $str .= "\n";
            
            foreach ($this->contents as $content)
            {
                $str .= "$content"; // add content to output string
            }
        
            $str .= "</$this->tag>\n";
        }
        else
            $str .= "\n";
        
        return $str;
    }
    
    public function addContent($content)
    {
        // add content to the contents array
        $this->contents[] = $content;
        
        return $this;
    }
    
    public function addAttribute($key, $val="")
    {
        // add atribute to the contents array
        $this->attributes[$key] = $val;
        
        return $this;
    }
    
    public function addStyle($key, $val)
    {
        // add atribute to the contents array
        $this->styles->setStyleAttribute($key, $val);
        
        return $this;
    }
}
