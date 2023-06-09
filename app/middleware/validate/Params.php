<?php
declare (strict_types = 1);

namespace app\middleware\validate;

use app\common\Request;
use app\common\util\JsonTable;
use app\middleware\Base;
use app\common\facade\ErrCode as ErrCodeFacade;


/**
 * 参数校验中间件
 */
class Params extends Base
{

    protected function before(Request $request): JsonTable
    {
        // 拼凑验证类完整命名
        $module = app('http')->getName();
        //处理多级控制器大小写问题
        $ctrls = \explode('.', $request->controller());
        $length = \count($ctrls);
        for ($i = 0; $i < $length - 2; $i++) {
            $ctrls[$i] = \strtolower($ctrls[$i]);
        }
        $controller = \implode('\\', $ctrls);
        //获取方法名
        $action = $request->action();
        $class = "app\\{$module}\\validate\\{$controller}";
        if (!\class_exists($class)) {
            $class = "app\\common\\validate\\".end($ctrls);
        }
        if (\class_exists($class)) {
            //实例化validate对象
            $validate = new $class();
            $checkData = $request->param();
            if(null !== $request->file()){
                $checkData = array_merge($request->param(),$request->file());
            }
            \logListenError('params_validate', 'middleware before', [
                'action' => $action,
                'checkData' => $checkData,
            ]);
            if ($validate->hasScene($action) && !$validate->scene($action)->check($checkData)) {
                return ErrCodeFacade::getJError(13, [
                    'content' => $validate->getError(),
                ]);
            }
        }
        return $this->jsonTable->success();
    }
}
