<?php

declare (strict_types = 1);


namespace app\middleware\privilege;



use app\common\Request;
use app\common\util\JsonTable;
use app\middleware\Base;
use acquirer\facade\Acquirer as AcquirerFacade;
use app\common\model\ApiCommunicant as ApiCommunicantModel;
use app\common\facade\ErrCode as ErrCodeFacade;
use think\Response;


/**
 * Class app\middleware\privilege\/PlatformAcquirerApi
 *
 * User: Loong
 * Date: 2021/9/13
 * Time: 9:56
 */
class PlatformAcquirerApi extends Base
{

    protected $secretInfo = [];

    protected $config = [];


    //秘钥信息存储库里。这里是为了测试方便和赋值方便！！！！！！

    //反馈给银行的报文

    protected $identy_code = '451073776100035';
    protected $cert = '-----BEGIN CERTIFICATE-----
MIICBjCCAW+gAwIBAgIJAP66vaEkzHDzMA0GCSqGSIb3DQEBCwUAMBwxGjAYBgNV
BAMMEXRlc3QuY3EuY2l0aWNiYW5rMB4XDTE5MDMyNzA2MjgwNloXDTIwMDMyNjA2
MjgwNlowHDEaMBgGA1UEAwwRdGVzdC5jcS5jaXRpY2JhbmswgZ8wDQYJKoZIhvcN
AQEBBQADgY0AMIGJAoGBAKXVlHkytLWyGEMaUxNSANgnrzplHgwD1h7KEf+8GL/b
pzKVLglO22UYhk+UHT71QRVwXinTlj+qvzA8nPHlG2jAmg+iErp0x00h8YCBnZb4
vmu0x4nVZGAIZlMDcmK4ItVZ/CUTkNCGtNKdd54PuMzYqGP7MD/ieZ3nRjx5LPj1
AgMBAAGjUDBOMB0GA1UdDgQWBBSN6fVZ0jaCNsJDgQHVxJ/+NOKqeDAfBgNVHSME
GDAWgBSN6fVZ0jaCNsJDgQHVxJ/+NOKqeDAMBgNVHRMEBTADAQH/MA0GCSqGSIb3
DQEBCwUAA4GBACRBrr2DGmWgBcO1pXJyltsm09ABkqgUO8KnKivBRJxfAso0Rjjb
P7ZyyY7iUWPJjhGiUfIQNVafps2UTcZWl9xbgu4VP47vgUjTGHgkJQDKLMbwEA6m
3DRcupC3KbwXYhERExe2G3IqVAdDAwvObamWU3DotOsbbxX7UARwVX6X
-----END CERTIFICATE-----';
    protected $private = '-----BEGIN PRIVATE KEY-----
MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAKXVlHkytLWyGEMa
UxNSANgnrzplHgwD1h7KEf+8GL/bpzKVLglO22UYhk+UHT71QRVwXinTlj+qvzA8
nPHlG2jAmg+iErp0x00h8YCBnZb4vmu0x4nVZGAIZlMDcmK4ItVZ/CUTkNCGtNKd
d54PuMzYqGP7MD/ieZ3nRjx5LPj1AgMBAAECgYB1IwwhH+Ptg8MHgwyzVPUrubxY
bxxuODeCwBE+psqEms7bN+ywvnbSTiRxCZou4mX6ksiwmrhCeIVbuTTS2JYmoDnN
anyF5cOtCj3SaprURvMIS5mV/dJi7J9SK6qMn1ZjHd7XbT76rMsGMppvzjNfmEUD
Wm3kjmLKLAPyDeaccQJBANz8+3WgfUukKBiHc8FiXesd5yZ8z98OogZa7+036nN7
cn/KOhpKhK3XkU0rBkbWEN+aNUFwEhp4WbtxsNWQPbsCQQDAG57vAcxsFlJI3Kyi
muwQcKzpPaT5JGMqLkFs03QIYY93xTBMenqWwku+2ox0nH3tTlslg8BZj6cOZfna
6OEPAkA4Ye+CfnUZZIO6ZmzZTVCrGVENl9Ctl50tQ+xtONP/rOJ0ylLyvEqH1DVF
XBHY5usdMcoerQphaI10brhwdMHbAkA6WymYaO90FgPA5mf6rRzwkYm1AGjQ1eDZ
u1tcd49TzG8MbvYRBVOf4D2qKDFqau9F2vuNFcykaCLTGN8hRIS5AkB7OLsNKFrF
4pUZnEH5QD+OO9vxwrzBfYcjpqnaZA+F1GMdvn0UvXLFt3DinkhKMBGSOSZvPbnA
PVoijZDU842K
-----END PRIVATE KEY-----';

