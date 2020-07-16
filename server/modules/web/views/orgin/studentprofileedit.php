<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    h1{
        font-size: 20px;padding: 1rem;font-weight: 900;
    }
    .layui-form-label{
        width: 12rem;
    }
</style>
<body>
<div class="x-body">
    <h1>基本信息：</h1>
    <form class="layui-form" method="post" action="">
        <input type="hidden" value="<?=$profile['id'] ?? '' ?>" name="id">

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">姓  名：</label>
            <div class="layui-input-inline">
                <select id="iUserID" name="iUserID" lay-filter="iUserID" lay-verify="required">
                    <option value = 0 >选择学员</option>
                    <?php foreach($user as $kc => $pre){?>
                        <option value = <?=$pre['iUserID']?> <?=isset($profile['iUserID']) && $profile['iUserID'] == $pre['iUserID'] ? 'selected' : ''?> ><?=$pre['sNick']?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_remarks" class="layui-form-label">作品秀：</label>
            <div id="studentopus" class="layui-input-inline" style="border: 1px solid #e2e2e2;width: 50%">
                <br>
                <xblock style="background-color:#fff;text-align: right"><button type="button" class="layui-btn" data-title="添加" onclick="insertClass()"><i class="layui-icon"></i>添加</button></xblock>
                <?php if(!empty($profile['studentopus'])){?>
                    <?php foreach($profile['studentopus'] as $k1 => $r1){?>
                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">作品介绍：</label>
                            <div class="layui-input-inline" style="width: 80%">
                                <input type="hidden" value="<?=$r1['iStuID']?>" name="studentopus[iStuID][<?=$k1?>]">
                                <textarea name="studentopus[sContent][<?=$k1?>]" id="" cols="75" rows="10" lay-verify="required"><?=$r1['sContent']?></textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">视  频：</label>
                            <div class="layui-input-inline" style="width: 80%">
                                <input type="hidden" name="UploadForm[videoFile]" value="">
                                <input type="hidden" name="studentopus[sOpusvideoUrl][<?=$k1?>]" value="<?=$r1['sOpusvideoUrl']?>" class="sOpusvideoUrl<?=$k1?>">
                                <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'studentopus',<?=$k1?>)">
                                <span class="studentopuss<?=$k1?>"><?=$r1['sOpusvideoUrl']?></span>
                                <?php if($k1 > 0){?>
                                    <button type="button" class="layui-btn" data-title="删除" onclick="deleteClass(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>
                                <?php }?>
                            </div>
                        </div>
                    <?php }?>
                <?php }else{?>
                    <div class="layui-form-item">
                        <label for="L_phone" class="layui-form-label">作品介绍：</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <input type="hidden" value="" name="studentopus[iStuID][0]">
                            <textarea name="studentopus[sContent][0]" id="" cols="75" rows="10" lay-verify="required"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_phone" class="layui-form-label">视  频：</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <input type="hidden" name="UploadForm[videoFile]" value="">
                            <input type="hidden" name="studentopus[sOpusvideoUrl][0]" value="" class="sOpusvideoUrl0">
                            <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'studentopus',0)">
                            <span class="studentopuss0" style="display:none"></span>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">辅导员背书：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[imageFile]" value="">
                <input type="hidden" name="sInstructorEndorsementImg" value="<?=$profile['sInstructorEndorsementImg'] ?? ''?>">
                <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'sInstructorEndorsementImg',0)">
                <?php if(!empty($profile['sInstructorEndorsementImg'])){?>
                    <img src="<?=Yii::$app->params['imagePath'].$profile['sInstructorEndorsementImg']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;" class="sInstructorEndorsementImg">
                <?php }else{?>
                    <img src="" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;display: none" class="sInstructorEndorsementImg">
                <?php }?>

            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">同学背书：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[imageFile]" value="">
                <input type="hidden" name="sStudentEndorsementImg" value="<?=$profile['sStudentEndorsementImg'] ?? ''?>">
                <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'sStudentEndorsementImg',0)">
                <?php if(!empty($profile['sStudentEndorsementImg'])){?>
                    <img src="<?=Yii::$app->params['imagePath'].$profile['sStudentEndorsementImg']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;" class="sStudentEndorsementImg">
                <?php }else{?>
                    <img src="" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;display: none" class="sStudentEndorsementImg">
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_phone" class="layui-form-label">课堂笔记：</label>
            <div class="layui-input-inline" style="width: 80%">
                <input type="hidden" name="UploadForm[imageFile]" value="">
                <input type="hidden" name="sClassNotesImg" value="<?=$profile['sClassNotesImg'] ?? ''?>">
                <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'sClassNotesImg',0)">
                <?php if(!empty($profile['sClassNotesImg'])){?>
                    <img src="<?=Yii::$app->params['imagePath'].$profile['sClassNotesImg']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;" class="sClassNotesImg">
                <?php }else{?>
                    <img src="" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;display: none" class="sClassNotesImg">
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_remarks" class="layui-form-label">培训视频：</label>
            <div id="trainingvideo" class="layui-input-inline" style="border: 1px solid #e2e2e2;width: 50%">
                <br>
                <xblock style="background-color:#fff;text-align: right"><button type="button" class="layui-btn" data-title="添加" onclick="insertClassVideo()"><i class="layui-icon"></i>添加</button></xblock>
                <?php if(!empty($profile['trainingvideo'])){?>
                    <?php foreach($profile['trainingvideo'] as $k2 => $r2){
                        //获取该课程下所有章节目录
                        $list = \app\models\db\BTrainingvideo::find()->where(['cid'=>$r2['cid']])->all();
                        ?>
                        <div>
                            <div class="layui-form-item">
                                <label for="L_username" class="layui-form-label">选择课程：</label>
                                <div class="layui-input-inline">
                                    <select id="trainingvideo[cid][<?=$k2?>]" name="trainingvideo[cid][<?=$k2?>]" lay-filter="course" lay-verify="required" data-value="<?=$k2?>">
                                        <option value = 0 >选择课程</option>
                                        <?php foreach($course as $kc => $pre){?>
                                            <option value = <?=$pre->id?> <?=isset($r2['cid']) && $r2['cid'] == $pre->id ? 'selected' : ''?> ><?=$pre->sCourseName?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label for="L_username" class="layui-form-label">选择章节目录：</label>
                                <input type="hidden" name="trainingvideo[sChapterName][<?=$k2?>]" value="<?=$r2['sChapterName'] ?? ''?>" class="sChapterName<?=$k2?>">
                                <div class="layui-input-inline">
                                    <select id="trainingvideo_bid_<?=$k2?>" name="trainingvideo[bid][<?=$k2?>]" lay-filter="video" lay-verify="required" data-value="<?=$k2?>">
                                        <option value = 0>选择章节目录</option>
                                        <?php if(!empty($list)){?>
                                            <?php foreach($list as $ko => $ol){?>
                                                <option value = <?=$ol->id?> <?=isset($r2['bid']) && $r2['bid'] == $ol->id ? 'selected' : ''?> ><?=$ol->sChapterName?></option>
                                            <?php }?>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label for="L_mail" class="layui-form-label">讲  师：</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="trainingvideo[author][<?=$k2?>]" value="<?=$r2['author'] ?? ''?>"  name="trainingvideo[author][<?=$k2?>]" autocomplete="off" class="layui-input" maxlength="50">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">课  时：</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="trainingvideo[time][<?=$k2?>]" value="<?=$r2['time'] ?? ''?>"  name="trainingvideo[time][<?=$k2?>]" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">视  频：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" name="UploadForm[videoFile]" value="">
                                    <input type="hidden" name="trainingvideo[sTrainingvideoUrl][<?=$k2?>]" value="<?=$r2['sTrainingvideoUrl'] ?? '' ?>" class="sTrainingvideoUrl<?$k2?>">
                                    <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'trainingvideo',<?=$k2?>)">
                                    <span class="trainingvideos<?=$k2?>"><?=$r2['sTrainingvideoUrl'] ?? '' ?></span>
                                    <?php if($k2 > 0){?>
                                        <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                <?php }else{?>
                    <div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">选择课程：</label>
                            <div class="layui-input-inline">
                                <select id="trainingvideo[cid][0]" name="trainingvideo[cid][0]" lay-filter="course" lay-verify="required" data-value = 0>
                                    <option value = 0 >选择课程</option>
                                    <?php foreach($course as $kc => $pre){?>
                                        <option value = <?=$pre->id?> ><?=$pre->sCourseName?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">选择章节目录：</label>
                            <input type="hidden" name="trainingvideo[sChapterName][0]" value="" class="sChapterName0">
                            <div class="layui-input-inline">
                                <select id="trainingvideo_bid_0" name="trainingvideo[bid][0]" lay-filter="video" lay-verify="required" data-value="0">
                                    <option value = 0>选择章节目录</option>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_mail" class="layui-form-label">讲  师：</label>
                            <div class="layui-input-inline">
                                <input type="text" id="trainingvideo[author][0]" value=""  name="trainingvideo[author][0]" autocomplete="off" class="layui-input" maxlength="50">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">课  时：</label>
                            <div class="layui-input-inline">
                                <input type="text" id="trainingvideo[time][0]" value=""  name="trainingvideo[time][0]" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">视  频：</label>
                            <div class="layui-input-inline" style="width: 80%">
                                <input type="hidden" name="UploadForm[videoFile]" value="">
                                <input type="hidden" name="trainingvideo[sTrainingvideoUrl][0]" value="" class="sTrainingvideoUrl0">
                                <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'trainingvideo',0)">
                                <span class="trainingvideos0"></span>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_remarks" class="layui-form-label">实操视频：</label>
            <div id="practicevideo" class="layui-input-inline" style="border: 1px solid #e2e2e2;width: 50%">
                <br>
                <xblock style="background-color:#fff;text-align: right"><button type="button" class="layui-btn" data-title="添加" onclick="insertClassDVideo()"><i class="layui-icon"></i>添加</button></xblock>
                <?php if(!empty($profile['practicevideo'])){?>
                    <?php foreach($profile['practicevideo'] as $k3 => $r3){?>
                        <div>
                            <div class="layui-form-item">
                                <label for="L_username" class="layui-form-label">选择题目：</label>
                                <input type="hidden" name="practicevideo[sProblemName][<?=$k3?>]" value="<?=$r3['sProblemName'] ?? ''?>" class="sProblemName<?=$k3?>">
                                <div class="layui-input-inline">
                                    <select id="practicevideo[pid][<?=$k3?>]" name="practicevideo[pid][<?=$k3?>]" lay-filter="problem" lay-verify="required" data-value = <?=$k3?>>
                                        <option value = 0 >选择题目</option>
                                        <?php foreach($problem as $kc => $pre){?>
                                            <option value = <?=$pre->id?> <?=isset($r3['pid']) && $r3['pid'] == $pre->id ? 'selected' : ''?> ><?=$pre->sProblemName?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label for="L_mail" class="layui-form-label">讲  师：</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="practicevideo[author][<?=$k3?>]" value="<?=$r3['author'] ?? ''?>"  name="practicevideo[author][<?=$k3?>]" autocomplete="off" class="layui-input" maxlength="50">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">课  时：</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="practicevideo[time][<?=$k3?>]" value="<?=$r3['time'] ?? ''?>"  name="practicevideo[time][<?=$k3?>]" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">视  频：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" name="UploadForm[videoFile]" value="">
                                    <input type="hidden" name="practicevideo[sPracticevideoUrl][<?=$k3?>]" value="<?=$r3['sPracticevideoUrl'] ?? '' ?>" class="sPracticevideoUrl<?$k3?>">
                                    <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'practicevideo',<?=$k3?>)">
                                    <span class="practicevideos<?=$k3?>"><?=$r3['sPracticevideoUrl'] ?? '' ?></span>
                                    <?php if($k3 > 0){?>
                                        <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                <?php }else{?>
                    <div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">选择题目：</label>
                            <input type="hidden" name="practicevideo[sProblemName][0]" value="" class="sProblemName0">
                            <div class="layui-input-inline">
                                <select id="practicevideo[pid][0]" name="practicevideo[pid][0]" lay-filter="problem" lay-verify="required" data-value="0">
                                    <option value = 0 >选择题目</option>
                                    <?php foreach($problem as $kc => $pre){?>
                                        <option value = <?=$pre->id?> ><?=$pre->sProblemName?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_mail" class="layui-form-label">讲  师：</label>
                            <div class="layui-input-inline">
                                <input type="text" id="practicevideo[author][0]" value=""  name="practicevideo[author][0]" autocomplete="off" class="layui-input" maxlength="50">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">课  时：</label>
                            <div class="layui-input-inline">
                                <input type="text" id="practicevideo[time][0]" value=""  name="practicevideo[time][0]" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">视  频：</label>
                            <div class="layui-input-inline" style="width: 80%">
                                <input type="hidden" name="UploadForm[videoFile]" value="">
                                <input type="hidden" name="practicevideo[sPracticevideoUrl][0]" value="" class="sPracticevideoUrl0">
                                <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'practicevideo',0)">
                                <span class="practicevideos0"></span>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_remarks" class="layui-form-label">答辩视频：</label>
            <div id="defensevideo" class="layui-input-inline" style="border: 1px solid #e2e2e2;width: 50%">
                <br>
                <xblock style="background-color:#fff;text-align: right"><button type="button" class="layui-btn" data-title="添加" onclick="insertClassPVideo()"><i class="layui-icon"></i>添加</button></xblock>
                <?php if(!empty($profile['defensevideo'])){?>
                    <?php foreach($profile['defensevideo'] as $k4 => $r4){?>
                        <div>
                            <div class="layui-form-item">
                                <label for="L_username" class="layui-form-label">选择题目：</label>
                                <input type="hidden" name="defensevideo[sProblemName][<?=$k4?>]" value="<?=$r4['sProblemName'] ?? ''?>" class="sPProblemName<?=$k4?>">
                                <div class="layui-input-inline">
                                    <select id="defensevideo[pid][<?=$k4?>]" name="defensevideo[pid][<?=$k4?>]" lay-filter="pproblem" lay-verify="required" data-value=<?=$k4?>>
                                        <option value = 0 >选择题目</option>
                                        <?php foreach($problem as $kc => $pre){?>
                                            <option value = <?=$pre->id?> <?=isset($r4['pid']) && $r4['pid'] == $pre->id ? 'selected' : ''?> ><?=$pre->sProblemName?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label for="L_mail" class="layui-form-label">讲  师：</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="defensevideo[author][<?=$k4?>]" value="<?=$r4['author'] ?? ''?>"  name="defensevideo[author][<?=$k4?>]" autocomplete="off" class="layui-input" maxlength="50">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">课  时：</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="defensevideo[time][<?=$k4?>]" value="<?=$r4['time'] ?? ''?>"  name="defensevideo[time][<?=$k4?>]" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_phone" class="layui-form-label">视  频：</label>
                                <div class="layui-input-inline" style="width: 80%">
                                    <input type="hidden" name="UploadForm[videoFile]" value="">
                                    <input type="hidden" name="defensevideo[sDefensevideoUrl][<?=$k4?>]" value="<?=$r4['sDefensevideoUrl'] ?? '' ?>" class="sDefensevideoUrl<?$k4?>">
                                    <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'defensevideo',<?=$k4?>)">
                                    <span class="defensevideos<?=$k4?>"><?=$r4['sDefensevideoUrl'] ?? '' ?></span>
                                    <?php if($k4 > 0){?>
                                        <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                <?php }else{?>
                    <div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">选择题目：</label>
                            <input type="hidden" name="defensevideo[sProblemName][0]" value="" class="sPProblemName0">
                            <div class="layui-input-inline">
                                <select id="defensevideo[pid][0]" name="defensevideo[pid][0]" lay-filter="pproblem" lay-verify="required" data-value="0">
                                    <option value = 0 >选择题目</option>
                                    <?php foreach($problem as $kc => $pre){?>
                                        <option value = <?=$pre->id?> ><?=$pre->sProblemName?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_mail" class="layui-form-label">讲  师：</label>
                            <div class="layui-input-inline">
                                <input type="text" id="defensevideo[author][0]" value=""  name="defensevideo[author][0]" autocomplete="off" class="layui-input" maxlength="50">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">课  时：</label>
                            <div class="layui-input-inline">
                                <input type="text" id="defensevideo[time][0]" value=""  name="defensevideo[time][0]" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_phone" class="layui-form-label">视  频：</label>
                            <div class="layui-input-inline" style="width: 80%">
                                <input type="hidden" name="UploadForm[videoFile]" value="">
                                <input type="hidden" name="defensevideo[sDefensevideoUrl][0]" value="" class="sDefensevideoUrl0">
                                <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,'defensevideo',0)">
                                <span class="defensevideos0"></span>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">
            </label>
            <button lay-submit lay-filter="save" class="layui-btn" >提交</button>
        </div>
    </form>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        form.on('select(course)', function(data){
            var video = <?=\yii\helpers\Json::encode($video)?>;
            var index = $(data.elem).attr("data-value");
            var str = '<option value = 0>选择章节目录</option>';
            $(video).each(function (ids,items) {
                if(parseInt(items.cid) == parseInt(data.value))
                {
                    str += '<option value = '+items.id+'>'+items.sChapterName+'</option>';
                }
            });
            $('#trainingvideo_bid_'+index).html(str);
            form.render('select');
        });

        form.on('select(video)', function(data){
            var index = $(data.elem).attr("data-value");
            $('.sChapterName'+index).val(this.innerText);
            form.render('select');
        });

        form.on('select(problem)', function(data){
            var index = $(data.elem).attr("data-value");
            $('.sProblemName'+index).val(this.innerText);
            form.render('select');
        });

        form.on('select(pproblem)', function(data){
            var index = $(data.elem).attr("data-value");
            $('.sPProblemName'+index).val(this.innerText);
            form.render('select');
        });

        form.on('submit(save)', function(data){

            $.ajax({
                url:location.href,
                async: false,
                type:"POST",
                dataType: "text",
                data:data.field,
                success: function(data){
                    data = $.parseJSON( data );
                    if(data.code == 0){
                        layer.alert("编辑成功", {icon: 6}, function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                            parent.location.reload();
                        });
                    }else {
                        layer.msg(data.msg);
                    }
                }
            });
            return false;

        });
    });

    var bookindex = 0;
    function insertClass() {
        if(bookindex == 0 && $('#studentopus').find('.layui-form-item').length > 2)
        {
            var len = $('#studentopus').find('.layui-form-item').length / 2;
            bookindex = len - 1;
        }
        bookindex++;
        var str = '<div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">作品介绍：</label>\n' +
            '                        <div class="layui-input-inline" style="width: 80%">\n' +
            '                            <input type="hidden" value="" name="studentopus[iStuID]['+bookindex+']">\n' +
            '                            <textarea name="studentopus[sContent]['+bookindex+']" id="" cols="75" rows="10" lay-verify="required"></textarea>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">视  频：</label>\n' +
            '                        <div class="layui-input-inline" style="width: 80%">\n' +
            '                            <input type="hidden" name="UploadForm[videoFile]" value="">\n' +
            '                            <input type="hidden" name="studentopus[sOpusvideoUrl]['+bookindex+']" value="" class="sOpusvideoUrl0">\n' +
            '                            <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,\'studentopus\','+bookindex+')">\n' +
            '                            <span class="studentopuss'+bookindex+'" style="display:none"></span>\n' +
            '                            <button type="button" class="layui-btn" data-title="删除" onclick="deleteClass(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>'+
            '                        </div>\n' +
            '                    </div>';
        $("#studentopus").append(str);
    }

    function deleteClass(that) {
        $(that).parent().parent().prev('.layui-form-item').remove();
        $(that).parent().parent().remove();
    }

    var videoindex = 0;
    function insertClassVideo() {
        if(videoindex == 0 && $('#trainingvideo').find('.layui-form-item').length > 5)
        {
            var len = $('#trainingvideo').find('.layui-form-item').length / 5;
            videoindex = len - 1;
        }
        videoindex++;
        var str = '<div><div class="layui-form-item">\n' +
            '                        <label for="L_username" class="layui-form-label">选择课程：</label>\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <select id="trainingvideo[cid]['+videoindex+']" name="trainingvideo[cid]['+videoindex+']" lay-filter="course" lay-verify="required" data-value='+videoindex+'>\n' +
            '                                <option value = 0 >选择课程</option>\n' +
            '                                <?php foreach($course as $kc => $pre){?>\n' +
            '                                      <option value = <?=$pre->id?>><?=$pre->sCourseName?></option>\n' +
            '                                <?php }?>\n' +
            '                            </select>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_username" class="layui-form-label">选择章节目录：</label>\n' +
            '                        <input type="hidden" name="trainingvideo[sChapterName]['+videoindex+']" value="" class="sChapterName'+videoindex+'">\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <select id="trainingvideo_bid_'+videoindex+'" name="trainingvideo[bid]['+videoindex+']" lay-filter="video" lay-verify="required" data-value='+videoindex+'>\n' +
            '                                <option value = 0>选择章节目录</option>\n' +
            '                            </select>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_mail" class="layui-form-label">讲  师：</label>\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <input type="text" id="trainingvideo[author]['+videoindex+']" value=""  name="trainingvideo[author]['+videoindex+']" autocomplete="off" class="layui-input" maxlength="50">\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">课  时：</label>\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <input type="text" id="trainingvideo[time]['+videoindex+']" value=""  name="trainingvideo[time]['+videoindex+']" autocomplete="off" class="layui-input">\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">视  频：</label>\n' +
            '                        <div class="layui-input-inline" style="width: 80%">\n' +
            '                            <input type="hidden" name="UploadForm[videoFile]" value="">\n' +
            '                            <input type="hidden" name="trainingvideo[sTrainingvideoUrl]['+videoindex+']" value="" class="sTrainingvideoUrl'+videoindex+'" >\n' +
            '                            <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,\'trainingvideo\','+videoindex+')">\n' +
            '                            <span class="trainingvideos'+videoindex+'"></span>\n' +
            '                            <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>'+
            '                        </div>\n' +
            '                    </div></div>';
        $("#trainingvideo").append(str);
        layui.use(['form','layer'], function() {
            $ = layui.jquery;
            var form = layui.form
                , layer = layui.layer;
            form.render('select');
        });

    }

    var videoindex_D = 0;
    function insertClassDVideo() {
        if(videoindex_D == 0 && $('#practicevideo').find('.layui-form-item').length > 5)
        {
            var len = $('#practicevideo').find('.layui-form-item').length / 5;
            videoindex_D = len - 1;
        }
        videoindex_D++;
        var str = '<div><div class="layui-form-item">\n' +
            '                        <label for="L_username" class="layui-form-label">选择题目：</label>\n' +
            '                        <input type="hidden" name="practicevideo[sProblemName]['+videoindex_D+']" value="" class="sProblemName'+videoindex_D+'">\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <select id="practicevideo[pid]['+videoindex_D+']" name="practicevideo[pid]['+videoindex_D+']" lay-filter="problem" lay-verify="required" data-value='+videoindex_D+'>\n' +
            '                                <option value = 0 >选择题目</option>\n' +
            '                                <?php foreach($problem as $kc => $pre){?>\n' +
            '                                      <option value = <?=$pre->id?>><?=$pre->sProblemName?></option>\n' +
            '                                <?php }?>\n' +
            '                            </select>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_mail" class="layui-form-label">讲  师：</label>\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <input type="text" id="practicevideo[author]['+videoindex_D+']" value=""  name="practicevideo[author]['+videoindex_D+']" autocomplete="off" class="layui-input" maxlength="50">\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">课  时：</label>\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <input type="text" id="practicevideo[time]['+videoindex_D+']" value=""  name="practicevideo[time]['+videoindex_D+']" autocomplete="off" class="layui-input">\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">视  频：</label>\n' +
            '                        <div class="layui-input-inline" style="width: 80%">\n' +
            '                            <input type="hidden" name="UploadForm[videoFile]" value="">\n' +
            '                            <input type="hidden" name="practicevideo[sPracticevideoUrl]['+videoindex_D+']" value="" class="sPracticevideoUrl'+videoindex_D+'" >\n' +
            '                            <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,\'practicevideo\','+videoindex_D+')">\n' +
            '                            <span class="practicevideos'+videoindex_D+'"></span>\n' +
            '                            <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>'+
            '                        </div>\n' +
            '                    </div></div>';
        $("#practicevideo").append(str);
        layui.use(['form','layer'], function() {
            $ = layui.jquery;
            var form = layui.form
                , layer = layui.layer;
            form.render('select');
        });

    }

    var videoindex_P = 0;
    function insertClassPVideo() {
        if(videoindex_P == 0 && $('#defensevideo').find('.layui-form-item').length > 5)
        {
            var len = $('#defensevideo').find('.layui-form-item').length / 5;
            videoindex_P = len - 1;
        }
        videoindex_P++;
        var str = '<div><div class="layui-form-item">\n' +
            '                        <label for="L_username" class="layui-form-label">选择题目：</label>\n' +
            '                        <input type="hidden" name="defensevideo[sProblemName]['+videoindex_P+']" value="" class="sPProblemName'+videoindex_P+'">\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <select id="defensevideo[pid]['+videoindex_P+']" name="defensevideo[pid]['+videoindex_P+']" lay-filter="pproblem" lay-verify="required" data-value='+videoindex_P+'>\n' +
            '                                <option value = 0 >选择题目</option>\n' +
            '                                <?php foreach($problem as $kc => $pre){?>\n' +
            '                                      <option value = <?=$pre->id?>><?=$pre->sProblemName?></option>\n' +
            '                                <?php }?>\n' +
            '                            </select>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_mail" class="layui-form-label">讲  师：</label>\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <input type="text" id="defensevideo[author]['+videoindex_P+']" value=""  name="defensevideo[author]['+videoindex_P+']" autocomplete="off" class="layui-input" maxlength="50">\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">课  时：</label>\n' +
            '                        <div class="layui-input-inline">\n' +
            '                            <input type="text" id="defensevideo[time]['+videoindex_P+']" value=""  name="defensevideo[time]['+videoindex_P+']" autocomplete="off" class="layui-input">\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="layui-form-item">\n' +
            '                        <label for="L_phone" class="layui-form-label">视  频：</label>\n' +
            '                        <div class="layui-input-inline" style="width: 80%">\n' +
            '                            <input type="hidden" name="UploadForm[videoFile]" value="">\n' +
            '                            <input type="hidden" name="defensevideo[sDefensevideoUrl]['+videoindex_P+']" value="" class="sDefensevideoUrl'+videoindex_P+'" >\n' +
            '                            <input type="file" name="UploadForm[videoFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this,\'defensevideo\','+videoindex_P+')">\n' +
            '                            <span class="defensevideos'+videoindex_P+'"></span>\n' +
            '                            <button type="button" class="layui-btn" data-title="删除" onclick="deleteClassVideo(this)" style="margin-left: 1rem"><i class="layui-icon"></i>删除</button>'+
            '                        </div>\n' +
            '                    </div></div>';
        $("#defensevideo").append(str);
        layui.use(['form','layer'], function() {
            $ = layui.jquery;
            var form = layui.form
                , layer = layui.layer;
            form.render('select');
        });

    }

    function deleteClassVideo(that) {
        $(that).parent().parent().parent().remove();
    }

    function uploadFile(that,file,index)
    {
        var url = 'index.php?r=web/upload/video';
        var image = false;
        var video = '';
        switch (file) {
            case 'sInstructorEndorsementImg':
            case 'sStudentEndorsementImg':
            case 'sClassNotesImg':
                url = 'index.php?r=web/upload/upload';
                image = true;
                break;
            case 'studentopus':
                video = 'sOpusvideoUrl';
                break;
            case 'trainingvideo':
                video = 'sTrainingvideoUrl';
                break;
            case 'practicevideo':
                video = 'sPracticevideoUrl';
                break;
            case 'defensevideo':
                video = 'sDefensevideoUrl';
                break;
        }

        $(that).fileupload({
            dataType: 'json',
            url: url,
            success: function (json) {
                if(json.code == 0){
                    if(true == image)
                    {
                        $("input[name="+file+"]").val(json.data.url);
                        $("."+file).attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                        $("."+file).css('display','block');
                    }else{
                        $("."+video+index).val(json.data.url);
                        $("."+file+'s'+index).text(json.data.url);
                        $("."+file+'s'+index).css('display','block');
                    }
                }else{
                    layui.use(['layer'], function() {
                        $ = layui.jquery;
                        var layer = layui.layer;
                        layer.msg(json.msg);
                    });
                }
            }
        });
    }

</script>
<?php
$this->endContent();
?>
