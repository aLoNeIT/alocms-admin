<?php
declare (strict_types = 1);

namespace app\middleware\privilege;

use app\common\facade\ErrCode;
use app\common\Request;
use app\common\util\JsonTable;
use app\middleware\Base;

/**
 * 内部平台中间件，主要用于白名单信息校验
 * @author 王阮强 <wangruanqiang@youzhibo.cn>
 * @date 2020-10-15
 */
class InnerPlatform extends Base
{
    protected function before(Request $request):JsonTable
    {
        //读取配置文件白名单
        $whiteList = config('internal.white_list');
        //判断客户端ip是否白名单
        $clientIP = $request->ip();
        foreach ($whiteList as $rule) {
            if ($this->checkIP($clientIP, $rule)) {
                return $this->jsonTable->success();
            }
        }
        // 未匹配到白名单
        \logListenError('inner_platform', 'middleware before', [
            'client_ip' => $clientIP,
        ]);
        return ErrCode::getJError(2002);
    }

    /**
     * 检测ip是否白名单
     *
     * @param string $ip 客户端ip
     * @param string $rule 白名单规则
     * @return bool
     */
    protected function checkIP(string $ip, string $rule): bool
    {
        // 将.*临时替换成别的符号(.和*都是正则中有特殊含义的符号
        $rule_regexp = str_replace('.*', 'tmp', $rule);
        // 向规则字符串中增加转移，避免字符串中有其他特殊字符印象正则匹配
        // 非必要语句本例可以忽略
        $rule_regexp = preg_quote($rule_regexp, '/');
        // 将临时符号替换成正则表达式
        $rule_regexp = str_replace('tmp', '\.\d{1,3}', $rule_regexp);
        // 返回匹配结果
        return 1 == \preg_match('/^' . $rule_regexp . '$/', $ip);
    }
}