    protected $bank_cert = '-----BEGIN CERTIFICATE-----
MIICBjCCAW+gAwIBAgIJAJ2L0PZ45zd5MA0GCSqGSIb3DQEBCwUAMBwxGjAYBgNV
BAMMEXRlc3QuY3EuY2l0aWNiYW5rMB4XDTE5MDMyNzA2MjczNloXDTIwMDMyNjA2
MjczNlowHDEaMBgGA1UEAwwRdGVzdC5jcS5jaXRpY2JhbmswgZ8wDQYJKoZIhvcN
AQEBBQADgY0AMIGJAoGBAOrM+c9sGmMoTlhwFaBV2ldrxXsHtRCVGzdY9sLGtWtb
Dhj7m/ajk5ht7TcwjtgVbmd3nDmML/Tg2bmXYTGTq3LWylIQQqAIvE8+KwxVQ/7a
Iz6WK3cdJSA84DMDs+6kQZDqcADJleb+kjFjYUa+uT96o8wS5/ZttnTA6+iWtk6d
AgMBAAGjUDBOMB0GA1UdDgQWBBSbpkxB4MFypcyQM5B+wrZQz8K72jAfBgNVHSME
GDAWgBSbpkxB4MFypcyQM5B+wrZQz8K72jAMBgNVHRMEBTADAQH/MA0GCSqGSIb3
DQEBCwUAA4GBABXViJaSUTNR/nyQruDS/ZWlkT75MtK7FqyXgfc4JNN3bfCqll7a
KGL+1PZLYVqAlOH7OOoziB5QUbPOaV2pquZZABokq7NbPdpPEGz8e7JwYziO8JrV
5shK5mzOK9A0KBM6tU29ynWjxDlTQB+5KTWM6yvjShn3jVy/IXoFPBjm
-----END CERTIFICATE-----';

    protected $bank_private = '-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAOrM+c9sGmMoTlhw
FaBV2ldrxXsHtRCVGzdY9sLGtWtbDhj7m/ajk5ht7TcwjtgVbmd3nDmML/Tg2bmX
YTGTq3LWylIQQqAIvE8+KwxVQ/7aIz6WK3cdJSA84DMDs+6kQZDqcADJleb+kjFj
YUa+uT96o8wS5/ZttnTA6+iWtk6dAgMBAAECgYEAjvyAbIZik1vqSgUHxnpB2tbw
jfmllBGZX103+GlV9aifrysaUVpP+ZWHzgIuGv0CHNREOO9cDP4Y2OKM98n7r2q6
TS2bE11VswqN6XTV8Y2SGlzb0TT8K6phmJTcL7/cjv2KVzHbQoFm7PUwLVBB+6aG
gHtN7eQPW+qrZ8QEsEECQQD+ZGQC0wVUKzC6r9SKj4QviilRE8KOnnkNp/INkN3M
VjIx90DmE+M1Fr+SDaY5d2UW6D/SU0y5LlKyk9QStoQlAkEA7EjizVqpUJWvEU+m
qrn68gFyQppG7c9Znhq3LTGLsT0IeLQkeoN2Tlq6izWrHUinKSEez3qS/D/70CDf
7w2bGQJAIXqy0tBUxjP88MTNMwMaQWtsbpgsJbrjcZGlwHVNS2QYrQy+RMlfQJBi
2+Th+HQnILGmHJcL5N8c0RW1dlUA5QJBAJgqFA1FTnZ7/uM6FU4rOSVysv+bVQQ/
HSqJb9+l4Z1Bfdwlvrw7PwwUt7+Az3KrYCNHlgztlgzms6cEFNJhQ7kCQQCY/6Ea
MiIYVKk3iiR0PUDI3yYYoQu2xo+5erwSmoaKghhdducZ0zDivbsGNwcH1KWMbf+H
WxBKvnPE78q+ZqeX
-----END PRIVATE KEY-----';

    protected function before(Request $request): JsonTable
    {
        $appid = $request->get('appid', '');
        if ('' == $appid) {
            return ErrCodeFacade::getJError(10);
        }
        $api = ApiCommunicantModel::where('ac_appid',$appid)->find();
        if(is_null($api)){
            return ErrCodeFacade::getJError(25,['name','开放平台配置信息']);
        }
        \logListenDebug('PlatformAcquirerApi', '前置中间件api信息', $api);

        $sgin = $request->get('sgin', '');
        //文档备注！接收数据类型是：TEXT-PALIN
        $input = $request->getInput();

        $appsecrt = $api->ac_appsecret??'';
        $selfPublicKey = $api->ac_self_public??'';
        //        $selfPrivateKey = $api->ac_self_private??'';
        //        $publicKey = $api->ac_communit_public??'';
        $privateKey = $api->ac_communit_private??'';
        $driver = $api->ac_driver??'citic';


        $public = $this->cert??'';
        $private = $api->private??'';
        $privatePwd = $api->identy_code??null;
        $driver = 'citic';

        $data = [
            'sign'=>md5($input),
            'content'=>$input
        ];
        $acquireDate = AcquirerFacade::store($driver)
            ->readPushMess( $data,  $public, $private, $privatePwd);
        $request->data($acquireDate);
        return  $this->jsonTable->success() ;
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
            $public = $this->cert??'';
            $private = $api->private??'';
            $privatePwd = $api->identy_code??null;
            $driver = 'zhongxin';
            $result = AcquirerFacade::store($driver)
                ->returnMess( $data,  $public, $private, $privatePwd);
            \logListenDebug('openplatform', '后置中间件加密完成', $data);
            $data = $result;
        }
        // 响应结果
        $response->data($data);
        //返回响应对象
        return $this->jsonTable->success();
    }
}
