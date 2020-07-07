<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/3
 * Time: 9:27
 */

namespace app\modules\web\model\process;

use app\models\db\BPositiontype;
use app\models\db\EPositiontype;

class PositionTypeProcess
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
     * 添加-子类职位类别
     * */
    public static function addchildpositiontype($id,$params)
    {
        /*
         * 添加子类职位类别
         * */

        /*$arr = [
            'sPositionName'=>'计算机科学与技术 ',
            'child'=>[
                [
                    'sPositionName'=>'软件工程',
                    'child'=>['sPositionName'=>['C语言','PHP']]
                ],
                [
                    'sPositionName'=>'计算机科学',
                    'child'=>['sPositionName'=>['计算机组成原理','Linux']]
                ]
            ]
        ];*/
        $book = [];
        foreach($params as $k => $r)
        {
            $iPositionID = BPositiontype::insertPositionType(['sPositionName'=>$r['sPositionName'],'iPositionID'=>$id]);

            if(!$iPositionID)
            {
                return false;
            }

            foreach($r['child']['sPositionName'] as $key => $c)
            {
                $book[$key]['sPositionName'] = $c;
                $book[$key]['iPositionID'] = $iPositionID;
            }

            if(!empty($book))
            {
                if(!EPositiontype::batchInsertPositionType($book))
                {
                    return false;
                }
            }
        }

        return true;
    }
    /**
     * 编辑-子类职位类别
     */
    public static function editchildpositiontype($id,$params)
    {
        //获取子类职位类别
        $position = BPositiontype::find()->where(['iPositionID' => $id])->all();
        if($position)
        {
            foreach($position as $v){
                $ids[] = $v['id'];
            }

            $bookid = [];
        }
        /*
         * $arr = [
         *  'id'=>1,
            'sIndustryName'=>'计算机科学与技术 ',
            'child'=>[
                [
                    'id'=>3,
                    'sIndustryName'=>'软件工程',
                    'child'=>['sIndustryName'=>['C语言','PHP'],'id'=>[1,2]]
                ],
                [
                    'id'=>0,
                    'sIndustryName'=>'计算机科学',
                    'child'=>['sIndustryName'=>['计算机组成原理','Linux'],'id'=>[3,4]]
                ]
            ]
        ];*/
        foreach($params as $k => $r)
        {
            if(!empty($r['id']))
            {
                //要修改的子类别
                $bookid[] = $r['id'];
                $cids = [];
                if(false == BPositiontype::updatePositionType(['id'=>$r['id'],'sPositionName'=>$r['sPositionName'],'iPositionID'=>$id])){
                    return false;
                }
                //获取三级子类职位类别
                $ePosition = EPositiontype::find()->where(['iPositionID' => $r['id']])->all();
                if($ePosition)
                {
                    foreach($ePosition as $cc){
                        $cids[] = $cc['id'];
                    }

                    $cbook = $cbookid = [];
                }
                $j = 0;
                foreach($r['child']['sPositionName'] as $key => $c)
                {
                    if(!empty($r['child']['id'][$key]))
                    {
                        //要修改的子类别
                        $cbookid[] = $r['child']['id'][$key];
                        if(false == EPositiontype::updatePositionType(['id'=>$r['child']['id'][$key],'sPositionName'=>$c,'iPositionID'=>$r['id']])){
                            return false;
                        }
                    }else{
                        //要添加的子类别
                        $cbook[$j]['sPositionName'] = $c;
                        $cbook[$j++]['iPositionID'] = $r['id'];
                    }
                }

                if(!empty($cbook))
                {
                    //批量添加
                    if(!EPositiontype::batchInsertPositionType($cbook))
                    {
                        return false;
                    }
                }

                if(!empty($cids))
                {
                    $diffB = @array_diff($cids, $cbookid); //删除
                    foreach($diffB as $mm)
                    {
                        $customer = EPositiontype::findOne($mm);
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

            }else{
                //要添加的子类别
                $iPositionID = BPositiontype::insertPositionType(['sPositionName'=>$r['sPositionName'],'iPositionID'=>$id]);

                if(!$iPositionID)
                {
                    return false;
                }

                foreach($r['child']['sPositionName'] as $key => $cc)
                {
                    $book[$key]['sPositionName'] = $cc;
                    $book[$key]['iPositionID'] = $iPositionID;
                }

                if(!empty($book))
                {
                    if(!EPositiontype::batchInsertPositionType($book))
                    {
                        return false;
                    }
                }
            }
        }

        if(!empty($ids))
        {
            $diffB = @array_diff($ids, $bookid); //删除
            foreach($diffB as $m)
            {
                $customer = BPositiontype::findOne($m);
                if(!$customer)
                {
                    return false;
                }
                if(!$customer->delete())
                {
                    return false;
                }
                //删除下面的三级子类别
                $model = EPositiontype::find()->where(['iPositionID'=>$m])->all();
                foreach($model as $t)
                {
                    $query = EPositiontype::findOne($t);
                    if(!$query)
                    {
                        return false;
                    }
                    if(!$query->delete())
                    {
                        return false;
                    }
                }
            }
        }

        return true;
    }

}