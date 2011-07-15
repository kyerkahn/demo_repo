<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'docs-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->statuses); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userList'); ?>
        <?php echo $form->dropDownList($model, 'userList', CHtml::listData(Users::model()->findAll(), 'id', 'username'), array('multiple' => 'multiple')); ?> ctrl - multiselect
		<?php echo $form->error($model,'userList'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'filesToUpload'); ?>
        <?php
            $this->widget('CMultiFileUpload', array(
                'model' => $model,
                'name' => 'filesToUpload',
                'attribute' => 'filesToUpload',
            ));
        ?>
		<?php echo $form->error($model,'filesToUpload'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
