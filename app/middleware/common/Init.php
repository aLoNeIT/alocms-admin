<?php
declare (strict_types = 1);

namespace app\middleware\common;

use app\common\Request;
use app\common\util\JsonTable;
use app\middleware\Base;
use think\Response;

/**
 * 系统权限全局预处理
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-15
 */
class Init extends Base
{

    protected $app = null;
    protected $session = null;

    protected function initialize()
    {
        parent::initialize();
        $this->app = app();
        $this->session = app('session');
    }

    protected function before(Request $request): JsonTable
    {
        // 初始化session
        // flash插件跨域问题
        $varSessionId = $this->app->config->get('session.var_session_id');
        // 获取session名称
        $sessionName = $this->session->getName();
        // 优先从header取session，然后request、然后cookie
        if ($request->header($sessionName)) {
            $sessionId = $request->header($sessionName);
        } else if ($varSessionId && $request->request($varSessionId)) {
            $sessionId = $request->request($varSessionId);
        } else {
            $sessionId = $request->cookie($sessionName);
        }
        // 给本次请求设置sessionid
        if ($sessionId) {
            $this->session->setId($sessionId);
        }
        // 初始化
        $this->session->init();

        $request->withSession($this->session);
        // session初始化完毕

        return $this->jsonTable->success();
    }

    protected function after(Request $request, Response $response): JsonTable
    {
        // 处理session相关
        $response->setSession($this->session);
        $sessionName = $this->session->getName();
        $sessionId = $this->session->getId();
        // 判断session应该写入到header还是cookie
        if ($request->header($sessionName)) {
            $response->header([
                $sessionName => $sessionId,
            ]);
        } else {
            $this->app->cookie->set($sessionName, $sessionId);
        }
        // session 处理完毕
        return $this->jsonTable->success();
    }

    public function end(Response $response)
    {
        // 请求结束统一写入session
        $this->session->save();
    }
}
