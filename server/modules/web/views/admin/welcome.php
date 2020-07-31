<?php
use app\assets\AppAsset;
AppAsset::register($this);
$this->beginContent('@views/layouts/public.php');
?>
<style>
   .x-body{
       position: relative;
       margin: 0 auto;
       top: 30%;
       left: 30%;
   }
</style>
<body>
<div class="x-body">
<h1>欢迎来到八泽国际管理后台</h1>
</div>
</body>
<?php
$this->endContent();
?>
