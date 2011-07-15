<?php
$this->breadcrumbs=array(
	'Files',
);

$this->menu=array(
	array('label'=>'Create Files', 'url'=>array('create')),
	array('label'=>'Manage Files', 'url'=>array('admin')),
);
?>

<h1>Files</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns'=>array (
        array (
            'class' => 'CLinkColumn',
            'labelExpression' => '$data->filename',
            'urlExpression' => '"/index.php/files/download/".$data->id',
            'header' => 'Files',
        ),
    )
));
?>
