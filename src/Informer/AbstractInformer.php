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
     * @param array $record
     * @throws InvalidConfigurationException
     */
    public function process(array &$record)
    {
        if (empty($this->name)) {
            throw new InvalidConfigurationException('Informer system name not defined');
        }
        $record['context']['informer'][$this->name] = $this->getData();
    }

    /**
     * @return mixed
     */
    abstract public function getData();
}
