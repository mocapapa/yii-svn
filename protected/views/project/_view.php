<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project')); ?>:</b>
	<font size="+1"><?php echo CHtml::link(CHtml::encode($data->project), array('view', 'id'=>$data->id)); ?></font>
	<br />

	<div><span style="float: right;">
        <?php
         $repos='/var/www/html/yii/demos/yii-svn/repos/';
         $prj = Yii::app()->user->name.'...'.$data->project;
        ?>
          Rev <?php system("/usr/bin/svnlook youngest $repos$prj"); ?>
        </span></div>

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />
	<img src="/yii/demos/yii-svn/images/small.jpg" width="1" height="5">
	<hr>

	<div><span style="float: right;">
	<?php
   	$this->widget('zii.widgets.jui.CJuiButton',
		array(
			'name'=>'button'.Yii::app()->user->name.$data->project,
			'buttonType'=>'link',
			'caption'=>'view',
			'url'=>'/websvn-2.3.3/listing.php?repname='.$prj.'&path=%2Ftrunk%2F&isdir=1',
		));
   
	?>
	</span>
	<b>Repository:</b>
	<?php 
	$repos='http://svn.s3.ed.fujitsu.co.jp/repos/'.$prj.'/trunk/';
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