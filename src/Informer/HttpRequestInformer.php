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
class HttpRequestInformer implements InformerInterface
{
    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->setRequest($request);
    }

    /**
     * @param HttpRequest $request
     * @return HttpRequestInformer
     */
    public function setRequest(HttpRequest $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @param array $record
     * @return array
     */
    public function process(array $record)
    {
        $server = $this->request->getServer();
        
        $record['message'] .= "\n\n"
            . 'Request:'
            . "\n_POST=" . var_export($this->request->getPost(), true)
            . "\n_GET=" . var_export($this->request->getGet(), true)
            . "\n_COOKIE=" . var_export($this->request->getCookie(), true)
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
                $this->request->getSession()
                    ?
                        "\n_SESSION=" . var_export($this->request->getSession(), true)
                    : null
            );

        return $record;
    }
}
