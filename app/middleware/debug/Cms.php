<?php
declare (strict_types = 1);

namespace app\middleware\debug;

use app\common\logic\Session as SessionLogic;
use app\common\Request;
use app\common\util\JsonTable;
use app\middleware\Base;

/**
 * 系统权限处理
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-15
 */
class Cms extends Base
{
    protected function before(Request $request): JsonTable
    {
        $appType=request()->appType();
        //是否不校验session
        if(request()->getCheck('session') === false){
            // 检查会话状态
            if (!($jResult = SessionLogic::instance()->check($appType))->isSuccess()) {
                $jResult = SessionLogic::instance()->login('admin', '123456', 3);
                if($jResult->isSuccess()){
                    $data = $jResult->data;
                    request()->withHeader(['token'=>$data[ "token"]]);
                }
            }
        }
        return $this->jsonTable->success();
    }


}
