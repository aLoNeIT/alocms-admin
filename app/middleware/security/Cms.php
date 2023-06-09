<?php
declare (strict_types = 1);

namespace app\middleware\security;

use app\common\Request;
use think\Response;
use app\middleware\Base;
use app\common\logic\Privilege as PrivilegeLogic;
use app\common\util\JsonTable;

/**
 * 通讯加密处理
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-28
 */
class Cms extends Base
{
    protected function before(Request $request) : JsonTable
    {
        return $this->jsonTable->success();
    }

    protected function after(Request $request,Response $response) : JsonTable
    {
        return $this->jsonTable->success();
    }
}
