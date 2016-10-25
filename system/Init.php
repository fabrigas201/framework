<?php namespace System;

use FilesystemIterator;

class Init{
	
	public static function func(){

		$fi = new FilesystemIterator(SYS . 'Functions', FilesystemIterator::SKIP_DOTS);

		foreach($fi as $file) {
			$ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);

			if($file->isFile() and $file->isReadable() and '.' . $ext == EXT) {
				require_once $file->getPathname();
			}
		}
		
	}
}