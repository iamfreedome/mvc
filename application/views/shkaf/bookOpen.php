<!--
$data['text'] = $this->kniga_model->open_book($path);
			$book_on_path = $this->kniga_model->get_book_name($path);
			//получили список книг в шкафу data['listbook'][i][path|shkaf_name|book_name]); //получили книгу в шкафу data[path|shkaf_name|book_name|text]
			$data['shkaf_name'] = $book_on_path['shkaf_name'];
			$data['book_name'] = $book_on_path['book_name'];
			$data['title'] = 'Открыть книгу';

-->
<h3><?php echo urldecode($book_name); ?> </h3>
<div>
<?php echo $text; ?>
</div>
