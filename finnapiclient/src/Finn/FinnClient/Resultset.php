<?php

namespace Finn\FinnClient;

//Cheating with magic methods on the model
class Resultset
{    
    public function __get($prop)
    {
        if(isset($this->$prop)) {
            return $this->$prop;
        } else {
            return null;
        }
    }
    
    public function __set($prop, $val)
    {
        $this->$prop = $val;
    }
}

?>