<?php
declare (strict_types = 1);

namespace app\middleware\privilege;

use app\common\logic\Privilege as PrivilegeLogic;
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
                return $jResult;
            }
        }
        //是否是权限白名单
        if(request()->getCheck('privilege') === false){
            // 检查用户权限
            return PrivilegeLogic::instance()->check();
        }
        return $this->jsonTable->success();
    }
}
