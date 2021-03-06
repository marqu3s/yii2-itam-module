<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\OsLicense */

$this->title = Module::t('app', 'Update') . ': ' . $model->os->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'OS Licenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->os->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('app', 'Update');
?>
<div class="os-license-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
