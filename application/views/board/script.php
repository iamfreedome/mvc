	
	<div class="result" id="cartmessage" style="display: none">Дополнительные комментарии: <br></div><br>
	
	<a href="#" class="row-md-10" id="btn" >ПОСМОТРЕТЬ ЕЩЕ КОММЕНТАРИИ </a>
	
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-3.4.1.min.js"></script>
 
	<script> 
    $( function () {
    $( "a#btn" ).on("click", function ( event ) { //was onclick( function (event) { for button
        event.preventDefault();
        
        let border_id = 1; //!!! нужно понять на какой странице находимся
		let offset = 5;
		let limit = 5;
		
		var url = "<?php echo base_url(); ?>index.php/Board/post_other_html";
        var data = { 'border_id': border_id, 'offset': offset, 'limit': limit };
		console.log( 'url:', url );

        $.post( url, data ).done( function ( response ) {
				
				//а мы на вход возьмем готовый html
				
				let msg = document.createElement('div'); //можно из JS лепить но я буду генерить готовый нтмл в пхп
				msg.className = "col-lg-5 col-lg-offset-2";
				msg.innerHTML = response;
				
				cartmessage.append(msg);
				msg.show;
				
			$( '#cartmessage' ).show();
			console.log( response);
			
        } ).fail( function (response) {
			console.log( response);
            alert( "Invalide!" );
        } );
    } );
} );
</script>

 
 