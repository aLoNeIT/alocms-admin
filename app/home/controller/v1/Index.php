<?php

declare(strict_types=1);

namespace app\home\controller\v1;

use app\home\controller\Base;
use sms\facade\Sms;
use think\facade\View;

/**
 * 首页接口
 */
class Index extends Base
{
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
}
