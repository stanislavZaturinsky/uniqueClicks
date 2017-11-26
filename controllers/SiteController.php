<?php

namespace app\controllers;

use app\models\Statistics;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\News;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays news.
     *
     * @return string
     */
    public function actionNews()
    {
        return $this->render('news_all', [
            'news'        => News::find()->all(),
            'newHashCode' => Yii::$app->security->generateRandomString()
        ]);
    }

    /**
     * Display one news by id.
     *
     * @param $id int
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionView($id)
    {
        $news = News::findOne(['id' => $id]);
        if (!$news) {
            throw new NotFoundHttpException("New with id {$id} don't exist");
        }

        return $this->render('news_one', [
            'news' => $news
        ]);
    }

    /**
     * Displays statistics by clicks.
     *
     * @return string
     */
    public function actionStatistics()
    {
        $query = Statistics::find()
            ->select('news_id, COUNT(client_ip) as unique_clicks, SUM(count_clicks) as clicks, country_code, date')
            ->groupBy('news_id, client_ip')
            ->asArray()
            ->all();

        $provider = new ArrayDataProvider([
            'allModels' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['news_id','date'],
            ],
        ]);

        return $this->render('statistics', [
            'dataProvider' => $provider
        ]);
    }

    /**
     * Save click when user click on news button
     */
    public function actionSaveClick()
    {
        $model = new Statistics;
        if ($model->load(Yii::$app->request->post())) {
            $model->addClick();
        }
    }
}
