<?php
$this->breadcrumbs=array(
	'Project2s'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List project2', 'url'=>array('index')),
	array('label'=>'Create project2', 'url'=>array('create')),
	array('label'=>'Update project2', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete project2', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage project2', 'url'=>array('admin')),
);
?>

<h1>View project2 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'project',
		'description',
	),
)); ?>
