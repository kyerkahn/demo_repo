<?php
$this->breadcrumbs=array(
	'Docs',
);

$this->menu=array(
	array('label'=>'Create Docs', 'url'=>array('create')),
	array('label'=>'Manage Docs', 'url'=>array('admin')),
);
?>

<h1>Docs</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    //'dataProvider' => $model->search(),
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns'=>array (
        'title',
        array (
            'name' => 'comment',
            'filter' => false,
        ),
        array (
            'name' => 'status',
            'filter' => $model->statuses,
        ),
        array (
            'class' => 'CLinkColumn',
            'labelExpression' => '$data->filename',
            'urlExpression' => '"download/".$data->id',
            'header' => 'File',
        ),
        array (
            'name' => 'created_at',
            'filter' => false,
        ),
    )
));
?>
