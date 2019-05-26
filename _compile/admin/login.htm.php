<?php /* Template_ 2.2.7 2018/06/26 02:23:01 /volume1/web/lab4.work6.kr/data/skin/admin/login.htm 000001186 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="login" class="bg_white">

    <dl>
        <dd>
            <h1><?php echo $TPL_VAR["cfg"]["site_name"]?> 관리자 로그인</h1>
            <form method="post" action="/admin/login/chk" target="ifrmh">
                <input type="text" name="uid" value="<?php echo $TPL_VAR["data"]["uid"]?>" autocomplete="off" placeholder="이메일" required="required">
                <input type="password" name="upw" placeholder="패스워드" required="required" value="">
                <label><input type="checkbox" class="checkbox" name="saveid" value="y" <?php echo $TPL_VAR["data"]["checked"]["saveid"]?>> 아이디저장</label>

                <div class="btn_area">
                    <input type="submit" class="white bg_black hover_white" value="로그인">
                </div>
            </form>
        </dd>
    </dl>
    <span class="block relative size10 center gray"><a href="http://work6.kr" target="_blank">Program created by work6.kr</a></span>
</div>


<?php $this->print_("footer",$TPL_SCP,1);?>