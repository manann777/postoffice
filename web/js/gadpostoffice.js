$('.delete').click(function(event){
    event.preventDefault();
	var id = $(this).attr('id');
	var url = $(this).attr('href');
	console.log(url);
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
  //swal("Deleted!", "Your imaginary file has been deleted.", "success");
  $.get(url);
});


  })

 $( document ).ready(function() { 

            $('.getmodal').click(function(){

              $('#modal').modal('show').find('#modalcontent').load($(this).attr('value'))
            })


            $('.rowdata').click(function(){
            
              var data = $(this).attr('data-href');
              var valuedata = $(this).attr('data-val');
              var valuetype = $(this).attr('data-type');
              var date = $(this).attr('date');

              window.location.href = "?r="+data+"&id="+valuedata+"&type="+valuetype+"&date="+date;
            })
                   


             $('[data-toggle="tooltip"]').tooltip()

            



             //$('[data-toggle="popover"]').popover('show');
})

