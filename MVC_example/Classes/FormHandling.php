<?php
/**
 * Description of FormHandling
 *
 * @author turunent
 */
class FormHandling
{
    // inserted attribute $tempVariables
    protected $postVariables, $getVariables, $tempVariables;
    
    // inserted calling parameter $method
    public function __construct($method="post", $filter="")
    {
        $this->postVariables = $method=="post" || $method == "both"? filter_input_array(INPUT_POST,
                $filter?$filter:FILTER_SANITIZE_FULL_SPECIAL_CHARS):array();
        $this->getVariables = $method=="get" || $method == "both"?filter_input_array(INPUT_GET,
                $filter?$filter:FILTER_SANITIZE_FULL_SPECIAL_CHARS):array();
        $this->tempVariables = array();
    }
    
    public function __get($name)
    {
        if ($this->postVariables && 
                isset($this->postVariables[$name]))
            return $this->postVariables[$name];
        if ($this->getVariables && 
                isset($this->getVariables[$name]))
            return $this->getVariables[$name];
        if ($this->tempVariables && 
                isset($this->tempVariables[$name]))
            return $this->tempVariables[$name];
        return "";
    }
    
    // inserted to be set attribute $tempVariables
    public function __set($name, $value)
    {
        if (isset($this->postVariables[$name]))
            $this->postVariables[$name] = $value;
        else if (isset($this->getVariables[$name]))
            $this->getVariables[$name] = $value;
        else
            $this->tempVariables[$name] = $value;
        return; // do nothing
    }
    
    public function __isset($name)
    {
        return $this->postVariables &&
                isset($this->postVariables[$name]) ||
                $this->getVariables &&
                isset($this->getVariables[$name]) ||
                $this->tempVariables &&
                isset($this->tempVariables[$name]);
    }
    
    public function __call($name, $args)
    {
        if ($this->postVariables &&
                isset($this->postVariables[$name]))
            return " value='{$this->postVariables[$name]}']";
        if ($this->getVariables &&
                isset($this->getVariables[$name]))
            return " value='{$this->getVariables[$name]}']";
        return "";
    }
}
