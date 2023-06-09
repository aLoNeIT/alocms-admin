<?php
declare (strict_types = 1);

namespace app\home\controller\v1;

use app\common\logic\WorkWeixin;
use app\home\controller\Base;


class WorkWx extends Base
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     *首頁
     * @return string
     */
    public function test()
    {
        $jPage = 'http%3A%2F%2Fdev.scrm.hongshanhealth.com%2Fhome%2Fv1%2Fauth_back';//回调地址
        $aType = 1; //测试状态
        return $this->jecho(WorkWeixin::instance()->getAuthUrl(1,'wwb8792761c1500e35',$jPage,$aType));
    }


    public function auth_back_read()
    {
        $authCode =   $this->request->get('auth_code','');
        $expresIn =   $this->request->get('expires_in/d',600);
        $stateHId =   $this->request->get('state','1');

        logListenDebug('授权回调','auth_back',['get'=> $this->request->get(),'post'=> $this->request->post()]);

        return $this->jecho( WorkWeixin::instance()->authBack( $authCode, $stateHId, $expresIn ));
    }


    public function customer_back_read()
    {
//        $authCode =   $this->request->get('auth_code','');
//        $expresIn =   $this->request->get('expires_in/d',600);
//        $stateHId =   $this->request->get('state','1');

        logListenDebug('授权回调','auth_back',['get'=> $this->request->get(),'post'=> $this->request->post()]);

//        return $this->jecho( WorkWeixin::instance()->authBack( $authCode, $stateHId, $expresIn ));
    }

}
