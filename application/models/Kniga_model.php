<?php
//методы: положить книгу в шкаф, достать и прочитать книгу из шкафа, дописать в книгу. книга текстовый файл
class kniga_model extends CI_Model {
	//книга - текстовый файл
	//название - первая строка, авторы - вторая строка, текст (остальное) остальное
	
	public function get_book_name($path) {
		$pi = pathinfo($path);
		$book_return['path'] = $path;
		$book_return['shkaf_name'] = $pi['dirname'];;
		$book_return['book_name'] = urldecode($pi['basename']);
		return $book_return;
	}
	
	public function list_book() { //можно получать имя шкафа $patt
		//получаем список книг в шкафу
			
			foreach (glob('shkaf/*') as $path) {
				$book_return['listbook'][] = $this->get_book_name($path);
		
		// или можно ввести синтаксис что автор после последней точки будет без аббревиатур
		// но автора нет в ТЗ так что пофиг
		}		
		return $book_return;
		
	}
	public function add_book($shkaf_name) {//,$book_name,$text
		//положить книгу в шкаф - путь до книги или текст в текстовом поле ->  два варианта
		$this->load->helper('url');
		$book_name = url_title($this->input->post('title'),'dash',TRUE);
				
		$book_name = urlencode($book_name);
		
		$path = $shkaf_name.'/'.$book_name;
		$text = $this->input->post('text');
		$f = fopen($path,'w');
		fwrite($f,$text);
		fclose($f);
	}	
	
	public function append_book($shkaf_name,$book_name) {
		$path = $shkaf_name.'/'.$book_name;
		$text = $this->input->post('text');
				
		$f = fopen($path,'a');
		fwrite($f,$text);
		fclose($f);
	
		//дописать в книгу - можно ли редактировать книгу? видимо нет. 
	}
	
	public function open_book($path) {
		//достать и прочитаь книгу из шкафа -> по названию книги видимо открывается файл и заполняется поле текстовое 
			if (file_exists(urldecode($path))) {
				$path = urldecode($path);
		return file_get_contents($path); } else
		{ return file_get_contents($path);
		}
	}
	
}
?>