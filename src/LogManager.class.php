<?php
/***************************************************************************
 *   Copyright (C) 2006 by Dmitry Demidov	                               *
 *   Dmitry.Demidov@noussoft.com                                           *
 ***************************************************************************/
/* $Id: LogManager.class.php 1069 2008-12-08 15:24:34Z hate $ */

	namespace Onphp\Log;

	use \Onphp\StaticFactory;
	use \Onphp\Assert;
	use \Exception;
	use \Onphp\HttpRequest;
	use \Onphp\Mail;
	use \Onphp\UnimplementedFeatureException;

	final class LogManager extends StaticFactory
	{
		/** @var Logger $logger */
		private static $logger	= null;
		
		/* void */ public static function setLogger(Logger $logger)
		{
			self::$logger = $logger;
		}
		
		/**
		 * @return Logger
		**/
		public static function getLogger()
		{
			return self::$logger;
		}
		
		public static function getSessionTextLog()
		{
			Assert::isTrue(self::$logger !== null, 'Logger must present');
			
			return self::$logger->getSessionTextLog();
		}
		
		/* void */ public static function save(LoggerMessage $message)
		{
			Assert::isTrue(self::$logger !== null, 'Logger must present');
			
			self::$logger->save($message);
		}
		
		/* void */ public static function saveText($message)
		{
			Assert::isTrue(self::$logger !== null, 'Logger must present');
			
			self::$logger->saveText($message);
		}
		
		/* void */ public static function saveException(Exception $exception)
		{
			Assert::isTrue(self::$logger !== null, 'Logger must present');
			
			self::$logger->saveText(
				"Exception:\n"
				.'class: '.get_class($exception)."\n"
				.'code: '.$exception->getCode()."\n"
				.'message: '.$exception->getMessage()."\n\n"
				.$exception->getTraceAsString()."\n"
			);
		}
		
		/* void */ public static function saveRequest(HttpRequest $request)
		{
			Assert::isTrue(self::$logger !== null, 'Logger must present');
			
			$server = $request->getServer();
			
			self::$logger->saveText(
				'Request:'
				."\n_POST=".var_export($request->getPost(), true)
				."\n_GET=".var_export($request->getGet(), true)
				."\n_COOKIE=".var_export($request->getCookie(), true)
				.(
					isset($server['HTTP_REFERER'])
						? 
							"\nREFERER="
							.var_export($server['HTTP_REFERER'], true)
						: null
				)
				.(
					isset($server['HTTP_USER_AGENT'])
						?
							"\nHTTP_USER_AGENT="
							.var_export($server['HTTP_USER_AGENT'], true)
						: null
				)
				.(
					$request->getSession()
						?
							"\n_SESSION=".var_export($request->getSession(), true)
						: null
				)
			);
		}
		
		/* void */ public static function deliverToBugLovers()
		{
			self::deliverToMail(
				BUGLOVERS,
				$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
			);
		}
		
		/* void */ public static function deliverToMail($mail, $subject)
		{
			Mail::create()->
			setTo($mail)->
			setSubject($subject)->
			setText(
				LogManager::getSessionTextLog()
			)->
			send();
		}
		
		/* void */ public static function deliverToFile($file)
		{
			throw new UnimplementedFeatureException();
		}
	}
?>