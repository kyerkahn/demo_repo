<?php
$this->breadcrumbs=array(
	'Docs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Docs', 'url'=>array('index')),
	array('label'=>'Manage Docs', 'url'=>array('admin')),
);
?>

<h1>Create Docs</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>