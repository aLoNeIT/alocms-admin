<?php
declare (strict_types = 1);

namespace app\middleware\common;

use app\common\logic\Session;
use app\common\model\UserLog as UserLogModel;
use app\common\Request;
use think\Response;
use app\common\util\JsonTable;
use app\middleware\Base;

/**
 * 系统权限处理
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-15
 */
class OperationLog extends Base
{
    protected $app = null;
    protected $session = null;
    protected $startTime = 0;
    protected $userLogId = 0;
    protected function before(Request $request): JsonTable
    {
        $this->startTime = microtime(true);
        return $this->jsonTable->success();
    }

    protected function after(Request $request, Response $response): JsonTable
    {
        // 处理session相关
        $this->session = session();
        // 获取session名称
        $appType=$request->appType();
        $module = app('http')->getName();
        $controller = $request->controller();
        $action = $request->action();
        $ip = $request->ip();
        $header = $request->header();
        $uid = Session::instance()->getUser()??0;

        $param = $request->param();
        $reData = $response->getData();
        if(isset($reData['data'])){
            unset($reData['data']);
        }
        $extend = json_encode(
            [
                'header'=>$header,
                'param'=>$param
            ]
        );
        $data = [

            "ul_app_type"=>$appType,
            "ul_user"=>$uid,
            "ul_ip"=>$ip,
            "ul_module"=>$module,
            "ul_controller"=>$controller,
            "ul_action"=>$action,
            "ul_extend"=>$extend,
            "ul_state"=>json_encode($reData),
            'ul_delete_time'=>0
        ];
        $model=UserLogModel::create($data);
        $this->userLogId=$model->ul_id;
        // session 处理完毕
        return $this->jsonTable->success();
    }

    public function end(Response $response)
    {
        $endTime = microtime(true);
        $responseTime=round(($endTime-$this->startTime)*1000);
        UserLogModel::instance()->where(['ul_id'=>$this->userLogId])->update(['ul_response_elapsed_time'=>$responseTime]);
    }


}
