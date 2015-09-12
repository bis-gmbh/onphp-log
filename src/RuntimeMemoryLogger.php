<?php
/***************************************************************************
 *   Copyright (C) 2006 by Dmitry Demidov	                               *
 *   Dmitry.Demidov@noussoft.com                                           *
 ***************************************************************************/
/* $Id: RuntimeMemoryLogger.class.php 1069 2008-12-08 15:24:34Z hate $ */

	namespace Onphp\Log;

	use \Onphp\Singleton;
	use \Onphp\Format;

	class RuntimeMemoryLogger extends Logger
	{
		private static $log = array();
		
		/**
		 * @return RuntimeMemoryLogger
		**/
		public static function me()
		{
			return Singleton::getInstance(__CLASS__);
		}
		
		public function save(LoggerMessage $message)
		{
			$backTrace = debug_backtrace();
			
			for ($i = count($backTrace) - 1; $i >= 0; $i--) {
				
				$oneCall = $backTrace[$i];
				
				if (
					isset($oneCall['class'])
					&& (
						($oneCall['class'] == get_class($this))
						|| ($oneCall['class'] == '\Onphp\Log\LogManager')
					)
				) {
					$file = $oneCall['file'];
					$line = $oneCall['line'];
					
					self::$log[] =
						$file."($line)" 
						. "\ndate: ".$message->getDate()->toString()
						. "\nmessage: {\n".trim($message->getMessage())."\n}\n";
					
					break;
				}
			}
			
			return $this;
		}
		
		public function getSessionTextLog()
		{
			$recornNum = 1;
			$textLog = null;
			
			foreach (self::$log as $oneRecord) {
				$textLog .= "#".$recornNum."> {\n".$oneRecord. "\n}\n";
				
				$recornNum++;
			}
			
			if ($textLog)
				$textLog = "Log: \n-----------------------\n".$textLog;
			
			return Format::indentize($textLog);
		}
	}
?>