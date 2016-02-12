 <?php
$array_icon = ['fa-exclamation-triangle','fa-truck','fa-tag','fa-truck','fa-tag','fa-tag','fa-plane','fa fa-cube'];
$array_color =['label-warning','label-danger','label-primary','label-danger','label-primary','label-primary','label-info','label-success'];
$label = ['label-normal','label-default','label-primary','label-success','label-info','label-warning','label-danger','label-info','label-success'];

?>

 <div role="tabpanel" class="tab-pane" id="airmail">
    			    <div class="table-responsive">
		   	<table class='table table-hover table-list-mini'>
			<thead>
			<tr class="success">
				<th class='col-md-1'>#</th>
				<th>รายการ</th>
				<th>กลุ่มก่อน - กลุ่มตอนนี้</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($model as $key => $type): ?>
				<tr>
					<td><?=$type->id_item?></td> 
					<td><?=$type->name_sender?><?=$type->name_receiver?></td>
					<td><span class="<?='label '.$label[intval($type->group_item)%7]?>"><?=$type->groupItem->id_group?></span> <i class="fa fa-arrow-right"></i>
		 			<span class="<?='label '.$label[intval($type->group_item_move)%7]?>"><?=$type->groupItemMove->id_group?></span></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			</div>
    </div>