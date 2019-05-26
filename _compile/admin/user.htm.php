<?php /* Template_ 2.2.7 2018/06/26 02:23:01 /volume1/web/lab4.work6.kr/data/skin/admin/user.htm 000003821 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="user" class="bg_white">
    <nav><i class="fas fa-code-branch"></i> 직원 > 직원리스트</nav>

    <form method="post" enctype="multipart/form-data" action="/admin/member/user/<?php echo $TPL_VAR["data"]["idx"]?>" target="ifrmh">

        <div class="form">
            <h2><i class="fa fa-cube" aria-hidden="true"></i> 데이터</h2>
            <table>
                <colgroup>
                    <col width="180px">
    				<col>
    			</colgroup>
                <tr>
    				<th>이메일</th>
                    <td>
<?php if($TPL_VAR["data"]["uid"]){?>
                            <?php echo $TPL_VAR["data"]["uid"]?>

<?php }else{?>
                            <input type="text" name="uid" >
<?php }?>
                    </td>
    			</tr>
                <tr>
    				<th>등급</th>
                    <td>
                        <select name="level">
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["level_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["level"]?>" <?php if($TPL_VAR["data"]["level"]==$TPL_V1["level"]){?>selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
                        </select>
                        <div class="size10 green">등급 추가는 <a href="/admin/member/groups" class="blue">직원 > 직원등급</a> 메뉴에서 해주세요.</div>
                    </td>
    			</tr>
                <tr>
    				<th>소속</th>
                    <td>
                        <input type="text" name="team" value="<?php echo $TPL_VAR["data"]["team"]?>">
                    </td>
    			</tr>
                <tr>
    				<th>이름</th>
                    <td>
                        <input type="text" name="name" value="<?php echo $TPL_VAR["data"]["name"]?>">
                    </td>
    			</tr>
                <tr>
    				<th>연락처</th>
                    <td>
                        <input type="text" name="mobile" value="<?php echo $TPL_VAR["data"]["mobile"]?>">
                    </td>
    			</tr>
<?php if($TPL_VAR["data"]["uid"]){?>
                <tr>
    				<th>패스워드</th>
                    <td>
                        <a class="inline_block button white bg_black hover_white btn_new_password" idx='<?php echo $TPL_VAR["data"]["idx"]?>'>패스워드 발급</a>
                        <div class="size10 green"><?php echo $TPL_VAR["data"]["uid"]?>로 새로운 패스워드가 전송 됩니다.</div>
                    </td>
    			</tr>
<?php }else{?>
                <tr>
    				<th>패스워드</th>
                    <td>
                        <input type="password" name="upw[]" placeholder="패스워드">
                        <input type="password" name="upw[]" placeholder="패스워드 확인">
                    </td>
    			</tr>
<?php }?>
    		</table>
        </div>

        <div class="btn_area center">
            <a href="<?php echo $GLOBALS["_SERVER"]['HTTP_REFERER']?>" class="inline_block button white bg_black hover_white">취소</a>
            <button type="submit" class="button white bg_black hover_white">저장</button>
        </div>

    </form>

</div>


<script>
$(function(){
    $('.btn_new_password').click(function(){

        $.post('/admin/member/sendNewPassword',{ idx: $(this).attr('idx') } ,function(res){
            if(res=='1'){
                alert('패스워드가 전송되었습니다.');
            }else{
                alert('패스워드 전송이 실패하였습니다. 개발자에게 문의 바랍니다.');
            }
        });

    });
});
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>