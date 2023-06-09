<?php

namespace app\middleware;

use alocms\Request;
use alocms\util\CmsException;
use alocms\util\JsonTable;
use think\Response;

/**
 * 中间件基类
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-15
 */
class Base
{
    /**
     * 请求对象
     *
     * @var \alocms\Request
     */
    protected $request = null;
    /**
     * JsonTable对象
     *
     * @var JsonTable
     */
    protected $jsonTable = null;

    public function __construct()
    {
        $this->initialize();
    }

    protected function initialize()
    {
        $this->jsonTable = app('JsonTable', [], true);
    }

    public function handle(Request $request, \Closure $next)
    {
        try {
            $this->request = $request;
            //执行前置方法
            $jResult = $this->before($request);
            if ($jResult->isSuccess()) {
                //成功才执行之后的方法
                $response = $next($request);
            } else {
                $response = \json($jResult->toArray());
            }
            //执行后置方法
            $jResult = $this->after($request, $response);
            if (!$jResult->isSuccess()) {
                $response = \json($jResult->toArray());
            }
        } catch (CmsException $ex) {
            $response = \json(jtable($ex->getCode(), $ex->getMessage(), $ex->getData()));
            \logListenCritical('middleware', "中间件处理异常[{$ex->getMessage()}]", $ex->getData() ?? []);
        } catch (\Throwable $ex) {
            $response = \json(jerror($ex->getMessage()));
            \logListenCritical('middleware', "中间件处理异常[{$ex->getMessage()}]", $ex->getTrace());
        }
        return $response;
    }
    /**
     * 中间件前置方法，该方法返回的JsonTable对象中的data节点需要包含serviceInfo相关信息
     *
     * @param think\Request $request 请求对象
     * @return JsonTable
     */
    protected function before(Request $request): JsonTable
    {
        return $this->jsonTable->success();
    }
    /**
     * 中间件后置方法，若需要在后置方法中对响应数据进行修改，需要中间件自行修改
     *
     * @param think\Request $request 请求对象
     * @param think\Response $response 响应对象
     * @return JsonTable
     */
    protected function after(Request $request, Response $response): JsonTable
    {
        return $this->jsonTable->success();
    }
}
