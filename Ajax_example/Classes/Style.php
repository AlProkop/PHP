<?php
/**
 * Style represents the style attribute of the html element
 *
 * @author turunent 16.1.2019
 */
class Style
{
    /**
     *
     * @var array(string => string) $attrs - style attribute array 
     */
    protected $attrs;

    /**
     * 
     * @param string $key - key of the first style attribute
     * @param string $val - value of the first style attribute
     */    
    public function __construct($key="", $val="")
    {
        if ($key && $val)
            $this->attrs = array($key => $val);
        else
            $this->attrs = array();
    }
    /**
     * 
     * @return string - printable output of the element's style attribute
     */    
    public function __toString()
    {
        $str = "";
        $sp = "";
        if (count($this->attrs) > 0)
            {
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
    /**
     * 
     * @param string $key - key of the readable style attribute
     * @return string - value of the readable style attribute
     */    
    public function getStyleAttribute($key)
    {
        return $this-attrs[$key];
    }
    /**
     * 
     * @param string $key - $key of the writable style attribute
     * @param string $val - value of the writable style attribute
     */    
    public function setStyleAttribute($key, $val)
    {
        $this->attrs[$key] = $val;
    }
}
