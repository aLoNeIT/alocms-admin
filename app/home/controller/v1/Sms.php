<?php

declare(strict_types=1);


namespace app\home\controller\v1;


use app\common\logic\Sms as SmsLogic;
use app\home\controller\Base;


class Sms  extends Base
{
    public function save()
    {
        $mp = $this->request->post('mp/s', '');
        //函数在短信业务分支存在
        return $this->jecho(SmsLogic::instance()->sendCode($mp));
    }
}
