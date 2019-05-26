<?php /* Template_ 2.2.7 2018/06/26 02:23:01 /volume1/web/lab4.work6.kr/data/skin/admin/group.htm 000002570 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="group" class="bg_white">
    <nav><i class="fas fa-code-branch"></i> 직원 > 직원등급</nav>

    <form method="post" enctype="multipart/form-data" action="/admin/member/group/<?php echo $this->lib->segment[ 5]?>" target="ifrmh">

        <div class="form">
            <h2><i class="fa fa-cube" aria-hidden="true"></i> 데이터</h2>
            <table>
                <colgroup>
                    <col width="180px">
    				<col>
    			</colgroup>
                <tr>
    				<th>등급명</th>
                    <td><input type="text" name="name" value="<?php echo $TPL_VAR["data"]["name"]?>"></td>
    			</tr>
                <tr>
    				<th>등급</th>
                    <td>
                        <input type="text" name="level" value="<?php echo $TPL_VAR["data"]["level"]?>">
                        <div class="size10 green">9998 이하 숫자를 입력합니다.</div>
                    </td>
    			</tr>
                <tr>
    				<th>관리자 접근 여부</th>
                    <td>
                        <input type="checkbox" name="admin_permision" value="y" class="toggle" <?php echo $TPL_VAR["data"]["checked"]["admin_permision"]["y"]?>>
                    </td>
    			</tr>
                <tr>
    				<th>관리자 메뉴 접근 허용</th>
                    <td>
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["admin_menu"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                        <div class="pt10 pb10">
                            <div class="pb10"><?php echo $TPL_V1[ 0][ 1]?> <?php echo $TPL_V1[ 0][ 0]?></div>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if($TPL_K2!= 0){?>
                            <label class="inline_block ml10"><input type="checkbox" class="checkbox" name="admin_menu_permit[]" value="<?php echo $TPL_V2[ 1]?>" <?php echo $TPL_V2[ 2]?>/> <?php echo $TPL_V2[ 0]?></label>
<?php }?>
<?php }}?>
                        </div>
<?php }}?>
                    </td>
    			</tr>

    		</table>
        </div>

        <div class="btn_area center">
            <a href="<?php echo $GLOBALS["_SERVER"]['HTTP_REFERER']?>" class="inline_block button white bg_black hover_white">취소</a>
            <button type="submit" class="button white bg_black hover_white">저장</button>
        </div>

    </form>

</div>

<?php $this->print_("footer",$TPL_SCP,1);?>