<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Informer;

use \Onphp\Log\InvalidConfigurationException;

/**
 * Class AbstractInformer
 * @package Onphp\Log\Informer
 */
abstract class AbstractInformer implements InformerInterface
{
    /**
     * @var string informer system name
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $context
     * @return string
     * @throws InvalidConfigurationException
     */
    public function process(array $context)
    {
        if (empty($this->name)) {
            throw new InvalidConfigurationException('Informer system name not defined');
        }
        return $this->getData($context);
    }

    /**
     * @param array $context
     * @return mixed
     */
    abstract public function getData(array $context);
}
