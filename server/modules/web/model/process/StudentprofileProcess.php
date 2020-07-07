<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/3
 * Time: 9:27
 */

namespace app\modules\web\model\process;

use app\models\db\EDefensevideo;
use app\models\db\EPracticevideo;
use app\models\db\EStudentopus;
use app\models\db\EStudentprofile;
use app\models\db\ETrainingvideo;

class StudentprofileProcess
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
     * 添加-作品秀
     * */
    public static function addchildstudentopus($id,$iUserID,$params)
    {
        //添加作品秀
        $child = [];
        foreach($params['sContent'] as $k => $r)
        {
            $child[$k]['iStuID'] = $id;
            $child[$k]['iResumeID'] = 0;
            $child[$k]['iUserID'] = $iUserID;
            $child[$k]['sContent'] = $r;
            $child[$k]['sOpusvideoUrl'] = $params['sOpusvideoUrl'][$k];

        }
        if(!empty($child))
        {
            $id = EStudentopus::batchInsertStudentopus($child);
            if(!$id)
            {
                return false;
            }
        }
        return true;
    }
    /**
     * 编辑-作品秀
     */
    public static function editchildstudentopus($id,$params)
    {
        //获取所有作品秀
        $eStudentopus = EStudentopus::find()->where(['iStuID' => $id])->all();
        if($eStudentopus)
        {
            foreach($eStudentopus as $v){
                $ids[] = $v['id'];
            }

            $child = $childid = [];

        }

        $i = 0;
        foreach($params['sContent'] as $k => $r)
        {
            if(!empty($params['id'][$k]))
            {
                //要修改的作品秀
                $childid[] = $params['id'][$k];
                if(false == EStudentopus::updateStudentpus(['id'=>$params['id'][$k],'sContent'=>$r,'sOpusvideoUrl'=>$params['sOpusvideoUrl'][$k]])){
                    return false;
                }
            }else{
                //要添加的作品秀
                $child[$k]['iStuID'] = $id;
                $child[$k]['iResumeID'] = 0;
                $child[$k]['iUserID'] = $eStudentopus[0]['iUserID'];
                $child[$i]['sContent'] = $r;
                $child[$i]['isRec'] = $eStudentopus[0]['isRec'];
                $child[$i++]['sOpusvideoUrl'] = $params['sOpusvideoUrl'][$k];
            }

        }

        if(!empty($child))
        {
            //批量添加
            $id = EStudentopus::batchInsertStudentopus($child);
            if(!$id)
            {
                return false;
            }
        }

        if(!empty($ids))
        {
            $diffB = @array_diff($ids, $childid); //删除
            foreach($diffB as $m)
            {
                $customer = EStudentopus::findOne($m);
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
     * 添加-培训视频
     * */
    public static function addchildtrainingvideo($id,$iUserID,$params)
    {
        //添加培训视频
        $child = [];
        foreach($params['sChapterName'] as $k => $r)
        {
            $child[$k]['cid'] = $params['cid'][$k];
            $child[$k]['bid'] = $params['bid'][$k];
            $child[$k]['sid'] = $id;
            $child[$k]['iUserID'] = $iUserID;
            $child[$k]['sChapterName'] = $r;
            $child[$k]['sTrainingvideoUrl'] = $params['sTrainingvideoUrl'][$k];
            $child[$k]['author'] = $params['author'][$k];
            $child[$k]['time'] = $params['time'][$k];
        }
        if(!empty($child))
        {
            $id = ETrainingvideo::batchInsertTrainingvideo($child);
            if(!$id)
            {
                return false;
            }
        }
        return true;
    }
    /**
     * 编辑-培训视频
     */
    public static function editchildtrainingvideo($id,$params)
    {
        //获取所有培训视频
        $eTrainingvideo = ETrainingvideo::find()->where(['sid' => $id])->all();
        if($eTrainingvideo)
        {
            foreach($eTrainingvideo as $v){
                $ids[] = $v['id'];
            }

            $child = $childid = [];

        }

        $i = 0;
        foreach($params['sChapterName'] as $k => $r)
        {
            if(!empty($params['id'][$k]))
            {
                //要修改的培训视频
                $childid[] = $params['id'][$k];
                if(false == ETrainingvideo::updateTrainingvideo([
                        'id'=>$params['id'][$k],
                        'sChapterName'=>$r,
                        'cid'=>$params['cid'][$k],
                        'bid'=>$params['bid'][$k],
                        'sTrainingvideoUrl'=>$params['sTrainingvideoUrl'][$k],
                        'author'=>$params['author'][$k],
                        'time'=>$params['time'][$k]
                    ])){
                    return false;
                }
            }else{
                //要添加的培训视频
                $child[$i]['cid'] = $params['cid'][$k];
                $child[$i]['bid'] = $params['bid'][$k];
                $child[$i]['sid'] = $id;
                $child[$i]['iUserID'] = $eTrainingvideo[0]['iUserID'];
                $child[$i]['sChapterName'] = $r;
                $child[$i]['sTrainingvideoUrl'] = $params['sTrainingvideoUrl'][$k];
                $child[$i]['author'] = $params['author'][$k];
                $child[$i++]['time'] = $params['time'][$k];
            }

        }

        if(!empty($child))
        {
            //批量添加
            $id = ETrainingvideo::batchInsertTrainingvideo($child);
            if(!$id)
            {
                return false;
            }
        }

        if(!empty($ids))
        {
            $diffB = @array_diff($ids, $childid); //删除
            foreach($diffB as $m)
            {
                $customer = ETrainingvideo::findOne($m);
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
     * 添加-实操视频
     * */
    public static function addchildpracticevideo($id,$iUserID,$params)
    {
        //添加实操视频
        $child = [];
        foreach($params['sProblemName'] as $k => $r)
        {
            $child[$k]['pid'] = $params['bid'][$k];
            $child[$k]['sid'] = $id;
            $child[$k]['iUserID'] = $iUserID;
            $child[$k]['sProblemName'] = $r;
            $child[$k]['sPracticevideoUrl'] = $params['sPracticevideoUrl'][$k];
            $child[$k]['author'] = $params['author'][$k];
            $child[$k]['time'] = $params['time'][$k];
        }
        if(!empty($child))
        {
            $id = EPracticevideo::batchInsertPracticevideo($child);
            if(!$id)
            {
                return false;
            }
        }
        return true;
    }
    /**
     * 编辑-实操视频
     */
    public static function editchildpracticevideo($id,$params)
    {
        //获取所有实操视频
        $ePracticevideo = EPracticevideo::find()->where(['sid' => $id])->all();
        if($ePracticevideo)
        {
            foreach($ePracticevideo as $v){
                $ids[] = $v['id'];
            }

            $child = $childid = [];

        }

        $i = 0;
        foreach($params['sProblemName'] as $k => $r)
        {
            if(!empty($params['id'][$k]))
            {
                //要修改的实操视频
                $childid[] = $params['id'][$k];
                if(false == EPracticevideo::updatePracticevideo([
                        'id'=>$params['id'][$k],
                        'sProblemName'=>$r,
                        'pid'=>$params['pid'][$k],
                        'sPracticevideoUrl'=>$params['sPracticevideoUrl'][$k],
                        'author'=>$params['author'][$k],
                        'time'=>$params['time'][$k]
                    ])){
                    return false;
                }
            }else{
                //要添加的培训视频
                $child[$i]['pid'] = $params['pid'][$k];
                $child[$i]['sid'] = $id;
                $child[$i]['iUserID'] = $ePracticevideo[0]['iUserID'];
                $child[$i]['sProblemName'] = $r;
                $child[$i]['sPracticevideoUrl'] = $params['sPracticevideoUrl'][$k];
                $child[$i]['author'] = $params['author'][$k];
                $child[$i++]['time'] = $params['time'][$k];
            }

        }

        if(!empty($child))
        {
            //批量添加
            $id = EPracticevideo::batchInsertPracticevideo($child);
            if(!$id)
            {
                return false;
            }
        }

        if(!empty($ids))
        {
            $diffB = @array_diff($ids, $childid); //删除
            foreach($diffB as $m)
            {
                $customer = EPracticevideo::findOne($m);
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
     * 添加-答辩视频
     * */
    public static function addchilddefensevideo($id,$iUserID,$params)
    {
        //添加答辩视频
        $child = [];
        foreach($params['sProblemName'] as $k => $r)
        {
            $child[$k]['pid'] = $params['bid'][$k];
            $child[$k]['sid'] = $id;
            $child[$k]['iUserID'] = $iUserID;
            $child[$k]['sProblemName'] = $r;
            $child[$k]['sDefensevideoUrl'] = $params['sDefensevideoUrl'][$k];
            $child[$k]['author'] = $params['author'][$k];
            $child[$k]['time'] = $params['time'][$k];
        }
        if(!empty($child))
        {
            $id = EDefensevideo::batchInsertDefensevideo($child);
            if(!$id)
            {
                return false;
            }
        }
        return true;
    }
    /**
     * 编辑-答辩视频
     */
    public static function editchilddefensevideo($id,$params)
    {
        //获取所有答辩视频
        $eDefensevideo = EDefensevideo::find()->where(['sid' => $id])->all();
        if($eDefensevideo)
        {
            foreach($eDefensevideo as $v){
                $ids[] = $v['id'];
            }

            $child = $childid = [];

        }

        $i = 0;
        foreach($params['sProblemName'] as $k => $r)
        {
            if(!empty($params['id'][$k]))
            {
                //要修改的实操视频
                $childid[] = $params['id'][$k];
                if(false == EDefensevideo::updateDefensevideo([
                        'id'=>$params['id'][$k],
                        'sProblemName'=>$r,
                        'pid'=>$params['pid'][$k],
                        'sDefensevideoUrl'=>$params['sDefensevideoUrl'][$k],
                        'author'=>$params['author'][$k],
                        'time'=>$params['time'][$k]
                    ])){
                    return false;
                }
            }else{
                //要添加的培训视频
                $child[$i]['pid'] = $params['pid'][$k];
                $child[$i]['sid'] = $id;
                $child[$i]['iUserID'] = $eDefensevideo[0]['iUserID'];
                $child[$i]['sProblemName'] = $r;
                $child[$i]['sDefensevideoUrl'] = $params['sDefensevideoUrl'][$k];
                $child[$i]['author'] = $params['author'][$k];
                $child[$i++]['time'] = $params['time'][$k];
            }

        }

        if(!empty($child))
        {
            //批量添加
            $id = EDefensevideo::batchInsertDefensevideo($child);
            if(!$id)
            {
                return false;
            }
        }

        if(!empty($ids))
        {
            $diffB = @array_diff($ids, $childid); //删除
            foreach($diffB as $m)
            {
                $customer = EDefensevideo::findOne($m);
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