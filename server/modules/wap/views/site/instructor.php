<?php
use app\assets\WapAsset;
use yii\helpers\Url;
WapAsset::register($this);
$this->beginContent('@views/layouts/wap.php');
?>
<?=\app\modules\wap\model\process\PublicProcess::TopWeb()?>
    <div class="container index">
        <div class="specialist">
            <div class="section-title">
                <div class="title">全部专家</div>
            </div>
            <hr style="height:1px;border:none;border-top:1px double rgba(222,230,236,1);">
            <div class="content-box">
                <?php foreach($instructor as $r2){?>
                    <a href="index.php?r=wap/site/instructorinfo&id=5">
                        <div class="item flex-box" onclick="optionInstructor(<?=$r2->id?>)" style="cursor:pointer">
                            <img src="<?=Yii::$app->params['imagePath'].$r2->headportrait?>" alt="">
                            <div class="detail filler">
                                <div class="name"><?=$r2->sName?></div>
                                <div class="time"><?=$r2->year?>年从业经验</div>
                                <div class="tip"><?=mb_substr($r2->info,0,50)?>...</div>
                            </div>
                        </div>
                    </a>
                <?php }?>
            </div>
        </div>
    </div>
    <footer>
        <?=\app\modules\wap\model\process\PublicProcess::MiddleWeb()?>
    </footer>
<?php
$this->endContent();
?>