<?php
/**
 * @author Dmitry Nezhelskoy <dmitry@nezhelskoy.pro>
 */

namespace Onphp\Log\Target;

/**
 * Class RuntimeMemoryTarget
 * @package Onphp\Log\Target
 */
class RuntimeMemoryTarget implements TargetInterface
{
    /**
     * @param array $record
     * @return null
     */
    public function write(array $record)
    {
        $backTrace = debug_backtrace();

        for ($i = count($backTrace) - 1; $i >= 0; $i--) {

            $oneCall = $backTrace[$i];

            if (
                isset($oneCall['class'])
                && (
                    ($oneCall['class'] == get_class($this))
                    || ($oneCall['class'] == '\Onphp\Log\LoggerInstance')
                )
            ) {
                $file = $oneCall['file'];
                $line = $oneCall['line'];

                $record['message'] = $file . "($line)" 
//                    . "\n\nDate: " . $record['datetime']
                    . "\n\nMessage: " . $record['message'] . "\n\n";

                break;
            }
        }

        $output = "Log:\n-----------------------\n" . $record['message'];

        echo '<pre>' . $output . '</pre>';
    }
}
