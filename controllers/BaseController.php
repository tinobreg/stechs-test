<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\HttpException;

/**
 * Class BaseController
 * @package api\controllers
 */
class BaseController extends Controller
{
    /**
     * @var bool See details {@link \yii\web\Controller::$enableCsrfValidation}.
     */
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    'Origin'                           => ['*'],
                    'Access-Control-Request-Method'    => ['POST', 'GET', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => false,
                ],
            ],
        ], parent::behaviors());
    }

    /**
     * @return \Exception|null
     * @throws HttpException
     */
    public function actionError()
    {
        $error = \Yii::$app->errorHandler->exception;
        if ($error) {
            return $error;
        } else {
            throw new HttpException(404, 'Page not found.');
        }
    }
}