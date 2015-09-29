<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

use \Psr\Log\LogLevel;
use \Onphp\Log\Exception\InvalidArgumentException;
use \Onphp\DAOConnected;
use \Onphp\Log\InternalLevel;
use \Onphp\Log\Decorator\DummyDecorator;
use \Onphp\Timestamp;

/**
 * Class OnphpDAOTarget
 * @package Onphp\Log\Target
 */
class OnphpDAOTarget extends AbstractTarget
{
    protected $object = null;

    /**
     * @param DAOConnected $object
     * @param string $level
     * @throws InvalidArgumentException
     */
    public function __construct($object, $level = LogLevel::DEBUG)
    {
        parent::__construct($level);

        if ( ! $object instanceof DAOConnected) {
            throw new InvalidArgumentException();
        }

        $this->object = $object;
    }

    /**
     * @param array $record
     * @return null
     * @throws \Exception
     */
    public function write(array $record)
    {
        $dao = $this->object->dao();
        $this->object->setDate(Timestamp::makeNow());
        $this->object->setLevel(InternalLevel::get($record['level']));
        $this->object->setMessage($record['decorated']);
        $dao->add($this->object);
    }
}
