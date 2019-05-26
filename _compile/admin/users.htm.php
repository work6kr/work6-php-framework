<?php /* Template_ 2.2.7 2018/07/05 01:57:31 /volume1/web/lab4.work6.kr/data/skin/admin/users.htm 000004219 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="users" class="bg_white">
    <nav><i class="fas fa-code-branch"></i> 직원 > 직원리스트</nav>

    <div class="searcharea">
		<form enctype="multipart/form-data">
		<table>
    			<tbody>
                <tr>
    				<td>
    					<select name="skey">
                            <option value="uid" >이메일</option>
    						<option value="name" <?php echo $TPL_VAR["data"]["selected"]["skey"]["name"]?>>이름</option>
                            <option value="mobile" <?php echo $TPL_VAR["data"]["selected"]["skey"]["mobile"]?>>연락처</option>
    					</select>
    					<input type="text" name="stxt" value="<?php echo $GLOBALS["_GET"]['stxt']?>">
    					<input type="submit" value="검색" class="small-btn">
    				</td>
    				<td>
    					<select name="row">
    						<option value="10">Row 10</option>
    						<option value="20" <?php echo $TPL_VAR["data"]["selected"]["row"][ 20]?>>Row 20</option>
    						<option value="50" <?php echo $TPL_VAR["data"]["selected"]["row"][ 50]?>>Row 50</option>
    						<option value="100" <?php echo $TPL_VAR["data"]["selected"]["row"][ 100]?>>Row 100</option>
    					</select>
    				</td>
    			</tr>
    		</tbody>
        </table>
		</form>
	</div>


    <form method="post" enctype="multipart/form-data" action="/admin/member/users/delete" target="ifrmh" onsubmit="return confirm('정말 삭제하시겠습니까?')">
        <div class="form">
            <div class="list over_table">
				<table>
                    <colgroup>
                        <col width="50px">
                        <col>
						<col width="100px">
						<col width="100px">
                        <col width="100px">
						<col width="100px">
                        <col width="100px">
						<col width="50px">
					</colgroup>
                    <tbody>
                    <tr>
						<th class="chkall">선택</th>
                        <th>이메일</th>
                        <th>직원등급</th>
						<th>이름</th>
						<th>연락처</th>
						<th>가입일</th>
                        <th>수정일</th>
						<th>관리</th>
					</tr>
<?php if($TPL_VAR["data"]["list"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <tr class="hover_green">
						<td><input type="checkbox" class="checkbox" name="idx[]" value="<?php echo $TPL_V1["idx"]?>"></td>
                        <td><?php echo $TPL_V1["uid"]?></td>
						<td><?php echo $TPL_V1["level_name"]?></td>
                        <td><?php echo $TPL_V1["name"]?></td>
						<td><?php echo $TPL_V1["mobile"]?></td>
						<td><?php echo $TPL_V1["insdt"]?></td>
                        <td><?php echo $TPL_V1["moddt"]?></td>
						<td><a href="/admin/member/user/<?php echo $TPL_V1["idx"]?>">수정</a></td>
					</tr>
<?php }}?>
<?php }else{?>
                    <tr>
						<td colspan="20">데이터가 없습니다.</td>
					</tr>
<?php }?>
                    </tbody>
                </table>
			</div>
        </div>


        <ul class="pageaerea center pb20">
            <?php echo $TPL_VAR["page"]->page?>

        </ul>

        <div class="btn_area">
            <div class="btn_area center">
                <a href="#" class="button inline_block white bg_black hover_white btn_select_delete">선택삭제</a>
                <a href="/admin/member/user" class="button inline_block white bg_black hover_white">추가</a>
            </div>
        </div>

    </form>



</div>

<script>
$(function(){


    $('[name="row"]').on("change",function(e){
        $(this).closest('form').submit();
    });


    $('.btn_select_delete').click(function(){

        checkdd_chkbox = $(this).closest('table').find('input[type="checkbox"]').is(":checked");
        checkdd_len = checkdd_chkbox.length;

        if(checkdd_len==0){
            alert('데이터를 선택해 주세요.');
            return false;
        }


        $(this).closest('form').submit();

    });

});

</script>

<?php $this->print_("footer",$TPL_SCP,1);?>