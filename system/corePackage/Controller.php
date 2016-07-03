<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/7/3/
 * Time: 9:44
 */

namespace sys\corePackage;
use sys\corePackage\Template\Template;

class Controller
{

    public $template;


    public function init(){}

    private function _init_(Template $template){

        $this->template = $template;

        $className = __NAMESPACE__;
//        dump(__METHOD__);
        $classname = strtolower($className);
        $truename = rtrim($classname , 'controller');

//        dump($truename);

//        $template->setTemplateDir('application/Home/View/'.$truename.'/');
        $template->setTemplateDir(ROOT.'application/Home/View/Index/');

        $template->setCompileDir(ROOT.'application/Home/Runtime/');

        $template->setDelimiter('{{','}}');

    }

    public function __construct(){
        $template = Template::init();
        $this->_init_($template);
        $this->init();
    }

    public function assign($key , $value){
        $this->template->assign($key , $value);
    }

//    public function __call($method){
//        $this->template->$method();
//    }

    public function display($template_name=null){
        $this->template->display($template_name);
    }


}