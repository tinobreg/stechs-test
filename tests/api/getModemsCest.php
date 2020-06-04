<?php 

use ApiTester;

/**
 * Class getModemsCest
 */
class getModemsCest
{
    /**
     * @param \ApiTester $I
     */
    public function getModems(ApiTester $I)
    {
        $vendor = 'Arris';

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('http://api.stechs.local/modem/list/vendor/'.$vendor.'/empty');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"success":true,"modems":[{');
    }

    /**
     * @param \ApiTester $I
     */
    public function getModemsWrongVendor(ApiTester $I)
    {
        $vendor = 'dfghjklasd';

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('http://api.stechs.local/modem/list/vendor/'.$vendor.'/empty');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"success":false,"error":');
    }
}
