$('.download_excel').on('click',function(){
 
 $(".listTable").table2excel({
    exclude: ".noExl",
    name: "report"
  }) }); 

$('.checkall').on('click',function(){

	$('input[name=listitembox]').prop('checked', true);
})

$(".checksubmit").on('click',function(){
	var check_array =[];
	var id;
	var date = $(this).attr('date');
	var mode =$(this).attr('mode');
	 $('input.listitembox:checked').each(function(){
	 	
	 	id = $(this).val();
	 	

	 	//console.log(qty_ems+"-->"+qty_reg+"-->"+comment);
	 	check_array.push({'id_item':id})
	 })

	 if(check_array.length != 0){

	 	$.post('?r=diary/updatecheck',{'check_array':check_array,'date':date,'mode':mode},function(data){

	 		console.log(data['success']);
	 		if(data['success']){
	 		window.location.href = "?r=diary/aircheck&mode="+mode;
	 		}

	 	},'json')
	 }

	})

$('.download_jpg').on('click',function(){
	//console.log('load jpg')
	
		 html2canvas($(".listTable"), {
            onrendered: function(canvas) {
            	$('#imgs').html(canvas);
            	//$('#imgs').html(Canvas2Image.convertToJPEG(canvas))
        //Canvas2Image.saveAsJPEG(canvas); 
            }
        })
})

