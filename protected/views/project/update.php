<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Project', 'url'=>array('index')),
	array('label'=>'Create Project', 'url'=>array('create')),
	array('label'=>'View Project', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Project #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form_update', array('model'=>$model)); ?>