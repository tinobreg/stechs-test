<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "docsis_update".
 * @property string $modem_macaddr
 * @property string $ipaddr
 * @property string $cmts_ip
 * @property string $agentid
 * @property string $version
 * @property string $mce_concat
 * @property string $mce_ver
 * @property string $mce_frag
 * @property string $mce_phs
 * @property string $mce_igmp
 * @property string $mce_bpi
 * @property int $mce_ds_said
 * @property int $mce_us_sid
 * @property string $mce_filt_dot1p
 * @property string $mce_filt_dot1q
 * @property int $mce_tetps
 * @property int $mce_ntet
 * @property string $mce_dcc
 * @property string $thetime
 * @property string $offer_time
 * @property string $ack_time
 * @property int $net_id
 * @property int $cluster_id
 * @property int $ra_id
 * @property string $vsi_devtype
 * @property string $vsi_esafetypes
 * @property string $vsi_serialno
 * @property string $vsi_hwver
 * @property string $vsi_swver
 * @property string $vsi_bootrom
 * @property string $vsi_oui
 * @property string $vsi_model
 * @property string $vsi_vendor
 *
 *
 * Class Modem
 * @package common\models\base
 */
class Modem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docsis_update';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modem_macaddr', 'ipaddr', 'cmts_ip', 'agentid', 'version'], 'required'],
            [['modem_macaddr'], 'string', 'max' => 15],
            [['modem_macaddr', 'ipaddr'], 'unique'],
            [['ipaddr'], 'string', 'max' => 16],
            [['cmts_ip'], 'string', 'max' => 16],
            [['agentid'], 'string', 'max' => 20],
            [['version'], 'string', 'max' => 5],
            [['mce_concat', 'mce_ver', 'mce_frag', 'mce_phs', 'mce_igmp', 'mce_bpi', 'mce_filt_dot1p', 'mce_filt_dot1q', 'mce_dcc'], 'string', 'max' => 10],
            [['thetime', 'offer_time', 'ack_time'], 'string', 'max' => 18],
            [['mce_ds_said', 'mce_us_sid', 'mce_tetps', 'mce_ntet', 'mce_ds_said', 'mce_us_sid', 'net_id', 'cluster_id', 'ra_id'], 'integer'],
            [['vsi_devtype', 'vsi_esafetypes', 'vsi_serialno', 'vsi_hwver', 'vsi_swver', 'vsi_bootrom', 'vsi_oui', 'vsi_model', 'vsi_vendor'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'modem_macaddr' => Yii::t('app', 'modem_macaddr'),
            'ipaddr' => Yii::t('app', 'ipaddr'),
            'cmts_ip' => Yii::t('app', 'cmts_ip'),
            'agentid' => Yii::t('app', 'agentid'),
            'version' => Yii::t('app', 'version'),
            'mce_concat' => Yii::t('app', 'mce_concat'),
            'mce_ver' => Yii::t('app', 'mce_ver'),
            'mce_frag' => Yii::t('app', 'mce_frag'),
            'mce_phs' => Yii::t('app', 'mce_phs'),
            'mce_igmp' => Yii::t('app', 'mce_igmp'),
            'mce_bpi' => Yii::t('app', 'mce_bpi'),
            'mce_ds_said' => Yii::t('app', 'mce_ds_said'),
            'mce_us_sid' => Yii::t('app', 'mce_us_sid'),
            'mce_filt_dot1p' => Yii::t('app', 'mce_filt_dot1p'),
            'mce_filt_dot1q' => Yii::t('app', 'mce_filt_dot1q'),
            'mce_tetps' => Yii::t('app', 'mce_tetps'),
            'mce_ntet' => Yii::t('app', 'mce_ntet'),
            'mce_dcc' => Yii::t('app', 'mce_dcc'),
            'thetime' => Yii::t('app', 'thetime'),
            'offer_time' => Yii::t('app', 'offer_time'),
            'ack_time' => Yii::t('app', 'ack_time'),
            'net_id' => Yii::t('app', 'net_id'),
            'cluster_id' => Yii::t('app', 'cluster_id'),
            'ra_id' => Yii::t('app', 'ra_id'),
            'vsi_devtype' => Yii::t('app', 'vsi_devtype'),
            'vsi_esafetypes' => Yii::t('app', 'vsi_esafetypes'),
            'vsi_serialno' => Yii::t('app', 'vsi_serialno'),
            'vsi_hwver' => Yii::t('app', 'vsi_hwver'),
            'vsi_swver' => Yii::t('app', 'vsi_swver'),
            'vsi_bootrom' => Yii::t('app', 'vsi_bootrom'),
            'vsi_oui' => Yii::t('app', 'vsi_oui'),
            'vsi_model' => Yii::t('app', 'vsi_model'),
            'vsi_vendor' => Yii::t('app', 'vsi_vendor')
        ];
    }
}
