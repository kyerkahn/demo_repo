<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'files-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'guid'); ?>
		<?php echo $form->textField($model,'guid',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'guid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doc_id'); ?>
		<?php echo $form->textField($model,'doc_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'doc_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->