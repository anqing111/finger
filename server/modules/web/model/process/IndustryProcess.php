<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/3
 * Time: 9:27
 */

namespace app\modules\web\model\process;

use app\models\db\BIndustry;

class IndustryProcess
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
     * 添加-子类别
     * */
    public static function addchildindustry($id,$params)
    {
        //添加子类别
        $child = [];
        foreach($params['sIndustryName'] as $k => $r)
        {
            $child[$k]['sIndustryName'] = $r;
            $child[$k]['industryID'] = $id;
        }
        if(!empty($child))
        {
            $id = BIndustry::batchInsertIndustry($child);
            if(!$id)
            {
                return false;
            }
        }
        return true;
    }
    /**
     * 编辑-子类别
     */
    public static function editchildindustry($id,$params)
    {
        //获取所有子类别
        $bIndustry = BIndustry::find()->where(['industryID' => $id])->all();
        if($bIndustry)
        {
            foreach($bIndustry as $v){
                $ids[] = $v['id'];
            }

            $child = $childid = [];

        }

        $i = 0;
        foreach($params['sIndustryName'] as $k => $r)
        {
            if(!empty($params['id'][$k]))
            {
                //要修改的行业类别
                $childid[] = $params['id'][$k];
                if(false == BIndustry::updateIndustry(['id'=>$params['id'][$k],'sIndustryName'=>$r,'industryID'=>$id])){
                    return false;
                }
            }else{
                //要添加的行业类别
                $child[$i]['sIndustryName'] = $r;
                $child[$i++]['industryID'] = $id;
            }

        }

        if(!empty($child))
        {
            //批量添加
            $id = BIndustry::batchInsertIndustry($child);
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
                $customer = BIndustry::findOne($m);
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