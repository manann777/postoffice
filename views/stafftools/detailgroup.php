<?php 
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->registerJsFile('postoffice/web/js/price.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('postoffice/web/js/getitem.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube'];
$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success'];
$label = ['label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success'];


?>

<div class="row">

	<div class="col-md-6">
		<a  class="btn btn-success " href="<?=Url::to(['stafftools/worktoday','date'=>$date])?>"> <i class="fa fa-arrow-left"></i> กลับหน้างานวันที่ <?=$date?></a>
	</div>

</div>   


<!--tab-->
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-pills " role="tablist">
  	 <li role="presentation" class="active"><a href="#group" aria-controls="group" role="tab" data-toggle="tab">all in group<span class="badge badge-primary"><?=count($model)?></span></a></li>
    <li role="presentation" ><a href="#ems" aria-controls="ems" role="tab" data-toggle="tab">EMS <span class="badge badge-primary"><?=count($ems_model)?></span></a></li>
    <li role="presentation"><a href="#regmail" aria-controls="regmail" role="tab" data-toggle="tab">ลงทะเบียน <span class="badge badge-primary"><?=count($reg_model)?></span></a></li>
    <li role="presentation"><a href="#lastdoc" aria-controls="lastdoc" role="tab" data-toggle="tab">กลุ่มย่อยEMSและจดหมายธรรมดา <span class="badge badge-primary"><?=count($last_model)?></span></a></li>
    <li role="presentation"><a href="#lastreg" aria-controls="lastreg" role="tab" data-toggle="tab">กลุ่มย่อยลงทะเบียน <span class="badge badge-primary"><?=count($lastreg_model)?></span></a></li>
    <li role="presentation"><a href="#airmail" aria-controls="airmail" role="tab" data-toggle="tab">เอกสารการบินไทย <span class="badge badge-primary"><?=count($air_model)?></span></a></li>
     <li role="presentation"><a href="#item" aria-controls="item" role="tab" data-toggle="tab">พัสดุ <span class="badge badge-primary"><?=count($item_model)?></span></a></li>
   
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  	  <div role="tabpanel" class="tab-pane active" id="group">
		    <div class="table-responsive">
		   	<table class='table table-hover table-list-mini listTable'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th>ราคา</th>
				<th>รับพัสดุ</th>
				<th>หมายเหตุ</th>
				
			</tr>
			</thead>
			<tbody>
				<? $i = 1;?>
			<?php foreach ($model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$i?></a></td> 
					<td><?=$type->id_item?>-<?=$type->name_sender?> <i class="fa fa-arrow-right"></i> <?=$type->name_receiver?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					<td><?=$type->price_item_post?></td>
					<td><input type="checkbox" class="checkbox111" name="listitembox" value="<?=$type->id_item?>" <?=($type->get_item?'checked':'')?> ></td>
					<td><?=$type->item_comment?></td>
				</tr>
				<? $i++ ;?>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
			<?php if(!count($ems_model) && !count($reg_model)):?>

				<a class="btn btn-info" type="submit" href="<?=Url::to(['stafftools/approve_none_item','id'=>$group])?>"><i class="fa fa-check"></i> บันทึกรับ</a>
				
			<?php endif; ?>
			<a class="btn btn-danger"  href="<?=Url::to(['senditem/addingroup','group'=>$group,'insert'=>true,'date'=>$date])?>" ><i class="fa fa-file-text-o"></i> แทรกพัสดุ</a>

    </div>
    <div role="tabpanel" class="tab-pane " id="ems">
    	  	 <?php if(count($ems_model)):?>
    	  	  	
    	  	  <a value="<?=Url::to(['stafftools/setcode','id' => $group,'type'=>$groupsave->type_doc])?>" class="btn btn-info getmodal">จัดการรหัสสำคัญ</a>
				
				
				<?php endif;?>
    	  	  	
		   <div class="table-responsive">
		   	<table class='table table-hover table-list-mini '>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				
				<th>หมายเหตุ</th>
				<th>เครื่องมือ</th>
				
			</tr>
			</thead>
			<tbody>
				<? $i = 1;?>
			<?php foreach ($ems_model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$i?></a></td> 
					<td><?=$type->id_item?>-<?=$type->name_sender?> <i class="fa fa-arrow-right"></i> <?=$type->name_receiver?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					
					<td><?=$type->item_comment?></td>
					<td>
						<div class="btn-group">
			
				<a class="btn btn-info" href="<?= Url::to(['stafftools/updateitem','id'=>$type->id_item]) ?>"><i class="fa fa-wrench fa-2"></i></a>
				<a class="btn btn-danger delete" href="<?= Url::to(['stafftools/deleteitem','id'=>$type->id_item,'stage'=>'detailgroup','date'=>$date]) ?>" id=<?=$type->id_item;?> ><i class="fa fa-trash-o fa-2"></i></a>
				
				</div>

					</td>
				</tr>
				<?$i++?>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
			<?php if(count($ems_model)):?>
		<div class="col-md-12 text-right">
			<a class="btn btn-danger" href="<?=Url::to(['stafftools/movegroup','id' => $group,'type'=>$groupsave->type_doc,'date'=>$date])?>"><i class="fa fa-share"></i> ย้ายเข้ากลุ่มย่อย</a>
		</div>
		
		<div class="col-md-12">	
		<?=$this->render('_formprint',['model'=>$groupsave,'group'=>$group])?>
		</div>
		<?php endif; ?>

  

    </div>
			

    <div role="tabpanel" class="tab-pane" id="regmail">
    	
			    	  	  <?php if(count($reg_model)):?>
    	  	  	<a value="<?=Url::to(['stafftools/setcode','id' => $group,'type'=>$groupsave->type_doc])?>" class="btn btn-info getmodal">จัดการรหัสสำคัญ</a>
				<?php endif;?>
		   <div class="table-responsive">
		   	<table class='table table-hover table-list-mini'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th>หมายเหตุ</th>
				<th>เครื่องมือ</th>
				
			</tr>
			</thead>
			<tbody>
				<? $i = 1;?>
			<?php foreach ($reg_model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$i?></a></td> 
					<td><?=$type->id_item?>-<?=$type->name_sender?> <i class="fa fa-arrow-right"></i> <?=$type->name_receiver?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					<td><?=$type->item_comment?></td>
					<td>
						<div class="btn-group">
			
				<a class="btn btn-info" href="<?= Url::to(['stafftools/updateitem','id'=>$type->id_item]) ?>"><i class="fa fa-wrench fa-2"></i></a>
				<a class="btn btn-danger delete" href="<?= Url::to(['stafftools/deleteitem','id'=>$type->id_item,'stage'=>'detailgroup','date'=>$date]) ?>" id=<?=$type->id_item;?> ><i class="fa fa-trash-o fa-2"></i></a>
				
				</div>

					</td>
				</tr>
				<? $i++?>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
			<?php if(count($reg_model)):?>

			<div class="col-md-12 text-right">
			<a class="btn btn-danger" href="<?=Url::to(['stafftools/movegroup','id' => $group,'type'=>$groupsave->type_doc,'date'=>$date])?>"><i class="fa fa-share"></i> ย้ายเข้ากลุ่มย่อย</a>
		</div>
		
		<div class="col-md-12">	
		<?=$this->render('_formprint',['model'=>$groupsave,'group'=>$group])?>
		</div>
		

		<?php endif; ?>

    </div>
    <div role="tabpanel" class="tab-pane" id="lastdoc">
    	 <div class="table-responsive">
		   	<table class='table table-hover table-list-mini'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th>หมายเหตุ</th>
				
			</tr>
			</thead>
			<tbody>
			<?php foreach ($last_model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a></td> 
					<td><?=$type->name_sender?> <i class="fa fa-arrow-right"></i> <?=$type->name_receiver?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					<td><?=$type->item_comment?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
    </div>

		 <div role="tabpanel" class="tab-pane" id="lastreg">
    	
			<div class="table-responsive">
		   	<table class='table table-hover table-list-mini'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th>หมายเหตุ</th>
				
			</tr>
			</thead>
			<tbody>
			<?php foreach ($lastreg_model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a></td> 
					<td><?=$type->name_sender?> <i class="fa fa-arrow-right"></i> <?=$type->name_receiver?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					<td><?=$type->item_comment?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>

    </div>


    <div role="tabpanel" class="tab-pane" id="airmail">
    			  <div class="table-responsive">
		   	<table class='table table-hover table-list-mini'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th>หมายเหตุ</th>
				
			</tr>
			</thead>
			<tbody>
			<?php foreach ($air_model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a></td> 
					<td><?=$type->name_sender?> <i class="fa fa-arrow-right"></i> <?=$type->name_receiver?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					<td><?=$type->item_comment?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
    </div>



    <div role="tabpanel" class="tab-pane" id="item">
    			    <div class="table-responsive">
		   	<table class='table table-hover table-list-mini'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>ผู้ส่ง - ผู้รับ</th>
				<th>รหัสสำคัญ</th>
				<th>ประเภทพัสดุ</th>
				<th>จำนวน</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th>หมายเหตุ</th>
				
			</tr>
			</thead>
			<tbody>
			<?php foreach ($item_model as $key => $type): ?>
				<tr>
					<td><a class="getmodal" href="#" value="<?=Url::to(['senditem/detailer','id' => $type->id_item])?>" ><?=$type->id_item?></a></td> 
					<td><?=$type->name_sender?> <i class="fa fa-arrow-right"></i> <?=$type->name_receiver?></td>
					<td><?=$type->id_reg_item?></td>
					<td><SPAN class="label <?=$array_color[$type->id_reg_type]?>"><i class="<?='fa '.$array_icon[$type->id_reg_type]?>"></i> <?=$type->idRegType->type_reg?></SPAN></td>
					<td><?=$type->qty_item?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					<td><?=$type->item_comment?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
    </div>
  
  </div>

</div>



<?php

Modal::begin([

		    'id'=>'modal',
		    'size'=>'modal-lg',
		   'footer'=>'<a class="btn btn-info approve-code">ยืนยัน</a>',

		    
		]);

		echo '<div id="modalcontent"  data-id="'.$group.'" date-value="'.$date.'"></div>';

Modal::end();
 

?>