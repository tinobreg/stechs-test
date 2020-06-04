<?php

use ApiTester;

/**
 * Class addModelSoftwareCest
 */
class addModelSoftwareCest
{
    /**
     * @param \ApiTester $I
     */
    public function addModelSoftware(ApiTester $I)
    {
        $macAddress = '001dcdeebeda';
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('http://api.stechs.local/modem/add', [
            'macaddress' => $macAddress
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"success":true');
    }

    /**
     * @param \ApiTester $I
     */
    public function addModelSoftwareWrongMac(ApiTester $I)
    {
        $macAddress = '001dcde1231asdasd';
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('http://api.stechs.local/modem/add', [
            'macaddress' => $macAddress
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"success":false,"error":"No se encontro un cablemodem para la Mac address: '.$macAddress.'"}');
    }
}
