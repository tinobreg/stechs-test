<?php

namespace app\models;

/**
 * Class ModelSoftware
 * @package app\models
 */
class ModelSoftware
{
    /**
     * Holds the JSON File Version
     * @var string
     */
    private $version = '';

    /**
     * Holds the JSON File modem models
     * @var array
     */
    private $modemModels = [];

    /**
     *
     * @var string
     */
    const FILENAME = __DIR__ . '/json/models.json';

    /**
     * Vendor constructor
     */
    public function __construct()
    {
        $fileJson = file_get_contents(self::FILENAME);

        if(!empty($fileJson)) {
            $fileJsonDecode = json_decode($fileJson, true);
            $this->version = $fileJsonDecode['version'];
            $this->modemModels = $fileJsonDecode['models'];
        } else {
            throw new \Exception('Failed opening JSON file');
        }
    }

    /**
     * Returns the stored modem models in a new formatted array for better search
     * @return array|mixed
     */
    public function getFormattedVendors() {
        if(!empty($this->modemModels)) {
            $arrayFormatted = [];
            foreach ($this->modemModels as $model) {
                $arrayFormatted[$model['vendor']][$model['name']][$model['soft']] = $model['soft'];
            }

            return $arrayFormatted;
        }

        return [];
    }

    /**
     * Receives a Modem model and tries to add this software version and model into JSON File
     * @param $modem
     * @return boolean|int
     */
    public function addModem($modem) {
        if($modem instanceof Modem) {
            $modelSoftwareList = $this->getFormattedVendors();
            $vendorKey = static::getVendorKeyByVendorName($modem->vsi_vendor);

            if(!isset($modelSoftwareList[$vendorKey][$modem->vsi_model][$modem->vsi_swver])) {
                /** @var Modem $modem */
                $this->modemModels[] = [
                    'vendor' => $vendorKey,
                    'name' => $modem->vsi_model,
                    'soft' => $modem->vsi_swver
                ];

                $jsonFile = [
                    'version' => $this->version,
                    'models' => $this->modemModels
                ];

                return file_put_contents(self::FILENAME, json_encode($jsonFile));
            }
        }

        return false;
    }

    /**
     * @param $vendor
     * @return string|null
     */
    public static function getVendorKeyByVendorName($vendor) {
        switch ($vendor) {
            case 'Arris Interactive, L.L.C.' :
                return 'Arris';
            case 'Cisco' :
                return 'Cisco';
            case 'Motorola Corporation' :
                return 'Moto';
            case 'Netwave' :
                return 'Netwave';
            case 'S-A' :
                return 'S-A';
        }

        return null;
    }
}