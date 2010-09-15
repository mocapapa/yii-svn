<?php
$this->breadcrumbs=array(
	'Project2s',
);

$this->menu=array(
	array('label'=>'Create project2', 'url'=>array('create')),
	array('label'=>'Manage project2', 'url'=>array('admin')),
);
?>

<h1>Project2s</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
