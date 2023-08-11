<?php

declare(strict_types=1);

namespace app\home\controller\v1;

use alocms\util\JsonTable;
use app\common\logic\FileStorage as FSLogic;
use app\common\logic\Session as SessionLogic;
use app\home\controller\Base as BaseController;

/**
 * 文件接口
 */
class File extends BaseController
{

    protected function doSave(): JsonTable
    {
        $user = $this->sessionLogic->getUser();
        $appType = $this->sessionLogic->getAppType();
        $group = $this->request->post('group', 'public'); //字段名称
        return FSLogic::instance()->fileUpload($group, $appType, $user);
    }



    public function read($id)
    {
        $appType = SessionLogic::instance()->getAppType();
        $dataId = $this->request->get('dataid', 0); //数据id
        $table = $this->request->get('table', ''); //表名称
        $field = $this->request->get('field', ''); //字段名称
        $user = $this->sessionLogic->getUser();
        $jResult  =  FSLogic::instance()->getFile(intval($id),  $dataId,  $table,  $field,  $appType,  $user);
        //        if ($jResult->isSuccess())
        //        {
        //            return response($jResult->data)->header(['content-type'=>$jResult->msg]);
        //        }else{
        return $this->jecho($jResult);
        //        }
    }


    public function local_read()
    {
        $path = $this->request->get('path', '');
        $realPath = '';
        if ('' !== $path) {
            $realPath = base64_decode(urldecode($path));
        }
        $isBase64 = $this->request->get('base64', false);
        $jResult  =  FSLogic::instance()->getFileContentByDriver('local', $realPath, $isBase64);
        $content = $isBase64 ? base64_decode($jResult->msg) : $jResult->msg;
        if ($jResult->isSuccess()) {
            $contentType = $jResult->msg;
            return response($content, 200, ['Content-Length' => strlen($content)])->contentType($contentType);
        }
        return $this->jecho($jResult);
    }
}
