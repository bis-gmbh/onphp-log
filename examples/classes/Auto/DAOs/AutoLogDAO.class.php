<?php
/*****************************************************************************
 *   Copyright (C) 2006-2009, onPHP's MetaConfiguration Builder.             *
 *   Generated by onPHP-1.2.master at 2015-09-29 13:57:40                    *
 *   This file is autogenerated - do not edit.                               *
 *****************************************************************************/

	namespace Onphp\Log\Examples;
	
	abstract class AutoLogDAO extends \Onphp\StorableDAO
	{
		public function getTable()
		{
			return 'log';
		}
		
		public function getObjectName()
		{
			return '\Onphp\Log\Examples\Log';
		}
		
		public function getSequence()
		{
			return 'log_id';
		}
	}
?>