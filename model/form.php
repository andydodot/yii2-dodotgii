<?php
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var yii\gii\generators\form\Generator $generator
 */

echo $form->field($generator, 'tableName');
echo $form->field($generator, 'tablePrefix');
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'ns');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'db');
echo $form->field($generator, 'generateRelations')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateModelClass')->checkbox();
?>
<?= "<h4>Timestamp Behaviors</h4>";?>
<div class="row">
    <div class="col-md-3">
<?= $form->field($generator, 'createdAt'); ?>
    </div>
    <div class="col-md-3">
<?= $form->field($generator, 'updatedAt'); ?>
    </div>
    <div class="col-md-6">
<?= $form->field($generator, 'timestampValue'); ?>
    </div>
</div>    
<?php
echo "<h4>Blameable Behaviors</h4>";
?>
<div class="row">
    <div class="col-md-3">
<?= $form->field($generator, 'createdBy'); ?>
    </div>
    <div class="col-md-3">
<?= $form->field($generator, 'updatedBy'); ?>
    </div>
    <div class="col-md-6">
<?= $form->field($generator, 'blameableValue'); ?>
    </div>
</div>  

<?php
echo "<h4>Terminal Behaviors</h4>";
?>
<div class="row">
    <div class="col-md-3">
<?= $form->field($generator, 'createdTerminal'); ?>
    </div>
    <div class="col-md-3">
<?= $form->field($generator, 'updatedTerminal'); ?>
    </div>
    <div class="col-md-6">
<?= $form->field($generator, 'terminalValue'); ?>
    </div>
</div>  

<?php
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
?>
