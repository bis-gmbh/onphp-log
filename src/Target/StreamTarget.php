<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

use \Psr\Log\LogLevel;
use \Onphp\Log\Exception\InvalidArgumentException;
use \Onphp\Log\Exception\RuntimeException;

/**
 * Class StreamTarget
 * @package Onphp\Log\Target
 */
class StreamTarget extends AbstractTarget
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var resource|null
     */
    private $stream = null;

    /**
     * @var string|null
     */
    private $customError = null;

    /**
     * @param string $filename
     * @param string $level
     * @throws InvalidArgumentException
     */
    public function __construct($filename, $level = LogLevel::DEBUG)
    {
        parent::__construct($level);

        if (is_string($filename)) {
            $this->filename = $filename;
        } else {
            throw new InvalidArgumentException('Invalid type');
        }
    }

    /**
     * @param array $record
     * @return null
     * @throws RuntimeException
     */
    public function write(array $record)
    {
        try {
            if ( ! is_resource($this->stream)) {
                $this->stream = fopen($this->filename, 'a');
            }
            fwrite($this->stream, $record['decorated']);
        } catch (\Exception $e) {
            $this->stream = null;
            throw new RuntimeException(sprintf(
                'File "%s" could not be opened: %s',
                $this->filename,
                preg_replace('/^fopen\(.*?\): /', '', $e->getMessage())
            ));
        }
    }

    public function __destruct()
    {
        if (is_resource($this->stream)) {
            try {
                fclose($this->stream);
            } catch (\Exception $e) {
                // do nothing
            }
        }
    }
}
