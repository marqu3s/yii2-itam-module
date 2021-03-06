<?php

use marqu3s\itam\Module;
use marqu3s\itam\models\Location;
use marqu3s\itam\models\Os;
use marqu3s\itam\models\OsLicense;
use marqu3s\itam\models\OfficeSuite;
use marqu3s\itam\models\OfficeSuiteLicense;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetWorkstationForm */
/* @var $form yii\widgets\ActiveForm */

\marqu3s\itam\assets\ModuleAsset::register($this);

$js = <<<JS
updateGrid();
JS;
$this->registerJs($js);

# Include the file containing the modal that adds a software to the asset.
include(__DIR__ . '/../layouts/_softwareAssetModal.php');
?>

<div class="workstation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->errorSummary($form); ?>

    <?php include (__DIR__ . '/../layouts/_assetForm.php') ?>

    <?= $form->field($model->assetWorkstation, 'user')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model->assetWorkstation, 'id_os')->dropDownList(ArrayHelper::map(Os::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => '--', 'id' => 'ddOs']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model->assetWorkstation, 'id_os_license')->dropDownList(ArrayHelper::map(OsLicense::find()->where(['id_os' => $model->assetWorkstation->id_os])->orderBy(['date_of_purchase' => SORT_DESC])->all(), 'id', 'key'), ['prompt' => '--', 'id' => 'ddOsLicense']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model->assetWorkstation, 'id_office_suite')->dropDownList(ArrayHelper::map(OfficeSuite::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => Module::t('app', 'Not installed'), 'id' => 'ddOfficeSuite']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model->assetWorkstation, 'id_office_suite_license')->dropDownList(ArrayHelper::map(OfficeSuiteLicense::find()->where(['id_office_suite' => $model->assetWorkstation->id_office_suite])->orderBy(['date_of_purchase' => SORT_DESC])->all(), 'id', 'key'), ['prompt' => '--', 'id' => 'ddOfficeSuiteLicense']) ?>
        </div>
    </div>

    <?php
    # Include the file containing the form part that adds a software to the asset.
    include(__DIR__ . '/../layouts/_softwareAssetForm.php');

    # Include the file containing the form part that adds an asset to a group.
    include(__DIR__ . '/../layouts/_assetGroupForm.php');

    # Include the file containing the form field to add an annotation to the asset.
    include(__DIR__ . '/../layouts/_assetAnnotations.php');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->asset->isNewRecord ? Module::t('app', 'Create') : Module::t('app', 'Update'), ['class' => $model->asset->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
