<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/3
 * Time: 9:27
 */

namespace app\modules\web\model\process;

use app\models\db\EInstructorvideo;
use app\models\db\EInstructorbook;

class InstructorProcess
{
    function __construct()
    {
    }
    function __destruct()
    {
    }
    /**
     * 有效字段过滤（过滤有效的字段列表）
     *
     * @param array[] $inputFields	输入的字段列表
     * @param array[] $defFields 数据库字段列表
     * @return array[] 过滤后的字段列表
     */
    private function filterInputFields($inputFields,$defFields)
    {
        return array_intersect_key($inputFields,$defFields);
    }

    /*
     * 添加-著作
     * */
    public static function addbook($id,$params)
    {
        //添加著作
        $book = [];
        foreach($params['sBookName'] as $k => $r)
        {
            $book[$k]['sBookName'] = $r;
            $book[$k]['sBookImg'] = $params['sBookImg'][$k];
            $book[$k]['tid'] = $id;
        }
        if(!empty($book))
        {
            $id = EInstructorbook::insertInstructorBook($book);
            if(!$id)
            {
                return false;
            }
        }
        return true;
    }
    /**
     * 编辑-著作
     */
    public static function editbook($id,$params)
    {
        //获取所有著作
        $instructorbook = EInstructorbook::find()->where(['tid' => $id])->all();
        if($instructorbook)
        {
            foreach($instructorbook as $v){
                $ids[] = $v['id'];
            }

            $book = $bookid = [];

        }

        $i = 0;
        foreach($params['sBookName'] as $k => $r)
        {
            if(!empty($params['id'][$k]))
            {
                //要修改的著作
                $bookid[] = $params['id'][$k];
                if(false == EInstructorbook::updateEInstructorbook(['id'=>$params['id'][$k],'sBookName'=>$r,'sBookImg'=>$params['sBookImg'][$k],'tid'=>$id])){
                    return false;
                }
            }else{
                //要添加的著作
                $book[$i]['sBookName'] = $r;
                $book[$i]['sBookImg'] = $params['sBookImg'][$k];
                $book[$i++]['tid'] = $id;
            }
        }

        if(!empty($book))
        {
            //批量添加
            $id = EInstructorbook::insertInstructorBook($book);
            if(!$id)
            {
                return false;
            }
        }

        if(!empty($ids))
        {
            $diffB = @array_diff($ids, $bookid); //删除
            foreach($diffB as $m)
            {
                $customer = EInstructorbook::findOne($m);
                if(!$customer)
                {
                    return false;
                }
                if(!$customer->delete())
                {
                    return false;
                }
            }
        }

        return true;
    }
    /*
     * 添加-视频
     * */
    public static function addvideo($id,$params)
    {
        //添加视频
        $video = [];
        foreach($params['sTrainUrl'] as $k => $i)
        {
            $video[$k]['sTrainUrl'] = $i;
            $video[$k]['sOpusInfo'] = $params['sOpusInfo'][$k];
            $video[$k]['tid'] = $id;
        }
        if(!empty($video))
        {
            $id = EInstructorvideo::insertInstructorVideo($video);
            if(!$id)
            {
                return false;
            }
        }
        return true;
    }
    /*
     * 编辑-视频
     * */
    public static function editvideo($id,$params)
    {
        //获取所有视频
        $instructorvedio = EInstructorvideo::find()->where(['tid' => $id])->all();
        if($instructorvedio)
        {
            foreach($instructorvedio as $v){
                $ids[] = $v['id'];
            }

            $video = $videoid  = [];

        }

        $i = 0;
        foreach($params['sTrainUrl'] as $k => $r)
        {
            if(!empty($params['id'][$k]))
            {
                //要修改的视频
                $videoid[] = $params['id'][$k];
                if(false == EInstructorvideo::updateEInstructorvideo(['id'=>$params['id'][$k],'sTrainUrl'=>$r,'sOpusInfo'=>$params['sOpusInfo'][$k],'tid'=>$id])){
                    return false;
                }
            }else{
                //要添加的视频
                $video[$k]['sTrainUrl'] = $r;
                $video[$k]['sOpusInfo'] = $params['sOpusInfo'][$k];
                $video[$k]['tid'] = $id;
            }
        }

        if(!empty($video))
        {
            $id = EInstructorvideo::insertInstructorVideo($video);
            if(!$id)
            {
                return false;
            }
        }

        if(!empty($ids))
        {
            $diffB = @array_diff($ids, $videoid); //删除
            foreach($diffB as $m)
            {
                $customer = EInstructorvideo::findOne($m);
                if(!$customer)
                {
                    return false;
                }
                if(!$customer->delete())
                {
                    return false;
                }
            }
        }

        return true;
    }

}