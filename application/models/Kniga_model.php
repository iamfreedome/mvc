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
		return ($shkaf_name == $this->getShkafName() ? $shkaf_name : $this->getShkafName()).'/'.$book_name;
	}

	public function get_book_name($path)
	{
		$pi = pathinfo($path);
		$book_return['path'] = $path;
		$book_return['shkaf_name'] = $pi['dirname'];;
		$book_return['book_name'] = urldecode($pi['basename']);
		return $book_return;
	}

	public function list_book()
	{
		$shkaf = $this->getShkafName();
		foreach (glob($shkaf.'/*') as $path)
		{
			$book_return['listbook'][] = $this->get_book_name($path);
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
		$this->load->helper('url');
		$book_name = url_title($this->input->post('title'),'dash',TRUE);

		$book_name = urlencode($book_name);

		$path = ($shkaf_name == $this->getShkafName() ? $shkaf_name : $this->getShkafName()).'/'.$book_name;
		$text = $this->input->post('text');

		$this->writeBook($path,$text,'w');
	}

	public function append_book($shkaf_name,$book_name)
	{

		$path = ($shkaf_name == $this->getShkafName() ? $shkaf_name : $this->getShkafName()).'/'.$book_name;
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
