<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    function _initNameSpace(){
		Zend_Loader_Autoloader::getInstance()->registerNamespace("PRM");
		Zend_Session::start();
	}
	
	function _initRoutes(){
		$router = Zend_Controller_Front::getInstance()->getRouter();
		$routesConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/routes.xml');
		$router->addConfig($routesConfig, 'routes');
	}
	
    /**
     * Init view
     */
    protected function _initView()
    {
        $theme = 'default-ui';
        if (isset($_COOKIE["theme"])) {
            $theme = $_COOKIE["theme"];
        } elseif (isset($this->config->app->theme)) {
            $theme = $this->config->app->theme;
        }
        define('THEME', $theme);
        
        // Initialize view
		$_options = $this->getOptions();
        $view = new Zend_View();
        $view->doctype('HTML5');
        $view->headMeta()
			->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
			->appendHttpEquiv('X-UA-Compatible', 'IE=Edge');
        $view->headTitle($_options['app']['name'])->setSeparator(' - ');

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);
 
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

}

