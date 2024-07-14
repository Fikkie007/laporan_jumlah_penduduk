<?php

namespace app\controllers;

use app\models\Kabupaten;
use app\models\Penduduk;
use Yii;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class PendudukController extends \yii\web\Controller
{
    use \jeemce\controllers\AppCrudTrait;

    protected $modelClass = Penduduk::class;

    public function actionIndex()
    {
        $searchModel = new DynamicModel(array_merge([
            'search',
            'prov',
            'kab',
        ], $this->request->queryParams));

        $searchQuery = $this->modelClass::find()
            ->joinWith('province p')
            ->joinWith('kabupaten k')
            ->andFilterWhere([
                'OR',
                ['like', 'LOWER(k.name)', strtolower($searchModel->search)],
                ['like', 'LOWER(p.name)', strtolower($searchModel->search)],
                ['like', 'LOWER(penduduk.name)', strtolower($searchModel->search)],
            ])
            ->andFilterWhere(['penduduk.province_id' => $searchModel->prov])
            ->andFilterWhere(['penduduk.kabupaten_id' => $searchModel->kab]);

        $dataProvider = new ActiveDataProvider([
            'query' => $searchQuery,
        ]);

        return $this->render('index', get_defined_vars());
    }

    public function actionForm($id = null)
    {
        $modelClass = $this->modelClass;

        $model = $id ? $modelClass::findOne($id) : new $modelClass();

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($this->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Menyimpan Data');
            }
        }

        return $this->render('form', get_defined_vars());
    }

    public function actionOptions($province_id = null)
    {
        $kabupatenOpts = Kabupaten::find()
            ->where(['province_id' => $province_id])
            ->orderBy('name')
            ->all();

        $options = '';
        foreach ($kabupatenOpts as $kabupaten) {
            $options .= "<option value='{$kabupaten->kabupaten_id}'>{$kabupaten->name}</option>";
        }

        return $options;
    }

    public function actionExport()
    {

        $searchModel = new DynamicModel(array_merge([
            'search',
            'prov',
            'kab',
        ], $this->request->queryParams));

        $searchQuery = $this->modelClass::find()
            ->joinWith('province p')
            ->joinWith('kabupaten k')
            ->andFilterWhere([
                'OR',
                ['like', 'LOWER(k.name)', strtolower($searchModel->search)],
                ['like', 'LOWER(p.name)', strtolower($searchModel->search)],
                ['like', 'LOWER(penduduk.name)', strtolower($searchModel->search)],
            ])
            ->andFilterWhere(['penduduk.province_id' => $searchModel->prov])
            ->andFilterWhere(['penduduk.kabupaten_id' => $searchModel->kab]);

        $models = $searchQuery->all();

        return $this->render('excel', get_defined_vars());
    }



    public function actionDelete($id)
    {
        $this->modelClass::findOne($id)->delete();

        Yii::$app->session->setFlash('success', 'Data Berhasil Dihapus');
        return $this->redirect(Url::current(['index']));
    }

    protected function findModel($params)
    {
        if (($model = $this->modelClass::findOne($params))) return $model;
        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }
}
