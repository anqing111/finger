<?php
use app\assets\WebAsset;
use yii\helpers\Url;
WebAsset::register($this);
$this->beginContent('@views/layouts/web.php');
?>
    <style>
        .section-title{
            height: auto;
        }
        .optionCourse{
            color:rgb(255, 157, 42);
        }
    </style>
<?=\app\modules\web\model\process\PublicProcess::TopWeb('course')?>
    <div class="container index">
        <div class="specialist">
            <div class="specialist-bg" style="background-color: #FDF7F2; /* 浏览器不支持时显示 */
            /* Safari */
            background: -webkit-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* Opera */
            background: -o-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* Firefox */
            background: -moz-linear-gradient(#FFFDFA 30%, #FFFEFF 75%);
            /* 标准的语法, 放在最后 */
            background: linear-gradient(#FFFDFA 30%,  #FFFEFF 75%);
            ">
                <div class="container">
                    <div class="section-title">
                        <div class="course-title">全部课程</div>
                        <div class="course-tag">
                            <li data-value = '-1' onclick="optionCourse(this)" style="color: rgb(255, 157, 42);">全部</li>
                            <?php foreach($industr as $r){?>
                            <li data-value = '<?=$r->id?>' onclick="optionCourse(this)"><?=$r->sIndustryName?></li>
                            <?php }?>
                        </div>
                        <div class="course-title" style="margin-bottom: 20px">精品公开课</div>
                    </div>
                    <hr style=" height: 1px;border: none;background:rgba(231,237,241,1);">
                    <div class="content-box" style="margin-top: 20px">
                        <?php foreach($course as $c){?>
                            <div class="flex-box course-list" onclick="courseinfo(<?=$c->id?>)">
                                <img src="<?=Yii::$app->params['imagePath'].$c->sCourseImg?>" alt="">
                                <p class="course-name"><?=$c->sCourseName?></p>
                                <p class="course-author">主讲人：<?=$c->author?></p>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?=\app\modules\web\model\process\PublicProcess::MiddleWeb()?>
    </footer>
    <script>
        var windowHeight=$('.container.index .container').height()<700?700:$('.container.index .container').height();
        if($('.container.index .container').length){
            $('.container.index').css('height',windowHeight+200+'px')
        }

        var liWidth = 0,len = 0;

        $('.course-tag li').each(function (ids, items) {
            liWidth = parseInt(liWidth) + parseInt($(this).width()) + 43;
            if(liWidth > 1200)
            {

            }else{
                len ++;
            }
        });

        if(liWidth > 1200)
        {
            var len = Math.ceil(parseInt($('.course-tag li').length) / len);
            $('.course-tag').css('height',50*len+'px')
        }

        $('.course-list').each(function (ids, items) {
            if((ids+1) % 5 == 0 && ids > 0)
            {
                $(this).css('margin-right','0');
            }
        });

        $('.course-tag li').mousemove(function(){
            $(this).css("color","#FF9D2A");
        });
        $('.course-tag li').mouseout(function(){

            if(!$(this).hasClass('optionCourse'))
            {
                $(this).css("color","rgba(103,101,98,1)");
            }
        });

        function optionCourse(that)
        {
            $('.course-tag li').each(function () {
                $(this).removeClass('optionCourse');
                $(this).css("color","rgba(103,101,98,1)");
            });
            $(that).addClass('optionCourse');
            $(that).css("color","#FF9D2A");
            var arrPara = ['merCode','timestamp','client','tid'];
            var jsonData = {
                merCode: '<?=Yii::$app->params['MERCODE']?>',
                timestamp: Date.now(),
                client:'web',
                tid:$(that).attr('data-value')
            };
            arrPara = arrPara.sort();
            var str = "";
            for(var i = 0; i < arrPara.length; i++) {
                str += arrPara[i]+"="+jsonData[arrPara[i]]+"&";
            }
            str += 'key=<?=Yii::$app->params['KEY']?>';
            jsonData['signMsg'] = md5(str);
            getAJAX(jsonData,courseindex,'site/courseindex');
        }

        function courseindex(jsonStr) {
            var str = '';
            $(jsonStr.data.course).each(function (ids, items) {
                str += ' <div class="flex-box course-list">\n' +
                    '                            <img src="<?=Yii::$app->params['imagePath']?>'+items.sCourseImg+'" alt="">\n' +
                    '                            <p class="course-name">'+items.sCourseName+'</p>\n' +
                    '                            <p class="course-author">主讲人：'+items.author+'</p>\n' +
                    '                        </div>';
            });
            $('.content-box').html(str);
        }

        function courseinfo(id) {
            location.href = 'index.php?r=web/site/courseinfo&id='+id;
        }
    </script>
<?php
$this->endContent();
?>