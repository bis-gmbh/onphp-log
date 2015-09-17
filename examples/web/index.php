<?php

use \Onphp\HttpRequest;
use \Onphp\RedirectView;
use \Onphp\PhpViewResolver;
use \Onphp\View;
use \Onphp\RouterRewrite;
use \Onphp\HttpUrl;
use \Onphp\RouterTransparentRule;
use \Onphp\RouterUrlHelper;
use \Onphp\HeaderUtils;
use \Onphp\RedirectToView;
use \Onphp\Log\LoggerInstance;
use \Onphp\Log\Target\EchoTarget;
use \Onphp\Log\Informer\DatetimeInformer;
use \Onphp\Log\Informer\HttpRequestInformer;
use \Onphp\Log\Informer\ExceptionInformer;
use \Onphp\Log\Decorator\RuntimeMemoryDecorator;

require '../config.inc.php';

$logger = new LoggerInstance('runtime');
$logger->addTarget(new EchoTarget(new RuntimeMemoryDecorator()));
$logger->addInformer(new DatetimeInformer());

try {
    $request =
        HttpRequest::create()->
        setGet($_GET)->
        setPost($_POST)->
        setCookie($_COOKIE)->
        setServer($_SERVER)->
        setFiles($_FILES);

    $controllerName = 'index';

    RouterRewrite::me()->
        setBaseUrl(
            HttpUrl::create()->
                parse($request->getServerVar('HTTP_HOST'))
        )->
        addRoute(
            'default',
            RouterTransparentRule::create(
                ':area/*'
            )->
            setDefaults(
                array(
                    'area' => $controllerName
                )
            )
        )->
        route($request);

    $controllerNs = '\\Onphp\\Log\\Examples\\controllers\\' . $controllerName;

    /** @var \Onphp\Controller $controller */
    $controller = new $controllerNs;

    $modelAndView = $controller->handleRequest($request);

    $view = $modelAndView->getView();
    $model = $modelAndView->getModel();

    $prefix = $request->getServerVar('HTTP_HOST').'?area=';

    if (!$view)
        $view = $controllerName;
    elseif (is_string($view) && $view == 'error')
        $view = new RedirectView($prefix);
    elseif ($view instanceof RedirectToView)
        $view->setPrefix($prefix);

    if (!$view instanceof View) {
        $viewName = $view;
        $view = PhpViewResolver::create(PATH_TEMPLATES, EXT_TPL)->
            resolveViewName($viewName);
    }

    if (!$view instanceof RedirectView) {
        $model->
            set(
                'selfUrl',
                RouterUrlHelper::url(
                    array('area' => $controllerName),
                    RouterRewrite::me()->getCurrentRouteName(),
                    true
                )
            )->
            set('baseUrl', $_SERVER['PHP_SELF']);
    }

    $view->render($model);

    $logger->addInformer(new HttpRequestInformer($request));
    // throw new Exception('Test exception');
    $logger->info('Test info');

} catch (Exception $e) {
    $logger->addInformer(new ExceptionInformer($e));

    if (__LOCAL_DEBUG__) {
        $logger->error('Exception throwed');
    }
    else {
        if (!HeaderUtils::redirectBack()) {
            HeaderUtils::redirectRaw('/');
        }
    }
}
