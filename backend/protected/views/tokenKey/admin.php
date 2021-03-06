<?php
/* @var $this TokenKeyController */
/* @var $model TokenKey */

$this->breadcrumbs=array(
	'Token Keys'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TokenKey', 'url'=>array('index')),
	array('label'=>'Create TokenKey', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#token-key-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Token Keys</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'token-key-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'token_key',
		'lifetime',
		'create_date',
		'reclaim_date',
		'expiration_date',
		/*
		'token_customer_id',
		'token_setup_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
