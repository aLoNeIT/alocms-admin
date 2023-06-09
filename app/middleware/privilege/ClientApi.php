<?php
declare (strict_types = 1);

namespace app\middleware\privilege;

use app\common\facade\ErrCode as ErrCodeFacade;
use app\common\model\ApiCommunicant as ApiCommunicantModel;
use app\common\Request;
use app\common\util\JsonTable;
use app\middleware\Base;
use signature\facade\Signature as SignatureFacade;
use think\Response;

/**
 * 开放平台中间件，主要用于请求参数解密和响应参数加密计算
 * @author aLoNe.Adams.K <alone@alonetech.com>
 * @date 2021-01-07
 */
class ClientApi extends Base
{
    protected $secretInfo = [];

    protected $config = [];

    protected function before(Request $request): JsonTable
    {
        $appid = $request->get('appid', '');
        if ('' == $appid) {
            return ErrCodeFacade::getJError(10);
        }
        $api = ApiCommunicantModel::where('ac_appid', $appid)->find();
        if (is_null($api)) {
            return ErrCodeFacade::getJError(25);
        }
        $appsecrt = $api->ac_appsecret ?? '';
        $selfPublic = $api->ac_self_public ?? '';
        $selfPrivate = $api->ac_self_private ?? '';

        if ($appsecrt === '' || $selfPublic === '' || $selfPrivate === '') {
            return ErrCodeFacade::getJError(29);
        }
        $this->secretInfo = [
            'private_key' => $selfPrivate,
            'public_key' => $selfPublic,
            'appsecret' => $appsecrt,
        ];
        // 开始进行解密
        $data = SignatureFacade::store('xiaorong')
            ->setSecretInfo($this->secretInfo)
            ->decrypt([
                'content' => $request->post('content'),
                'key' => $request->post('key'),
                'sign' => $request->post('sign'),
            ]);
        $request->withParam($data);
        return $this->jsonTable->success();
    }

    protected function after(Request $request, Response $response): JsonTable
    {
        $jResult = parent::after($request, $response);
        if (!$jResult->isSuccess()) {
            $data = $jResult->toArray();
        } else {
            $data = $response->getData();
        }
        \logListenDebug('openplatform', '后置中间件获取数据', [
            'secret_info' => $this->secretInfo,
            'data' => $data,
        ]);
        if (isset($data['data']) && !empty($this->secretInfo)) {
            //存在data数据节点，将响应内容转为json
            $dataJson = json_encode($data['data'], JSON_UNESCAPED_UNICODE);
            $dataBase64 = base64_encode($dataJson);
            $sign = sm2Sign($this->secretInfo['private_key'], $dataBase64, $this->secretInfo['appsecret'], 'base64', 'sys');
            $data['data'] = $dataJson;
            //设置响应header
            header('signature:' . $sign);
            /*//存在data数据节点，才需要对其进行加密
            $result = SignatureFacade::store('xiaorong')
            ->setSecretInfo($this->secretInfo)
            ->encrypt($data['data']);
            $data['data'] = $result;*/
            \logListenDebug('openplatform', '后置中间件加密完成', $data);
        }
        // 响应结果
        $response->data($data);
        //返回响应对象
        return $this->jsonTable->success();
    }
}
