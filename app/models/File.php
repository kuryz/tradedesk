<?php 
/**
 * 
 */
class File
{
	private $_extensions = ["image/jpg","image/png","image/jpeg","image/gif","application/pdf","application/msword"];
	private $_pictures = ["image/jpg","image/png","image/jpeg"];

	public function fileName($file)
	{
		if (isset($file)) {
			return $file['name'];
		}
		return 'no file uploaded';
	}
	public function getSize($file)
	{
		if (isset($file)) {
			return $file['size'];
		}
	}
	public function tmpName($file)
	{
		if (isset($file)) {
			return $file['tmp_name'];
		}
	}
	public function fileExt($file)
	{
		if(in_array($file['type'], $this->_extensions)){
			return $file['type'];
		}
		return 'Invalid file type';
	}
	public function picExt($file)
	{
		if(in_array($file['type'], $this->_pictures)){
			return true;
		}
		return false;
	}
	public function move_to($file, $path)
	{
		if(!file_exists($path)) mkdir($path, 0777, true);
		$file_tmp = $this->tmpName($file);
		$file = $this->fileName($file);
		$unique=microtime();
		$target = $unique.$file;
		move_uploaded_file($file_tmp, $path.$target);
		return $target;
	}
	public function delete($file)
	{
		unlink($file);
	}
}