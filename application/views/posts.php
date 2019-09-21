 
<div class="col-lg-5 col-lg-offset-2">

	
	<?php if(isset($_SESSION['user_logged'])) { ?>
		<a href="<?php echo base_url(); ?>index.php/auth/logout">Выйти </a>
		<div class="alert alert-success"> <?php echo 'Пользтователь: '.$_SESSION['username']; ?>
		<a href="<?php echo base_url()."index.php/board/all_posts" ?>">Все комментарии. </a> ||
		<a href="<?php echo base_url()."index.php/board/my_board" ?>"> Личная стена </a> ||
		<a href="<?php echo base_url()."index.php/board/comment/0" ?>"> Добавить комментарий к доске</a>
		
		</div>
		
	<?php } else {?> 
	<p> <a href="<?php echo base_url(); ?>index.php/auth/login">Авторизуйтесь </a> или <a href="<?php echo base_url(); ?>index.php/auth/register">зарегистрируйтесь </a>, чтобы оставлять комментарии.
	</p>
	<?php }  ?>
	
	

	<br /> 
	
</div>
<!--POSTS HERE-->
 
 <?php $base = base_url().'index.php/board/answer/'; $base_del = base_url().'index.php/board/del_post/'; foreach ($resi as $row): if ($row->deleted != 1) {  //was { ?>

<div class="col-lg-5 col-lg-offset-2" id="div<?php echo $row->post_id; ?>">
 Заголовок: <?php echo $row->title; ?> -> Тема: <?php echo $row->theme; ?> 
 <p>
  
 <?php echo $row->text; ?> <!-- ответить ссылка-->
 <br>
 <a href="<?php echo $base.$row->post_id ?>">
  <?php echo (isset($_SESSION['user_id']) ? ' Ответить ' : '') ?>
 </a> 
 
  <a href="<?php echo $base_del.$row->post_id ?>"><!-- удалить ссылка-->
 <?php $flag = (isset($_SESSION['user_id'])&&(($_SESSION['user_id'] == $row->user_id) or ($_SESSION['user_id'] == $row->board_id)));	echo ($flag ? ' Удалить ' : '') ?>
 </a>

 
 
 <?php //print_r ($row);?>
 <?php //print ($row->username);?>
 </p>
 
</div>

 
 <?php } endforeach; //was }?>
 <!--//print_r ($resi);
 //echo $title." " //print_r($resi)
 //?> -->
 <?php $_SESSION['board_id'] == -1 ? print ('<a class="-1" id="sense"></a>') : print('<a class="'.$_SESSION['board_id'].'" id="self"></a>')?>
 <div class="result" id="cartmessage" style="display: none">Дополнительные комментарии: <br></div>
 <a href="#" class="row-md-10" id="btn" > ЕЩЕ КОММЕНТАРИИ </a>
 <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-3.4.1.min.js"></script>
 
 <script> 
    $( function () {
    $( "a#btn" ).on("click", function ( event ) { //was onclick( function (event) { for button
        event.preventDefault();
        //var email = $( "#email" ).val();
        let border_id = 1; //!!! нужно понять на какой странице находимся
		let offset = 5;
		let limit = 5;
		
		var url = "<?php echo base_url(); ?>index.php/Board/post_other_html";
        var data = { 'border_id': border_id, 'offset': offset, 'limit': limit };
		console.log( 'url:', url );

        $.post( url, data ).done( function ( response ) {
				//ar = Array.from(response); ///JSON.parse
				//let messages = $( '#cartmessage' );
				//а мы на вход возьмем готовый html
				//cartmessage.textContent = '';
			//for ( let i in response ) {
				let msg = document.createElement('div'); //можно из JS лепить но я буду генерить готовый нтмл в пхп
				msg.className = "col-lg-5 col-lg-offset-2";
				msg.innerHTML = response;
				msg.show;
				cartmessage.append(msg);
				//.addClass( 'one-message' )
					//.textContent = response[i].text;
					//.innerHTML
				//cartmessage.append( msg );
				
			//	}
			
			$( '#cartmessage' ).show();
			console.log( response);
			//console.log( ar );
			
			//$('#message').show();
            //$( "#message" ).html( response );
            //$( '#cartmessage' ).show();
            //$( '.result' ).html( response );
        } ).fail( function () {
			
            alert( "Invalide!" );
        } );
    } );
} );
</script>
 
 
 