$('.compress').click(function(){
	var listitembox_val = []; 
	 $('input.listitembox:checked').each(function(){
	 	listitembox_val.push($(this).val())
	 }) 
	console.log(listitembox_val);

	if(listitembox_val.length === 0){
	}else{
		$.post('?r=stafftools/compress',{'listitembox':listitembox_val},function(data){})
	}

});



$('.deletechecked').click(function(){
	var listitembox_val = []; 
	 $('input.listitembox:checked').each(function(){
	 	listitembox_val.push($(this).val())
	 }) 
	 if(listitembox_val.length === 0){
	}else{

		
		swal({
		  title: "คุณแน่ใจรึเปล่า?",
		  text: "คุณต้องการลบข้อมูลที่ไม่อาจย้อนคืนได้!!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Yes, delete it!",
		  closeOnConfirm: true
			},
			function(){
		  $.post('?r=stafftools/deletecheck',{'listitembox':listitembox_val},function(data){})
			});
			
	}

})
