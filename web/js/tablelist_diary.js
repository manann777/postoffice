$(document).ready(function() {
$('.listTable').DataTable({
              "order": [],
              "pageLength": 25,
              "dom": "<'row'<'col-sm-4'p><'col-sm-6'f><'col-sm-2'l>"+"<'row'<'col-sm-12'tr>>"+"<'row'<'col-sm-8'p><'col-sm-4'i>>",
            }); 

             var table = $('.listTable').DataTable(); 
            // var colomn_sum = $('.listTable').attr('colomn_sum');
            for(i=1;i<14;i++){
              var column = table.column(i);
              if(column.data().length !== 0){
            $( column.footer() ).html(

                column.data().reduce( function (a,b) {
                return parseFloat(a)+parseFloat(b);
            } ) ) }
              } 

          })

$('.download_excel').on('click',function(){
 var table = $('.listTable').DataTable();
 table.page.len(-1).draw();
  var column = table.column(15);
  column.visible( ! column.visible() );
  
 $(".listTable").table2excel({
    //exclude: ".noExl",
    name: "report"
  })
 setTimeout(function(){
  column.visible( ! column.visible() );
 table.page.len(25).draw();
},5000)
 

})