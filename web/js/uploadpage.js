
	

var fpost = function(){

		var post_all_price = 0;
		$('.post_price').each(function(index, el) {
			post_all_price = parseFloat(post_all_price) + parseFloat($(this).val())
		});
		$('.post_all_price').val(post_all_price.toFixed(2));
		//console.log($('.tableprice').hasClass('all_price'))
		sumall_price()

	}



var fmanpost = function(){
					var post_allman_price = 0;
					$('.post_man_price').each(function(index, el) {
						post_allman_price = parseFloat(post_allman_price) + parseFloat($(this).val())
					});
					$('.post_allman_price').val(post_allman_price.toFixed(2));
					

					var all_price = parseFloat($('.post_all_price').val())+parseFloat(post_allman_price.toFixed(2))
					sumall_price()
					/*if($('#modal').hasClass('all_price')){
						
					var all_price = parseFloat($('.post_all_price').val())+parseFloat(post_allman_price.toFixed(2))
						$('.all_price').val(all_price);
					}*/

			}
var sumall_price = function(){
	var postallprice = parseFloat($('.post_all_price').val())
	var postallman = parseFloat($('.post_allman_price').val())
	$('.all_price').val(postallprice+postallman);

}



	$('#modal').on('change','.post_price',fpost)


	$('#modal').on('change','.post_man_price',fmanpost)

	$('#modal').on('click','.eshare',function(){
		console.log('OK')
		var datainput = $(this).attr('datainput');
		var price = $(datainput).val();
		var data = $(this).attr('data');
		var size = $(data).size();
		$(data).val(parseFloat(price/size).toFixed(2))

	})
		
	
 $('#modal').on('click','.copyprice',function(){
 	$('.preprice').each(function(index, el) {
 		//console.log($(this).attr('data-price'))
 		var price = $(this).attr('data-price')
 		$(this).parents('tr:first').find('.post_price').val(price);
 		fpost();
 	});
 })

 $('#modal').on('click','.x3',function(){
 	$('.qtyman').each(function(index, el) {
 		//console.log(index);
 		var qty = $(this).attr('data-qty');
 		var price = qty*3
 		$(this).parents('tr:first').find('.post_man_price').val(price);
 		fmanpost()
 	});

 })