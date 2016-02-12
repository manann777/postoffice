$('.listTable').on('click','.checkbox111',function(){
	//alert('HELLO');
	var value = $(this).val();
	$('.checkbox111').tooltip('destroy')
	$.post('?r=stafftools/setitem',{'value':value},function(data){

		if(data.success){
						console.log(data.title)
						$('.checkbox111[value='+value+']').attr('title',data.title)
		$('.checkbox111[value='+value+']').tooltip({placement:'right',trigger: 'manual'})
		$('.checkbox111[value='+value+']').tooltip('show')
		}else{
						$('.checkbox111[value='+value+']').attr('title',data.title)
		$('.checkbox111[value='+value+']').tooltip({placement:'right',trigger: 'manual'})
		$('.checkbox111[value='+value+']').tooltip('show')
		}

	},'json')

	
})

$('.checkbox111').on('shown.bs.tooltip', function() {
    setTimeout(function() {
        $('.checkbox111').tooltip('destroy');
    }, 500);
});