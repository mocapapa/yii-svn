<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project')); ?>:</b>
	<font size="+1"><?php echo CHtml::encode($data->project); ?></font>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />
	<img src="/demos/yii-svn/images/small.jpg" width="1" height="5">
	<hr>

	<div><span style="float: right;">
	<?php
   	$this->widget('zii.widgets.jui.CJuiButton',
		array(
			'name'=>'button'.Yii::app()->user->name.$data->project,
			'buttonType'=>'link',
			'caption'=>'view',
			'url'=>'/websvn-2.3.1/listing.php?repname='.Yii::app()->user->name.'...'.$data->project,
		));
   
	?>
	</span>
	<b>Repository:</b>
	<?php 
	$repos='http://svn.localhost/repos/'.Yii::app()->user->name.'...'.$data->project.'/trunk/';
	echo $repos;
	?>
	</div>

	<br />
	<b>&nbsp;&nbsp;Check-out:</b>
	<?php echo "svn co $repos &lt;local_directory&gt;"; ?>
	<br />

	<b>&nbsp;&nbsp;Add:</b>
	svn add &lt;local_directory&gt;/*
	<br />

	<b>&nbsp;&nbsp;Check-in:</b>
	svn ci -m 'initial entry' &lt;local_directory&gt;
	<br />

</div>