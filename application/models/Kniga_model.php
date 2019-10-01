<?php
//методы: положить книгу в шкаф, достать и прочитать книгу из шкафа, дописать в книгу. книга текстовый файл
class kniga_model extends CI_Model
{
//книга - текстовый файл

	public function getShkafName()
	{
		return 'shkaf';
	}

	public function getPath($shkaf_name,$book_name)
	{
		return ($this->getShkafName()).'/'.$book_name.'.book';
	}
	
	public function getListBook()
	{	
		$list = file($this->getShkafName().'/.list');
		for ($i = 0; $i< count($list); $i++) {
			if (trim($list[$i]," \t\n\r\0")=='') 
			{
				unset($list[$i]);
			} 
		}
		return $list;
	}
	
	public function countListBook()
	{
		return count($this->getListBook());
	}
	
	public function getNameBook($i)
	{
		$a = $this->getListBook();
		return $a[$i];
	}

	public function ShkafDescription($description)
	{
		$fileDes = $this->getListBook();
		$fileDes[count($fileDes)] = "\r\n".$description; 
		$fp = fopen ($this->getShkafName().'/.list', "w");
		
		foreach ($fileDes as $output)
		{
			fwrite($fp,$output);
		}
		fclose($fp);
		
	}

	public function get_book_name($path,$i)
	{
		$book_return['path'] = ($this->getShkafName())."/$i";
		$book_return['shkaf_name'] = $this->getShkafName();
		$book_return['book_name'] = $path;
		return $book_return;
	}

	public function list_book()
	{
		$shkaf = $this->getListBook();
		$i = 0;
		foreach ($shkaf as $path)
		{
			$book_return['listbook'][] = $this->get_book_name($path,$i);
			$i++;
		}
		return $book_return;
	}

	public function writeBook($path,$text,$key)
	{
		$f = fopen($path,$key);
		fwrite($f,$text);
		fclose($f);
	}

	public function add_book($shkaf_name)
	{ 	
		$path = $this->getShkafName().'/'.($this->countListBook()).'.book';
		$text = $this->input->post('text');

		$this->writeBook($path,$text,'w');
		$this->ShkafDescription($this->input->post('title'));
	}

	public function append_book($shkaf_name,$book_name)
	{

		$path = ($this->getShkafName())."/$book_name";
		$text = $this->input->post('text');

		$this->writeBook($path,$text,'a');

	}

	public function open_book($shkaf_name,$book_name)
	{
		$path = $this->getPath($shkaf_name,$book_name);
		
		if (file_exists(urldecode($path)))
		{
			$path = urldecode($path);
			return file_get_contents($path);
		} else
		{
			if (file_exists($path))
			{
				return file_get_contents($path);
			}
		}
	}

}
