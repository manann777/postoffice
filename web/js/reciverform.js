$(".reciversubmit").on('click',function(){
	var reciver_array =[];
	var date = $(this).attr('date');
	var qty_ems,qty_reg,comment,id,date;
	 $('input.listitembox:checked').each(function(){
	 	//qty_ems = $(this).parents('tr:first').find('input[name=qty_ems]').val();
	 	qty_reg	= $(this).parents('tr:first').find('input[name=qty_reg]').val();
	 	qty_manmail	= $(this).parents('tr:first').find('input[name=qty_manmail]').val();
	 	comment = $(this).parents('tr:first').find('input[name=comment]').val();
	 	id = $(this).val();
	 	date = $(this).attr('date');

	 	//console.log(qty_ems+"-->"+qty_reg+"-->"+comment);
	 	reciver_array.push({'qty_reg':qty_reg,'qty_manmail':qty_manmail,'comment':comment,'id':id,'date':date})
	 })

	 if(reciver_array.length != 0){

	 	$.post('?r=diary/updatereciver',{'reciver_array':reciver_array,'date':date},function(data){

	 		//console.log(data);
	 		if(data['success']){
	 		window.location.href = "?r=diary/report";
	 		}

	 	},'json')
	 }

	})

$(".recivertable").on("change",".recivercon",function(){
	
	$(this).parents('tr:first').find('input[name=listitembox]').prop('checked', true);
})
	
