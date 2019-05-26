<?php /* Template_ 2.2.7 2018/06/26 02:23:01 /volume1/web/lab4.work6.kr/data/skin/admin/notice.htm 000002400 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="notice" class="bg_white">
    <nav><i class="fas fa-code-branch"></i> 설정 > 공지</nav>

    <form method="post" enctype="multipart/form-data" action="/admin/notice/notice/<?php echo $TPL_VAR["data"]["idx"]?>" target="ifrmh">

        <div class="form">
            <h2><i class="fa fa-cube" aria-hidden="true"></i> 데이터</h2>
            <table>
                <colgroup>
                    <col width="180px">
    				<col>
    			</colgroup>
                <tr>
    				<th>작성자</th>
                    <td>
                        <?php echo $TPL_VAR["sess"]["name"]?>

                        <input type="hidden" name="member_idx" value="<?php echo $TPL_VAR["sess"]["idx"]?>">
                    </td>
    			</tr>
                <tr>
    				<th>제목</th>
                    <td>
                        <input type="text" name="subject" value="<?php echo $TPL_VAR["data"]["subject"]?>" size=80>
                    </td>
    			</tr>
                <tr>
    				<th>내용</th>
                    <td>
                        <textarea name="contents" rows=5><?php echo $TPL_VAR["data"]["contents"]?></textarea>
                    </td>
    			</tr>
                <tr>
    				<th>첨부파일</th>
                    <td>
<?php if($TPL_VAR["data"]["file"]){?>
                        <a href="/data/skin/<?php echo $TPL_VAR["cfg"]["skin"]?>/file/<?php echo $TPL_VAR["data"]["file"]?>" target="ifrmh" class="green"><?php echo $TPL_VAR["data"]["file"]?></a>
                        <label><input type="checkbox" class="checkbox" name="file_del" value="y"> 삭제</label>
                        <input type="hidden" name="ori_file" value="<?php echo $TPL_VAR["data"]["file"]?>">
                        <br/>
<?php }?>
                        <input type="file" name="file" >
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