<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 15/04/17
 * Time: 00:00
 */

use marqu3s\itam\Module;

rmrevin\yii\fontawesome\AssetBundle::register($this);

/** @var $this \yii\web\View */
/** @var $content string */

$css = <<<CSS
.nav-pills>li {
    float: none;
}
CSS;
$this->registerCss($css);
?>
<?php $this->beginContent(Yii::$app->viewPath . '/layouts/' . Yii::$app->layout . '.php') ?>
<div class="row">
    <div class="col-md-2">
        <?php echo \yii\bootstrap\Nav::widget([
            'activateParents' => true,
            'items' => [
                [
                    'label' => Module::t('menu', 'Dashboard'),
                    'url' => ['dashboard/index'],
                    //'linkOptions' => ['class' => 'list-group-item'],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetManager'),
                    'label' => Module::t('menu', 'Servers'),
                    'url' => ['asset-server/index'],
                    //'linkOptions' => ['class' => 'list-group-item'],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'AssetManager'),
                    'label' => Module::t('menu', 'Workstations'),
                    'url' => ['asset-workstation/index'],
                    //'linkOptions' => ['class' => 'list-group-item'],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin'),
                    'label' => Module::t('menu', 'Locations'),
                    'url' => ['location/index'],
                    //'linkOptions' => ['class' => 'list-group-item'],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager'),
                    'label' => Module::t('menu', 'OSes'),
                    'url' => ['os/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager'),
                    'label' => Module::t('menu', 'OS Licenses'),
                    'url' => ['os-license/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager'),
                    'label' => Module::t('menu', 'Office Suites'),
                    'url' => ['office-suite/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager'),
                    'label' => Module::t('menu', 'Office Suite Licenses'),
                    'url' => ['office-suite-license/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'SoftwareManager'),
                    'label' => Module::t('menu', 'Software'),
                    'url' => ['software/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'LicenseManager'),
                    'label' => Module::t('menu', 'Software Licenses'),
                    'url' => ['software-license/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'ViewReports'),
                    'label' => Module::t('menu', 'Reports'),
                    'url' => ['reports/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'visible' => !$this->context->module->rbacAuthorization || Yii::$app->user->can($this->context->module->rbacItemPrefix . 'Admin'),
                    'label' => 'Admin',
                    'items' => [
                        ['label' => 'User Management', 'url' => ['user/index']],
                        ['label' => 'User Permissions', 'url' => ['user/permissions']],
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Authorization</li>',
                        ['label' => 'Create authorization rules', 'url' => ['authorization/create-rules']],
                    ],
                ],
            ],
            'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
        ]);
        ?>
    </div>
    <div class="col-md-10">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
