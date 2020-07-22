<?php
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
    h1{
        font-size: 20px;padding: 1rem;font-weight: 900;
    }
    h5{
        font-size: 14px;padding: 1rem;
    }
</style>
<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">学生档案信息详情</a>
      </span>
</div>
<div class="x-body">
    <h1>基础信息</h1>
    <?php if(!empty($profile)){?>
        <table class="layui-table">
            <thead>
            <th>姓名</th>
            <th>企业名称</th>
            <th>身份证号</th>
            <th>邮箱</th>
            <th>手机号</th>
            </thead>
            <tbody>
            <tr>
                <td><?=$profile['name']?></td>
                <td><?=$profile['sOrginName']?></td>
                <td><?=$profile['idcard']?></td>
                <td><?=$profile['sMail']?></td>
                <td><?=$profile['sPhone']?></td>
            </tr>

            </tbody>
        </table>
        <h1>作品展示</h1>
        <?php foreach($profile["studentopus"] as $k => $r){?>
            <table class="layui-table" style="width: 50%">
                <tbody>
                <tr>
                    <td style="width: 20%">
                        <div class="layui-container" style="width: 100%">
                            <div class="layui-row layui-col-space15 margin15">
                                <section class="layui-card">
                                    <div class="layui-card-body">
                                        <div class="sOpusvideoUrl" id="sOpusvideoUrl<?=$k?>" data-url="<?=Yii::$app->params['imagePath'].$r['sOpusvideoUrl']?>" style="width: 100%;"></div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </td>
                    <td style="width: 30%;text-align:left;vertical-align:top">
                        <p style="font-size: 14px;letter-spacing:2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$r['sContent']?></p>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php }?>
        <hr>
        <table class="layui-table" style="width: 50%">
            <head>
                <tr><th>辅导员背书</th><th>同学背书</th><th>课堂笔记</th></tr>
            </head>
            <tbody>
            <tr>
                <td><a href="<?=Yii::$app->params['imagePath'].$profile['sInstructorEndorsementImg']?>" target="_blank"><img src="<?=Yii::$app->params['imagePath'].$profile['sInstructorEndorsementImg']?>" alt=""></a></td>
                <td><a href="<?=Yii::$app->params['imagePath'].$profile['sStudentEndorsementImg']?>" target="_blank"><img src="<?=Yii::$app->params['imagePath'].$profile['sStudentEndorsementImg']?>" alt=""></a></td>
                <td><a href="<?=Yii::$app->params['imagePath'].$profile['sClassNotesImg']?>" target="_blank"><img src="<?=Yii::$app->params['imagePath'].$profile['sClassNotesImg']?>" alt=""></a></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>培训视频</h1>
        <table class="layui-table" style="width: 50%">
            <tbody>
            <tr>
                <?php foreach($profile["trainingvideo"] as $k1 => $r1){?>
                    <td style="width: 20%">
                        <table class="layui-table">
                            <tbody>
                            <tr><td>
                                    <div class="layui-container" style="width: 100%">
                                        <div class="layui-row layui-col-space15 margin15">
                                            <section class="layui-card">
                                                <div class="layui-card-body">
                                                    <div class="sTrainingvideoUrl" id="sTrainingvideoUrl<?=$k1?>" data-url="<?=Yii::$app->params['imagePath'].$r1['sTrainingvideoUrl']?>" style="width: 100%;"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </td></tr>
                            <tr>
                                <td>
                                    <h1><?=$r1['sChapterName']?></h1>
                                    <h5><?=$r1['author']?> <?=$r1['time']?>分钟</h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                <?php }?>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>答辩视频</h1>
        <table class="layui-table" style="width: 50%">
            <tbody>
            <tr>
                <?php foreach($profile["defensevideo"] as $k2 => $r2){?>
                    <td style="width: 20%">
                        <table class="layui-table">
                            <tbody>
                            <tr><td>
                                    <div class="layui-container" style="width: 100%">
                                        <div class="layui-row layui-col-space15 margin15">
                                            <section class="layui-card">
                                                <div class="layui-card-body">
                                                    <div class="sDefensevideoUrl" id="sDefensevideoUrl<?=$k2?>" data-url="<?=Yii::$app->params['imagePath'].$r2['sDefensevideoUrl']?>" style="width: 100%;"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </td></tr>
                            <tr>
                                <td>
                                    <h1><?=$r2['sProblemName']?></h1>
                                    <h5><?=$r2['author']?> <?=$r2['time']?>分钟</h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                <?php }?>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>实操视频</h1>
        <table class="layui-table" style="width: 50%">
            <tbody>
            <tr>
                <?php foreach($profile["practicevideo"] as $k2 => $r2){?>

                    <td style="width: 20%">
                        <table class="layui-table">
                            <tbody>
                            <tr><td>
                                    <div class="layui-container" style="width: 100%">
                                        <div class="layui-row layui-col-space15 margin15">
                                            <section class="layui-card">
                                                <div class="layui-card-body">
                                                    <div class="sPracticevideoUrl" id="sPracticevideoUrl<?=$k2?>" data-url="<?=Yii::$app->params['imagePath'].$r2['sPracticevideoUrl']?>" style="width: 100%;"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </td></tr>
                            <tr>
                                <td>
                                    <h1><?=$r2['sProblemName']?></h1>
                                    <h5><?=$r2['author']?> <?=$r2['time']?>分钟</h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                <?php }?>
            </tr>
            </tbody>
        </table>
        <hr>
        <h1>证书信息</h1>
        <form class="layui-form" method="post" action="">
            <input type="hidden" value="<?=$profile['id'] ?? '' ?>" name="id">
            <?php if(!empty($profile['sCertificateNum'])){?>
                <input type="hidden" value=1 name="edit">
            <?php }else{?>
                <input type="hidden" value=1 name="add">
            <?php }?>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">证书类别：</label>
                <div class="layui-input-inline">
                    <select id="cid" name="cid" lay-filter="cid" lay-verify="required">
                        <option value = 0 >证书类别</option>
                        <?php foreach($cate as $kc => $pre){?>
                            <option value = <?=$pre['id']?> <?=isset($profile['cid']) && $profile['cid'] == $pre['id'] ? 'selected' : ''?> ><?=$pre['subjectName']?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">证书名称：</label>
                <div class="layui-input-inline">
                    <input type="text" id="sName" value="<?=$profile['sName'] ?? ''?>"  name="sName" lay-verify="required" autocomplete="off" class="layui-input" maxlength="50">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">证书编号：</label>
                <div class="layui-input-inline">
                    <input type="text" id="sCertificateNum" value="<?=$profile['sCertificateNum'] ?? ''?>"  name="sCertificateNum" lay-verify="required" autocomplete="off" class="layui-input" maxlength="50">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_phone" class="layui-form-label">上传证书：</label>
                <div class="layui-input-inline" style="width: 80%">
                    <input type="hidden" name="UploadForm[imageFile]" value="">
                    <input type="hidden" name="sCertificateImg" value="<?=$profile['sCertificateImg'] ?? ''?>">
                    <input type="file" name="UploadForm[imageFile]" autocomplete="off" class="layui-input" style="float: left;width: 80%;border: none" onclick="uploadFile(this)">
                    <?php if(!empty($profile['sCertificateImg'])){?>
                        <img src="<?=Yii::$app->params['imagePath'].$profile['sCertificateImg']?>" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;" class="sCertificateImg">
                    <?php }else{?>
                        <img src="" alt="" style="margin-bottom: 10px;width: 24%;height: 200px;display: none" class="sCertificateImg">
                    <?php }?>

                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_phone" class="layui-form-label">获得时间：</label>
                <div class="layui-input-inline">
                    <input type="text" id="dGetDate" value="<?=$profile['dGetDate'] ?? ''?>"  name="dGetDate" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">证书简述：</label>
                <div class="layui-input-inline">
                    <input type="text" id="sContent" value="<?=$profile['sContent'] ?? ''?>"  name="sContent" lay-verify="required" autocomplete="off" class="layui-input" maxlength="50">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">快递公司名称：</label>
                <div class="layui-input-inline">
                    <input type="text" id="post_by" value="<?=$profile['post_by'] ?? ''?>"  name="post_by" autocomplete="off" class="layui-input" maxlength="20">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">快递单号：</label>
                <div class="layui-input-inline">
                    <input type="text" id="post_no" value="<?=$profile['post_no'] ?? ''?>"  name="post_no" autocomplete="off" class="layui-input" maxlength="20">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">
                </label>
                <button lay-submit lay-filter="save" class="layui-btn" >提交</button>
            </div>
        </form>
        <hr>
        <?php if($profile['status'] == \app\models\db\EStudentprofile::FILED){?>
            <div class="layui-form-item">
                <label for="L_mail" class="layui-form-label">审核未通过原因：</label>
                <div class="layui-input-inline">
                    <textarea name="cause" id="" cols="75" rows="10" lay-verify="required" readonly><?=$profile['cause'] ?? ''?></textarea>
                </div>
            </div>
        <?php }?>
    <?php }?>
</div>
</body>
<script type="text/javascript">
    // 日期插件
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        laydate.render({
            elem: '#dGetDate',
            type:"date"
            ,trigger: 'click'//呼出事件改成click
            ,value: '<?=$profile['dGetDate'] ?? $dBeginTime?>'
        });
    });
    layui.config({
        base: '/lib/'
    }).extend({
        ckplayer: 'ckplayer/ckplayer'
    }).use(['jquery', 'ckplayer','form'], function() {
        var $ = layui.$,
            ckplayer = layui.ckplayer,
            form = layui.form;

        for(var i = 0;i < $(".sOpusvideoUrl").length; i++)
        {
            var vUrl = $('.sOpusvideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sOpusvideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }

        for(var i = 0;i < $(".sTrainingvideoUrl").length; i++)
        {
            var vUrl = $('.sTrainingvideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sTrainingvideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }

        for(var i = 0;i < $(".sDefensevideoUrl").length; i++)
        {
            var vUrl = $('.sDefensevideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sDefensevideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }

        for(var i = 0;i < $(".sPracticevideoUrl").length; i++)
        {
            var vUrl = $('.sPracticevideoUrl').eq(i).data('url'),
                videoObject = {
                    container: "#sPracticevideoUrl"+i,
                    loop: true,
                    autoplay: false,
                    video: [
                        [vUrl, 'video/mp4']
                    ]
                };
            var player = new ckplayer(videoObject);
        }

        form.on('submit(save)', function(data){

            if($("input[name=sCertificateImg]").val().length == 0)
            {
                layer.msg('请上传证书');
                return false;
            }

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

    function uploadFile(that)
    {
        $(that).fileupload({
            dataType: 'json',
            url: 'index.php?r=web/upload/upload',
            success: function (json) {
                if(json.code == 0){
                    $("input[name=sCertificateImg]").val(json.data.url);
                    $(".sCertificateImg").attr('src',"<?=Yii::$app->params['imagePath']?>"+json.data.url);
                    $(".sCertificateImg").css('display','block');
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
