<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 01:55
 */

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\OsLicense;
use marqu3s\itam\Module;
use marqu3s\itam\models\AssetForm;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class BaseCrudController is a base CRUD controller.
 * Controllers that defines CRUD operations for assets must extend this BaseController
 * and must define at least the value of the protected attribute [[$assetType]].
 *
 * To customize the GridView, define the data columns by defining [[$gridDataColumns]]
 * and the action column by defining [[$gridActionColumn]].
 *
 * @package marqu3s\itam\controllers
 */
abstract class BaseCrudController extends Controller
{
    private $modelNamespace = "marqu3s\\itam\\models\\";
    protected $assetType;

    protected $gridDataColumns = [];
    protected $gridActionColumn = [];


    /**
     * BaseCrudController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param array $config
     */
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        if (empty($this->assetType)) {
            throw new InvalidConfigException('assetType must be defined in the BaseCrudController child class.');
        }

        if (empty($this->gridDataColumns)) {
            $this->gridDataColumns = [[
                'asset.location.name',
                'asset.room',
                'asset.hostname',
                'asset.ip_address',
                'asset.mac_address',
                'asset.brand',
                'asset.model',
            ]];
        }

        if (empty($this->gridActionColumn)) {
            $this->gridActionColumn = [Module::$defaultGridActionColumn];
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $modelClass = $this->getClass('search');

        /** @var ActiveRecord $searchModel */
        $searchModel = new $modelClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridColumns' => array_merge($this->gridDataColumns, $this->gridActionColumn)
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $modelClass = $this->getClass('form');

        /** @var AssetForm $form */
        $form = new $modelClass();
        $form->setAttributes(Yii::$app->request->post());

        if (Yii::$app->request->post() && $form->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', $this->assetType) . ' ' . Module::t('app', 'created successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $form,
            ]);
        }
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelClass = $this->getClass('form');

        /** @var AssetForm $form */
        $form = new $modelClass();
        $form->{$this->assetType} = $this->findModel($id);
        $form->setAttributes(Yii::$app->request->post());

        if (Yii::$app->request->post() && $form->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', $this->assetType) . ' ' . Module::t('app', 'updated successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $form,
            ]);
        }
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Module::t('app', $this->assetType) . ' ' . Module::t('app', 'deleted successfully.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelClass = $this->getClass();

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Returns a full classname, with its namespace, based on [[$assetType]]
     *
     * @param string|null $type
     *
     * @return string
     *
     * @throws InvalidConfigException
     */
    private function getClass($type = '')
    {
        if (!in_array($type, ['', 'form', 'search'])) {
            throw new InvalidConfigException("The \$type parameter should be null, an empty string or one of the following values: 'form' or 'search'.");
        }

        return $this->modelNamespace . $this->assetType . ucfirst($type);
    }
}