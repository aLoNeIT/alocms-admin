<?php
declare (strict_types = 1);

namespace app\home\controller\v1;

use app\home\controller\Base;
use sms\facade\Sms;
use think\facade\View;

/**
 * 首页
 *
 * User: zhangpei <zhangpei@youzhibo.cn>
 * Date: 2021/3/29  17:57
 *
 * Class Index
 * @package app\home\controller\v1
 */
class Index extends Base
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     *首頁
     * @return string
     */
    public function index()
    {
        $baseUrl = config('system.base_url');
        View::assign('base_url', "{$baseUrl}");
        return view();
    }


    public function test()
    {
        $sms = Sms::store('qcloud');
        $sms->switchClient();
//        $r = $sms->addSmsTemplate( "名字",'您正在访问我们的网页','这个可能是个说明吧',1);
        $r = $sms->send('18792687613', '1652440' , '小融优福');
//                $r = $sms->querySmsTemplate( "SMS_257728118");
//        $r = $sms->query('18792687613');
        //        $r = $sms->send( '18792687613', 'SMS_154950909','阿里云短信测试',["code"=>"1234"]);
        dump($r);
//        $this->service = \workweixin\facade\WorkWeixin::store('provider_service');
//       $qa = $this->service->getProviderAccessToken();
//       dump($qa);
    }
}
