

$('#modal').on('change','.weight_control',function(){
	var weight = $(this).val()
	var type_reg = $(this).parents('tr:first').find('td:eq(2)').find('.reg_id').attr('id')
	var myobj = $(this)
	var type = ['','ems','regmail','emsact','manmail','regmailact','airmail']
	console.log(type_reg)
	$.post('?r=price/getprice&weight='+weight+'&type='+type[type_reg],function(data){
		myobj.parents('tr:first').find('td:eq(5)').find('input').val(data.price_rank);
		myobj.parents('tr:first').css('background-color', '#FFF');
	},'json')

})	

$('#modal').on('change','.staff_do',function(){

	$(this).parents('tr:first').find('input[name=listitembox]').prop('checked', true);
	
})

/*$('.staffupdate').on('click',function(){
	var id = $(this).attr('iditem');
	var id_reg = $(this).parents('tr:first').find('td:eq(3)').find('input').val();
	var weight = $(this).parents('tr:first').find('td:eq(4)').find('input').val();
	var price = $(this).parents('tr:first').find('td:eq(5)').find('input').val();
	var trdiable = $(this).parents('tr:first');
	console.log(id_reg)
	$.post('?r=senditem/staffupdate',{'id_item':id,'id_reg_item':id_reg,'weight_item':weight,'price_item':price},function(data){
		//console.log(data.success);
		if(data.success){
			trdiable.css('background-color', '#FCC9B9');
		}
	},'json')
})*/


$('#modal').on('click','.approve-code',function(){
	var checkbox110_val =[]; 
	 $('input.checkbox110:checked').each(function(){
	 	var id_reg = $(this).parents('tr:first').find('td:eq(3)').find('input').val();
		var weight = $(this).parents('tr:first').find('td:eq(4)').find('input').val();
		var price = $(this).parents('tr:first').find('td:eq(5)').find('input').val();
		var id = $(this).val();
	 	checkbox110_val.push({'id_reg':id_reg,'weight':weight,'price':price,'id':id})
	 }) 
	//console.log(checkbox110_val);

	if(checkbox110_val.length === 0){
	
	}else{
		var id_group =  $("#modalcontent").attr('data-id');
		var date =  $("#modalcontent").attr('date-value');
		$.post('?r=stafftools/submitcode',{'checkbox110':checkbox110_val},function(data){

			console.log(data);
			if(data['success']){
				
				 window.location.href = "?r=stafftools/spgroup&id="+id_group+"&date="+date;
			}
		})
	}
	  $('#modal').modal('toggle');
});


var keygen = function(number_key){

	var numberkey = number_key.toString();
	var arraykey = [8,6,4,2,3,5,9,7];
	var result = 0;
	var returnkey ="";
	
	var splitkey = numberkey.split("");
	
		for(i = 0;i<splitkey.length;i++){
 		result = parseInt(result)+(parseInt(splitkey[i])*parseInt(arraykey[i]));
 	
		}
		
	var mod11 = result%11;
	
	if(mod11 == 1){
		returnkey = numberkey+'0';
	}else if(mod11 == 0){
		returnkey = numberkey+'5';
	}else{
		var lastnumber =  11-mod11;
		returnkey = numberkey+lastnumber;
	}
 return returnkey;

}


$('#modal').on('click','.reg_gen',function(){
	var strkey = $('#reg_id_start').val();
	var headkey = strkey.substring(2,0)
	var endkey = strkey.substring(13,11)
	var i = 0;


	$('input[name=id_reg_item]').each(function(){
		
		var numberkey = parseInt(strkey.substring(2,10))+i;
		var lastkey = keygen(numberkey).substring(9,8)
		var subkey = keygen(numberkey).substring(8,4)+'-'
		var bookkey = keygen(numberkey).substring(4,0)+'-'
		$(this).val(headkey+bookkey+subkey+lastkey+endkey)
		i++;
		$(this).parents('tr:first').find('input[name=listitembox]').prop('checked', true);

	})

})

//reg_genbook

$('#modal').on('click','.reg_genbook',function(){
	var strkey = $('#reg_id_book').val();
	$('input[name=id_reg_item]').each(function(){
	$(this).val(strkey+'-');
	$(this).parents('tr:first').find('input[name=listitembox]').prop('checked', true);

	})

})


