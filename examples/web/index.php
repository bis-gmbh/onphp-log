<?php
/**
 * @var \Onphp\Log\LoggerInstance $logger
 */

require '../config.inc.php';

$logger = \Onphp\Log\LoggerRepository::get('runtime');

$request = HttpRequest::create();

try {
    $request->
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

    /** @var Controller $controller */
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

    $logger->info('Test info', ['httprequest' => $request]);

    throw new Exception('Test exception');

} catch (\Exception $e) {
    if (__LOCAL_DEBUG__) {
        $logger->error('Exception throwed', [
            'httprequest' => $request,
            'exception' => $e,
        ]);
    }
    else {
        if (!HeaderUtils::redirectBack()) {
            HeaderUtils::redirectRaw('/');
        }
    }
}
