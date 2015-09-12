<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Examples\controllers;

use \Onphp\Controller;
use \Onphp\HttpRequest;
use \Onphp\ModelAndView;

/**
 * Class index
 * @package examples\controllers
 */
class index implements Controller
{
    public function handleRequest(HttpRequest $request)
    {
        return ModelAndView::create()->setView('index');
    }
}
