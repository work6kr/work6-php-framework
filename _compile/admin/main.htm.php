<?php /* Template_ 2.2.7 2018/06/26 02:23:01 /volume1/web/lab4.work6.kr/data/skin/admin/main.htm 000001584 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="main" class="bg_gray">
    <div class="bg_white radius10 inline_block">
        <h2><i class="fas fa-exclamation-circle"></i> 공지</h2>
        <ul class="history_list">
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["notice"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <li class="pl10 pt10 pb20 relative">
                <h3 class="size16"><?php echo $TPL_V1["subject"]?></h3>
                <div class="gray mt10 mb10"><span class="green"><?php echo $TPL_V1["insdt"]?></span>, <?php echo $TPL_V1["name"]?><?php if($TPL_V1["file"]){?>, <a href="/data/skin/<?php echo $TPL_VAR["cfg"]["skin"]?>/file/<?php echo $TPL_V1["file"]?>" target="ifrmh" class="blue">첨부파일 다운로드</a><?php }?></div>
                <p class="gray"><?php echo $TPL_V1["contents"]?></p>
            </li>
<?php }}?>
        </ul>
    </div>
    <div class="bg_white radius10 inline_block">
        <h2><i class="fas fa-flag"></i> 최근접속</h2>
        <ul class="history_list">
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["log_login"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <li class="pl10 pt10 pb20 relative">
                <div class="gray"><span class="green"><?php echo $TPL_V1["logindt"]?></span><br/><?php echo $TPL_V1["member_name"]?> ( <?php echo $TPL_V1["ip"]?> )</div>
            </li>
<?php }}?>
        </ul>
    </div>

</div>

<?php $this->print_("footer",$TPL_SCP,1);?>