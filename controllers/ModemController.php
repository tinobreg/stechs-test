<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Modem;
use app\models\ModelSoftware;

/**
 * Class ModemController
 * @package app\controllers
 */
class ModemController extends BaseController
{

    /**
     * Returns all modem in database
     * If $mac is set returns the modem
     * @param string|null $mac
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public function actionList($mac = null)
    {
        return Modem::find()->byMacAddress($mac)->all();
    }

    /**
     * Returns all modems by Vendor
     * @param $vendor
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public function actionListByVendor($vendor)
    {
        $models = Modem::find()->byVendor($vendor)->all();
        if(!empty($models)) {
            return ['success' => true, 'modems' => $models];
        }

        return ['success' => false, 'error' => 'No se encontraron cablemódem para el fabricante: '.$vendor];
    }

    /**
     * Returns all modems by Vendor if they are not in JSON file
     * @param $vendor
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionNoMatch($vendor)
    {
        $models = Modem::find()->byVendor($vendor)->all();

        if(!empty($models)) {
            $modelSoftware = new ModelSoftware();
            $modelSoftwareList = $modelSoftware->getFormattedVendors();
            $auxModels = [];
            $vendorNames = [];

            /** @var Modem[] $models */
            foreach ($models as $model) {
                $vendorKey = ModelSoftware::getVendorKeyByVendorName($model->vsi_vendor);
                if(!isset($modelSoftwareList[$vendorKey][$model->vsi_model][$model->vsi_swver])) {
                    $vendorNames[$vendorKey] = $model->vsi_vendor;
                    $auxModels[] = $this->prepareModemForTable($model);
                }
            }

            return ['success' => true, 'modems' => $auxModels, 'vendors' => implode(', ', $vendorNames)];
        }

        return ['success' => false, 'error' => 'No se encontraron cablemódem para el fabricante: '.$vendor];
    }

    /**
     * Receives a mac address through POST REQUEST and tries to add this software version and model into JSON File
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddModem()
    {
        if(!empty($_POST['macaddress'])) {
            $model = Modem::find()->byMacAddress($_POST['macaddress'])->one();
            if($model instanceof Modem) {
                if(!empty($model->vsi_swver) && !empty($model->vsi_model) && !empty($model->vsi_vendor)) {
                    $modelSoftware = new ModelSoftware();
                    if($modelSoftware->addModem($model)) {
                        return ['success' => true, 'message' => 'Se ha actualizado correctamente el listado de modelos.'];
                    }

                    return ['success' => false, 'error' => 'El modelo de cablemodem no pudo ser agregado.'];
                }

                return ['success' => false, 'error' => 'El cablemodem no tiene definido el modelo o la version de software.'];
            }

            return ['success' => false, 'error' => 'No se encontro un cablemodem para la Mac address: '.$_POST['macaddress']];
        }

        return ['success' => false, 'error' => 'Parametro \'macaddress\' requerido.'];
    }

    /**
     * Receives a Modem model and returns the needed attributes for render the table
     * @param $modem
     * @return array
     */
    private function prepareModemForTable($modem)
    {
        if(!empty($modem) && $modem instanceof Modem) {
            return [
                'modem_macaddr' => $modem->modem_macaddr,
                'ipaddr' => $modem->ipaddr,
                'vsi_model' => $modem->vsi_model,
                'vsi_swver' => $modem->vsi_swver
            ];
        }

        return [];
    }
}
