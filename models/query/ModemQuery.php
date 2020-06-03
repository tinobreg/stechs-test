<?php

namespace app\models\query;

use yii\db\ActiveQuery;
use yii\db\Expression;

class ModemQuery extends ActiveQuery
{

    /**
     * @param null|string $macAddress
     * @return ModemQuery
     */
    public function byMacAddress($macAddress = null)
    {
        if(!empty($macAddress)) {
            return $this->andWhere(['modem_macaddr' => strtolower(str_replace([':', '-', ' '], '', $macAddress))]);
        }

        return $this;
    }

    /**
     * @param string|null $vendor
     * @return ModemQuery
     */
    public function byVendor($vendor = null)
    {
        if(!empty($vendor)) {
            return $this->andFilterWhere(['LIKE', 'vsi_vendor', $vendor]);
        }

        return $this;
    }
}