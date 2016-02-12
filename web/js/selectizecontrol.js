

var $selectunit =  $('.setlist').selectize({
        maxItems: 1,
        valueField: 'id_unit',
        searchField: 'name_unit',
        labelField: 'name_unit',
        options: [],
        selectOnTab:true,
        
        /*create: function(value,callback){
            var id_unit;
            var name_unit;
             $.post('?r=unit/addunit&value='+value,function(datajson){
                callback({'id_unit':datajson['id_unit'],'name_unit':datajson['name_unit']});
    
            },'json')
            
        },*/
    
        render: {
        option: function(data, escape) {
        return '<div class="option">' +'<span class="id_unit">' + escape(data.name_unit) + '</span></div>';
        }
        },
});




var controlunit1 = $selectunit[0].selectize;

function getUnitlisjson(){

    $.post('?r=unit/unitlistjson',function(datajson){
        controlunit1.clearOptions();
        controlunit1.addOption(datajson);
        controlunit1.removeOption(0);
    },'json')
}



 var eventHandler = function(name) {
    return function() {
       // console.log(arguments);

/*
if(arguments[0] == '6'){
    $('.id_reg_code').css('display','block');
    $('.code').val('00000');
     $('.qtyblock').css('display','none');
    $('.qty').val(1);
}else if(arguments[0] != '4'){
    $('.qtyblock').css('display','none');
    $('.qty').val(1);
     $('.destiny_code').css('display','block');
     $('.id_reg_code').css('display','none');
     $('.code').val('');
}else{$('.qtyblock').css('display','block');
    $('.code').val('00000');
    $('.destiny_code').css('display','none');
    $('.id_reg_code').css('display','none');
    }
*/

switch(arguments[0]){
    case '6':
    $('.id_reg_code').css('display','block');
    $('.id_reg_code_set').val('ศธ 0514');
    $('.code').val('00000');
    $('.qtyblock').css('display','none');
    $('.qty').val(1);
    console.log(arguments[0]);
    break;
    case '4':
    $('.qtyblock').css('display','block');
    $('.qty').val(1);
    $('.destiny_code').css('display','none');
    $('.id_reg_code').css('display','none');
    $('.code').val('00000');
    console.log(arguments[0]);
    break;
     case '8':
    $('.id_reg_code').css('display','block');
    $('.id_reg_code_set').val('ศธ 0514');
    $('.code').val('00000');
    $('.qtyblock').css('display','none');
    $('.qty').val(1);
    console.log(arguments[0]);
    break;
    default:
    
    $('.qty').val(1);
    console.log("QTY = "+$('.qty').val());
    $('.qtyblock').css('display','none');
    //$('.code').val();

    $('.destiny_code').css('display','block');
    $('.id_reg_code').css('display','none');
    console.log(arguments[0])
    

}

      
    };
};


var $selectreglist =  $('.setreglist').selectize({
        maxItems: 1,
        valueField: 'id_reg',
        searchField: 'type_reg',
        labelField: 'type_reg',
        options: [],
        selectOnTab:true,
        create: false,
        onChange : eventHandler('onChange'),
        render: {
        option: function(data, escape) {
        return '<div class="option">' +'<span class="id_reg">' + escape(data.type_reg) + '</span><small> '+data.comment+'</small></div>';
        }
        },
});

var controlreg = $selectreglist[0].selectize;

function getReglistjson(){
    $.post('?r=regtype/reglistjson',function(datajson){
        controlreg.clearOptions();
        controlreg.addOption(datajson);
        //console.log(datajson)
       // controlreg.removeOption(1)
       
    },'json')
}


//--------------------- on READY ------------------
 $( document ).ready(function() { 

            getUnitlisjson()
            getReglistjson()
                    
})


