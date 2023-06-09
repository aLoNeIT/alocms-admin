<?php
declare (strict_types = 1);

namespace app\middleware\mobile;


use app\middleware\Base;



/**
 * 判断浏览器环境校验中间件
 */
class InAppCheck extends Base
{
    public function handle($request, \Closure $next)
    {
        $request->InApp = '222';
        if (preg_match('~micromessenger~i', $request->header('user-agent'))) {
            $request->InApp = 'WeChat';
        } else if (preg_match('~alipay~i', $request->header('user-agent'))) {
            $request->InApp = 'Alipay';
        }
        return $next($request);
    }
}
