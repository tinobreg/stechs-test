<?php


namespace app\models;

use \app\models\base\Modem as BaseModem;
use app\models\query\ModemQuery;
use Yii;

class Modem extends BaseModem
{
    /**
     * @inheritdoc
     * @return object|\yii\db\ActiveQuery|ModemQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(ModemQuery::className(), [get_called_class()]);
    }
}