<?php

namespace App\Services;

class Escape {
    
    public function escape($str){
        
        return htmlentities($str);
    }
}
;