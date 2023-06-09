<?php
declare (strict_types = 1);

namespace app\middleware\common;

use app\common\Request;
use app\middleware\Base;
use app\common\logic\Privilege as PrivilegeLogic;
use app\common\util\JsonTable;

/**
 * 系统权限全局预处理
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-15
 */
class Test extends Base
{
    protected function before(Request $request) : JsonTable
    {
        $appTypeMap = config('system.app_type');
        $type=intval($appTypeMap[app('http')->getName()] ?? 3);
        dump($type);
        return $this->jsonTable->success();
    }
}
