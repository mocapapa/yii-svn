<?php
$this->breadcrumbs=array(
	'Project2s'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List project2', 'url'=>array('index')),
	array('label'=>'Create project2', 'url'=>array('create')),
	array('label'=>'View project2', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage project2', 'url'=>array('admin')),
);
?>

<h1>Update project2 <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>