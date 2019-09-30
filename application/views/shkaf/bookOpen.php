
<?php 
$this->load->view('templates/header_shkaf',array ('title' => 'Открыть книгу!'));
?>

<h3><?php echo urldecode($book_name); ?> </h3>
<div>
<?php echo ($text ? $text : "Извините, не могу прочитать текст книги"); ?>
</div>

<?php 
$this->load->view('templates/footer_shkaf');
?>