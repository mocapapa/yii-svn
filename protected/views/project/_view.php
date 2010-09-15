<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project')); ?>:</b>
	<?php echo CHtml::encode($data->project); ?>
	<br />

	<b>Repository:</b>
	<?php 
	$repos='http://svn.localhost/repos/'.Yii::app()->user->name.'...'.$data->project.'/trunk/';
	echo $repos;
	?>
	<br />

	<b>&nbsp;&nbsp;Check-out:</b>
	<?php
	echo "svn co $repos &lt;local_directory&gt;";
	?>
	<br />

	<b>&nbsp;&nbsp;Add:</b>
	<?php
	echo "svn add &lt;local_directory&gt;/*;";
	?>
	<br />

	<b>&nbsp;&nbsp;Check-in:</b>
	<?php
	echo "svn ci &lt;local_directory&gt;";
	?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

</div>