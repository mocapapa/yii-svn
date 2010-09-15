<?php
$this->breadcrumbs=array(
	'Project2s'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List project2', 'url'=>array('index')),
	array('label'=>'Manage project2', 'url'=>array('admin')),
);
?>

<h1>Create project2</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>