<?php
	use yii\helpers\Html;
	use yii\bootstrap\Modal;
	use yii\helpers\Url;
	use kartik\date\DatePicker;
	//use kartik\export\ExportMenu;
	$label = array('btn-xs btn btn-normal','btn-xs btn btn-default','btn-xs btn btn-primary','btn-xs btn btn-success','btn-xs btn btn-info','btn-xs btn btn-warning','btn-xs btn btn-danger');
	$this->registerJsFile('postoffice/web/js/tablelist.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="col-md-12">
	<div class="col-md-3">
		<div class="btn-group btn-group-lg" role="group">
		<?=$sort->link('id_group',['class'=>'btn btn-info']). ' ' . $sort->link('type_doc',['class'=>'btn btn-primary']). ' ' . $sort->link('number_book',['class'=>'btn btn-warning']);?></div>
	</div>

	<div class="col-md-4">
		
		<?php
		echo DatePicker::widget([
		    'name' => 'check_date',
		    'removeButton' => false,
		   	'language' => 'th',
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true

		    ],
		    'pluginEvents' => [
		    "hide" => "function(e) {  //alert(e.format('yyyy-mm-dd'))
		    	var date = e.format('yyyy-mm-dd');
				window.location.replace('?r=stafftools/groupsave&date='+date)
		     }",
		    ]
		]);
?>

	</div>
</div>
<div class="col-md-12 table-responsive">
	<table class="table  listTable " colomn_sum='4'>
		<thead>
			<tr class="info">
				<th class="col-md-2">#</th>
				<th class="col-md-1">สมาชิก</th>
				<th>ประเภท</th>
				<th>เลขเล่ม</th>
				<!-- <th>เป็นเงิน(ระบบ)</th> -->
				<th>เป็นเงิน(ไปรษณีย์)</th>
				<th>หมายเหตุ</th>
				<th>tools</th>
				<th class="col-md-1">file</th>
				<th>delete</th>
			</tr>
		</thead>
		<tfoot><tr>
			<th colspan="4" style="text-align:right">ผลรวม:</th>
			<th class="totle"></th>
			<th colspan="4"></th>
		</tr></tfoot>
		<tbody>
			<?php foreach ($model as $key => $type): ?>
				<tr>
					
					<td>
						<div class="btn-group btn-group-xs">
						<a class="<?=$label[intval($type->id_group)%7]?>" href="<?= Url::to(['stafftools/listitem','groupmodel'=>$type->id_group])?>">G:<?=$type->id_group?></a>
						<a href="<?= Url::to(['stafftools/manage','groupmodel'=>$type->id_group])?>" class="btn btn-info"><i class="fa fa-cogs"></i></a>
						
						<?php if($type->status_group == 'accepted'): ?>
						<a class="btn btn-danger" href="<?= Url::to(['stafftools/unsetgroup','groupmodel'=>$type->id_group])?>" title="ยกเลิกการบันทึกรับ"><i class="fa fa-undo"></i></a>
						<?php endif; ?>
						</div>
					<!-- <a class="getmodal label" href="#" value="<?=Url::to(['senditem/detailer','id' => $type['id_group']])?>" ><?=$type['id_group']?></a> -->
					</td>
					<td>

					
						<?php
					if(array_key_exists($type->id_group, $counter)){echo '<span class="badge badge-default">'.$counter[$type->id_group]['counter'].'</span>';}else{ echo '<span class="badge badge-danger">0</span>';};
						?>
						
					</td>
					<td><?=$type['type_doc']?></td>
					<td><?=$type['number_book']?></td>
					<!-- <td><?=$type['price_system']?></td> -->
					<td><?=$type['price_postoffice']?></td>
					<td><small><?=$type['comment']?> <?='<i class="fa fa-calendar text-primary"></i> '.$type['date_update']?></small></td>
					
					<td>
						<div class="btn-group btn-group-xs">
						<a class="btn-xs btn btn-primary getmodal"  href="#" value="<?=Url::to(['stafftools/upload','id' => $type['id_group']])?>"><i class="fa fa-upload"></i> upload_file</a>
						</div>
					</td>
					<td><?php 

					echo ($type['filepath']?'<a href="'.$type['filepath'].'" target=_blank class="btn btn-info btn-xs"><i class="fa fa-paperclip"></i></a>':'');




					?></td>
					<td><a class="btn btn-danger delete btn-xs" href="<?= Url::to(['stafftools/deletegroup','id'=>$type->id_group]) ?>" id=<?=$type->id_group;?> ><i class="fa fa-trash-o fa-2"></i></a></td>
				</tr>
			<?php endforeach; ?>

		</tbody>

	</table>

</div>

<?php

/*$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    		'id'  ,
            'id_group'  ,
            'type_doc'  ,
            'number_book'  ,
            'price_postoffice' ,
            'date_update'  ,
            'imageFile'  ,
            'filepath' ,
            'comment' ,
    
];*/






/*echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
      'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_PDF => false,
         ExportMenu::FORMAT_HTML => false,
         ExportMenu::FORMAT_CSV => false,
    ],
    'fontAwesome' => true,
     'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-default'
    ],
    'asDropdown' => false,
    
  
]);*/


Modal::begin([
		 
		    'id'=>'modal',
		    'size'=>'modal-lg',
		    'closeButton'=>['class'=>'btn btn-danger','label'=>'x close']
		]);

		echo '<div id="modalcontent"></div>';

Modal::end();




?>
