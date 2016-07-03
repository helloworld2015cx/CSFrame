<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: /2016/7/3/
 * Time: 9:44
 */

namespace sys\corePackage;
use sys\corePackage\Http\Http;
use sys\corePackage\Template\Template;

class Controller
{

    public $template;


//    public function init(){}

    private function _init_(Template $template)
    {
        $controller = Http::init()->getRequest()->getAccessController();
//        dump($controller);

        $module = Http::init()->getRequest()->getAccessModule();

//        $truename = rtrim($controller , 'Controller');

        $truename = substr($controller , 0 , -10);

//        dump($truename);

        $template->setTemplateDir(ROOT.'application/'.$module.'/View/'.$truename.'/');
        $template->setCompileDir(ROOT.'application/Runtime/'.$module.'/');
        $template->setDelimiter('{{','}}');

        $this->template = $template;
    }



    public function __construct()
    {
        $template = Template::init();
        $this->_init_($template);
        if(method_exists($this , 'init')){
            $this->init();
        }

    }

    public function assign($key , $value)
    {
        $this->template->assign($key , $value);
    }

//    public function __call($method){
//        $this->template->$method();
//    }

    public function display($template_name=null , $debugger = false)
    {
        $this->template->setSmartyConf('debugging' , $debugger ? true : false);

        if(!$template_name){
            $method = Http::init()->getRequest()->getAccessMethod();
            $template_name = $method.'.html';
        }

        $this->template->display($template_name);
    }


}