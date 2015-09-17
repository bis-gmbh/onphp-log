<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

use \Onphp\HttpRequest;
use \Onphp\Log\InvalidConfigurationException;

/**
 * Class HttpRequestInformer
 * @package Onphp\Log\Informer
 */
class HttpRequestInformer extends AbstractInformer
{
    protected $name = 'httprequest';

    /**
     * @param array $context
     * @return string
     * @throws InvalidConfigurationException
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
    
            $data = "\n\n"
                . 'Request:'
                . "\n_POST=" . var_export($request->getPost(), true)
                . "\n_GET=" . var_export($request->getGet(), true)
                . "\n_COOKIE=" . var_export($request->getCookie(), true)
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
