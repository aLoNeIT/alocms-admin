<?php
declare (strict_types = 1);

namespace app\middleware\privilege;

use app\common\facade\ErrCode as ErrCodeFacade;
use app\common\model\ApiCommunicant as ApiCommunicantModel;
use app\common\Request;
use app\common\util\JsonTable;
use app\common\facade\JsonTable as JsonTableFacade;
use app\middleware\Base;
use signature\facade\Signature as SignatureFacade;
use think\Response;

/**
 * 开放平台中间件，主要用于请求参数解密和响应参数加密计算
 * @author aLoNe.Adams.K <alone@alonetech.com>
 * @date 2021-01-07
 */
class OpenPlatform extends Base
{
    /**
     * 存储加解密相关信息
     *
     * @var array
     */
    protected $secretInfo = [];

    protected function before(Request $request): JsonTable
    {
        // 获取开放平台相关信息
        $appid = $request->get('appid', '');
        if ('' == $appid) {
            return ErrCodeFacade::getJError(10);
        }
        $api = ApiCommunicantModel::where('ac_appid', $appid)->find();
        if (is_null($api)) {
            return ErrCodeFacade::getJError(25);
        }
        $this->secretInfo = [
            'appsecret' => $api->ac_appsecret ?? '',
            'self_private' => $api->ac_self_private ?? '',
            'self_public' => $api->ac_self_public ?? '',
            'communit_public'=>$api->ac_communit_public ?? '',
        ];
        foreach($this->secretInfo as $key=>$value){
            // 有元素为空，则报错
            if(''==$value){
                return ErrCodeFacade::getJError(29);
            }
        }
        // 开始进行解密
        $data = SignatureFacade::store('xiaorong')
            ->setSecretInfo([
                'private_key'=>$this->secretInfo['self_private'],
                'public_key'=>$this->secretInfo['communit_public'],
                'appsecret'=>$this->secretInfo['appsecret'],
            ])
            ->decrypt([
                'content' => $request->post('content'),
                'key' => $request->post('key'),
                'sign' => $request->post('sign'),
            ]);
        if('GET'==strtoupper($request->method())){
            // 因为使用了伪请求，所以get时候获取不到url上的参数，需要从post内获取
            $reqData = $request->post();
            // 清理掉无用的数据content、key、sign
            unset($reqData['content'],$reqData['key'],$reqData['sign']);
            $request->withGet(\array_merge($reqData,  $data));
        }else{
            $request->withPost($data);
        }
        return $this->jsonTable->success();
    }

    protected function after(Request $request, Response $response): JsonTable
    {
        $jResult = parent::after($request, $response);
        // 执行失败则直接返回
        if(!$jResult->isSuccess()){
            return $jResult;
        }
        // 提取响应数据
        $data = $response->getData();
        \logListenDebug('openplatform', '后置中间件获取数据', [
            'secret_info' => $this->secretInfo,
            'data' => $data,
        ]);
        // 对数据进行加密
        $data = SignatureFacade::store('xiaorong')
            ->setSecretInfo([
                'private_key'=>$this->secretInfo['self_private'],
                'public_key'=>$this->secretInfo['communit_public'],
                'appsecret'=>$this->secretInfo['appsecret'],
            ])
            ->encrypt($data);
        // 响应结果，最外层是jtable，data节点数据需要进行解密，解密后还是jtable格式数据
        $response->data(\jsuccess('success',$data));
        //返回响应对象
        return $this->jsonTable->success();
    }
}
