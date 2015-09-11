<?php
/***************************************************************************
 *   Copyright (C) 2006 by Denis Gabaidulin                                *
 *   sherman@oemdesign.ru                                                  *
 ***************************************************************************/
/* $Id: Logger.class.php 1069 2008-12-08 15:24:34Z hate $ */

	abstract class Logger extends Singleton
	{
		abstract public function save(LoggerMessage $message);
		
		abstract public function getSessionTextLog();
		
		/**
		 * @return Logger
		**/
		public function saveText($message)
		{
			$this->save(
				LoggerMessage::create()->
				setMessage($message)
			);
			
			return $this;
		}
	}
?>