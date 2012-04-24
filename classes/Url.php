<?php

/**
 * @author Dmitri
 * @copyright 2012
 */

class Url{
    
    public $var = '';
    private $online;
    private $root;
    private $site_host;
        
    public function __construct(){
        require 'config.php';
        $this->online = $online;
        $this->site_host = $site_host;
        $this->root = $root;
        $this->explodeUrl();
    }
    
    private function explodeUrl(){
        $this->var = explode('/', $_SERVER['REQUEST_URI']);
        $this->var = array_map('strtolower', $this->var);
        $this->clean_array();
    }
    
    private function clean_array(){
        array_shift($this->var);
        if($this->online == 0){
            
            array_splice($this->var, 0 , 1);

        }
    }

    public function currentUrl(){

            $currentPage = $this->site_host.$_SERVER['REQUEST_URI'];
            

            //$currentPage = $this->root.$_SERVER['REQUEST_URI'];


        return($currentPage);
    }
    
}

?>