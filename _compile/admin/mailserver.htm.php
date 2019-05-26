<?php /* Template_ 2.2.7 2018/06/26 02:23:01 /volume1/web/lab4.work6.kr/data/skin/admin/mailserver.htm 000003087 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="mailserver" class="bg_white">
    <nav><i class="fas fa-code-branch"></i> 설정 > 메일서버</nav>

    <form method="post" enctype="multipart/form-data" action="/admin/conf/mailServer" target="ifrmh">

        <div class="form">
            <h2><i class="fa fa-cube" aria-hidden="true"></i> 데이터</h2>
            <table>
                <colgroup>
                    <col width="180px">
    				<col>
    			</colgroup>
                <tr>
    				<th>메일서버</th>
                    <td>
                        <select name="email_server">
                            <option value="server" >프로그램 서버와 동일</option>
                            <option value="stmp" <?php echo $TPL_VAR["data"]["selected"]["email_server"]["stmp"]?>>외부서버(STMP)</option>
                        </select>
                    </td>
    			</tr>
    		</table>
        </div>


        <div class="form stmp_detail">
            <h2><i class="fa fa-cube" aria-hidden="true"></i> 외부서버(STMP)</h2>
            <table>
                <colgroup>
                    <col width="180px">
    				<col>
    			</colgroup>
                <tr>
    				<th>SMTP 서버명(호스트)</th>
                    <td><input type="text" name="site_stmp_server" value="<?php echo $TPL_VAR["cfg"]["site_stmp_server"]?>"></td>
    			</tr>
                <tr>
    				<th>SMTP 포트</th>
                    <td><input type="text" name="site_stmp_port" value="<?php echo $TPL_VAR["cfg"]["site_stmp_port"]?>"></td>
    			</tr>
                <tr>
    				<th>보안</th>
                    <td>
                        <select name="email_secure">
                            <option value="ssl">SSL</option>
                            <option value="tls" <?php echo $TPL_VAR["data"]["selected"]["email_secure"]["tls"]?>>TLS</option>
                        </select>
                    </td>
    			</tr>
                <tr>
    				<th>아이디</th>
                    <td><input type="text" name="site_stmp_id" value="<?php echo $TPL_VAR["cfg"]["site_stmp_id"]?>"></td>
    			</tr>
                <tr>
    				<th>패스워드</th>
                    <td><input type="password" name="site_stmp_pw" value="<?php echo $TPL_VAR["cfg"]["site_stmp_pw"]?>"></td>
    			</tr>
    		</table>
        </div>


        <div class="btn_area center">
            <button type="submit" class="button white bg_black hover_white">저장</button>
        </div>

    </form>

</div>


<script>
$(function(){

    setStmpDetail();

    function setStmpDetail(){
        if($('[name="email_server"]').val()=='stmp'){
            $('.stmp_detail').css('display','block');
        }else{
            $('.stmp_detail').css('display','none');
        }
    }


    $('[name="email_server"]').on('change',function(e){
        setStmpDetail();
    });

});
</script>

<?php $this->print_("footer",$TPL_SCP,1);?>