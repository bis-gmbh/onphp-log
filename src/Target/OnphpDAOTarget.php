<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

use \Psr\Log\LogLevel;
use \Onphp\Log\Exception\InvalidArgumentException;
use \Onphp\DAOConnected;
use \Onphp\Log\InternalLevel;
use \Onphp\Timestamp;

/**
 * Class OnphpDAOTarget
 * 
 * Should work with Log class meta configuration, described like this:
 * 
 * <class name="Log" type="final">
 *       <properties>
 *           <identifier type="Integer" />
 *           <property name="date" type="Timestamp" required="true" />
 *           <property name="level" type="Integer" required="true" />
 *           <property name="message" type="String" size="5000" required="true" />
 *       </properties>
 *       <pattern name="StraightMapping" />
 *   </class>
 * 
 * @package Onphp\Log\Target
 */
class OnphpDAOTarget extends AbstractTarget
{
    /**
     * @var null|DAOConnected
     */
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
