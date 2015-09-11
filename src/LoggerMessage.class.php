<?php
/***************************************************************************
 *   Copyright (C) 2006 by Denis Gabaidulin                                *
 *   sherman@oemdesign.ru                                                  *
 ***************************************************************************/
/* $Id: LoggerMessage.class.php 1069 2008-12-08 15:24:34Z hate $ */

	final class LoggerMessage
	{
		private $message 	= null;
		private $date		= null;
		
		public function __construct()
		{
			$this->date = Timestamp::makeNow();
		}
		
		/**
		 * @return LoggerMessage
		**/
		public static function create()
		{
			return new self;
		}
		
		/**
		 * @return LoggerMessage
		**/
		public function setMessage($message)
		{
			Assert::isString($message);
			
			$this->message = $message;
			
			return $this;
		}
		
		public function getMessage()
		{
			return $this->message;
		}
		
		/**
		 * @return LoggerMessage
		**/
		public function setDate(Timestamp $date)
		{
			$this->date = $date;
			
			return $this;
		}
		
		/**
		 * @return Timestamp
		**/
		public function getDate()
		{
			return $this->date;
		}
	}
?>