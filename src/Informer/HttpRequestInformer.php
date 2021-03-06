<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

use \Onphp\HttpRequest;

/**
 * Class HttpRequestInformer
 * @package Onphp\Log\Informer
 */
class HttpRequestInformer extends AbstractInformer
{
    protected $name = 'httprequest';

    /**
     * @param array $context
     * @return string|null
     */
    public function getData(array $context)
    {
        $data = null;

        if (
            isset($context[$this->name])
            && ($context[$this->name] instanceof HttpRequest)
        ) {
            /** @var HttpRequest $request */
            $request = $context[$this->name];

            $server = $request->getServer();
    
            $data = "_POST=" . var_export($request->getPost(), true)
                . "\n_GET=" . var_export($request->getGet(), true)
                . "\n_COOKIE=" . var_export($request->getCookie(), true)
                . (
                    isset($server['REQUEST_METHOD'])
                        ?
                            "\nREQUEST_METHOD="
                            . var_export($server['REQUEST_METHOD'], true)
                        : null
                )
                . (
                    isset($server['REMOTE_ADDR'])
                        ?
                            "\nREMOTE_ADDR="
                            . var_export($server['REMOTE_ADDR'], true)
                        : null
                )
                . (
                    isset($server['HTTP_REFERER'])
                        ?
                            "\nREFERER="
                            . var_export($server['HTTP_REFERER'], true)
                        : null
                )
                . (
                    isset($server['HTTP_USER_AGENT'])
                        ?
                            "\nHTTP_USER_AGENT="
                            . var_export($server['HTTP_USER_AGENT'], true)
                        : null
                )
                . (
                    $request->getSession()
                        ?
                            "\n_SESSION=" . var_export($request->getSession(), true)
                        : null
                );
        }

        return $data;
    }
}
