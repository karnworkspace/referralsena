<?php
/* @var $this AgCustomerController */
/* @var $data AgCustomer */
?>
<div class="view">
	<table class="table table-bordered">
	  <thead class="table-dark">
	    <tr>
				<th scope="col">วันที่</th>
	      <th scope="col">เลขนายหน้า</th>
	      <th scope="col">ชื่อลูกค้า</th>
	      <th scope="col">คำร้อง</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
				<th scope="row"><?php echo CHtml::encode($data->create_date); ?></th>
				<td><?php echo CHtml::encode($data->agent_id); ?></td>
				<td><?php echo CHtml::encode($data->cus_id); ?></td>
				<td><?php echo CHtml::encode($data->comment); ?></td>

	    </tr>
	  </tbody>
	</table>


<?php /*

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_id')); ?>:</b>
	<?php echo CHtml::encode($data->agent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fname')); ?>:</b>
	<?php echo CHtml::encode($data->fname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lname')); ?>:</b>
	<?php echo CHtml::encode($data->lname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project')); ?>:</b>
	<?php echo CHtml::encode($data->project); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget')); ?>:</b>
	<?php echo CHtml::encode($data->budget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sena_approve')); ?>:</b>
	<?php echo CHtml::encode($data->sena_approve); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('idcard')); ?>:</b>
	<?php echo CHtml::encode($data->idcard); ?>
	<br />

	*/ ?>

</div>
