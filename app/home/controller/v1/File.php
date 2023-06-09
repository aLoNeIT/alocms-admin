<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020年11月17日 0017
 * Time: 15:45:25
 */

namespace app\home\controller\v1;

use app\common\logic\FileStorage as FSLogic;
use app\common\util\JsonTable;
use app\home\controller\Base as BaseController;
use app\common\logic\Session as SessionLogic;

/**
 * 文件
 * Class FeeType
 * @package app\medical\controller\v1
 */
class File extends BaseController
{
    public function initialize()
    {

        parent::initialize();
    }

    protected function doSave(): JsonTable
    {
        $user = $this->sessionLogic->getUser();
        $appType = $this->sessionLogic->getAppType();
        $group = $this->request->post('group', 'public'); //字段名称
        return FSLogic::instance()->fileUpload($group, $appType, $user);
    }


    /**
     * 输出图片
     *
     * User: bimo
     * Date: 2020/12/21 18:51
     *
     * @param $id
     * @throws \app\common\util\YzbException
     */
    public function read($id)
    {
        $appType = SessionLogic::instance()->getAppType();
        $dataId = $this->request->get('dataid',0);//数据id
        $table = $this->request->get('table','');//表名称
        $field = $this->request->get('field','');//字段名称
        $user = $this->sessionLogic->getUser();
        $jResult  =  FSLogic::instance()->getFile( intval($id),  $dataId ,  $table,  $field ,  $appType,  $user );
//        if ($jResult->isSuccess())
//        {
//            return response($jResult->data)->header(['content-type'=>$jResult->msg]);
//        }else{
            return $this->jecho($jResult);
//        }
    }


    public function local_read()
    {
        $path = $this->request->get('path','');
        $realPath = '';
        if(''!==$path){
            $realPath = base64_decode(urldecode($path));
        }
        $isBase64 = $this->request->get('base64',false);
        $jResult  =  FSLogic::instance()->getFileContentByDriver(  'local', $realPath,$isBase64 );
        $content = $isBase64?base64_decode($jResult->msg):$jResult->msg;
        if($jResult->isSuccess()){
            $contentType = $jResult->msg;
            return response($content, 200, ['Content-Length' => strlen($content)])->contentType($contentType);
        }
        return $this->jecho($jResult);
    }




}