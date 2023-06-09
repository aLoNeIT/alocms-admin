<?php
declare (strict_types = 1);

namespace app\middleware\privilege;

use app\common\logic\Session as SessionLogic;
use app\common\Request;
use app\middleware\Base;
use app\common\util\JsonTable;

/**
 * 微信验证权限
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-15
 */
class UserCms extends Base
{

    protected $app = null;
    protected $session = null;

    protected function initialize()
    {
        parent::initialize();
        $this->app = app();
        $this->session = app('session');
    }

    protected function before(Request $request) : JsonTable
    {

        $varSessionId = $this->app->config->get('session.var_session_id');
        //查询用户的信息
        $request = request();
        $module = app('http')->getName();
        $controller = $request->controller();
        $action = $request->action();
        // 从配置文件获取白名单信息
        $whiteList = config('system.user.white_list');
        $path = \strtolower(\implode('/', [$module, $controller, $action]));
        if(in_array($path,$whiteList)) return $this->jsonTable->success();
        $result = SessionLogic::instance()->check(request()->appType());
        if(!$result->isSuccess()){
            return $result;
        };
        return $this->jsonTable->success();
    }
}
