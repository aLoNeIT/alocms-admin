<?php

namespace app\home\controller\v1;

use app\common\logic\CloudCallCenter as CloudCallCenterLogic;
use app\home\controller\Base;
use ccc\facade\CCC as TcccFacade;


class Tccc extends Base
{

    protected $tccc = null;
    protected function initialize()
    {
        parent::initialize();
        $this->tccc = TcccFacade::store('qcloud');
    }

    public function user_token()
    {
//        public function userTokenForSDKLogin(string $userAccount , string $action, string $version = '', string $sdkAppId = ''): array

//        $result = $this->tccc->userTokenForLogin('006');
//        return $this->jecho($this->jsonTable->setByArray($result));

        return $this->jecho( CloudCallCenterLogic::instance()->userToken(2,'006'));

    }

}
