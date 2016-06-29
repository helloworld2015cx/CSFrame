<?php
namespace sys\corePackage\Template;
//use sys\corePackage\Template\Smarty3\Smarty;
//use Smarty;

class Template{

    private $smarty;
    private static $template = null;

    public static function init(){
        if(!self::$template){
            self::$template = new self;
        }
        return self::$template;
    }


    public function asset($key , $value){
        $this->smarty;
    }

    private function __construct(){
        $this->smarty = \Autoload::init()->getSmarty();
    }

    public function setDelimiter($left , $right){
        $this->smarty->left_delimiter = $left;
        $this->smarty->right_delimiter = $right;
        return $this;
    }

    public function setTemplateDir($templateDir){
        $this->smarty->template_dir = $templateDir;
        return $this;
    }
    public function setCompileDir($compileDir){
        $this->smarty->compile_dir = $compileDir;
        return $this;
    }

    public function setCache($dir , $time = 60){
        $this->smarty->cache_dir = $dir;
        $this->smarty->cache_lifetime = $time;
        $this->smarty->caching = true;
        return $this;
    }

}
