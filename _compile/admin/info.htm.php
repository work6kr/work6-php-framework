<?php /* Template_ 2.2.7 2018/07/21 07:07:30 /volume1/web/lab4.work6.kr/data/skin/admin/info.htm 000001578 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>


<div id="info" class="bg_white">
    <nav><i class="fas fa-code-branch"></i> 도움말 > 프로그램 정보</nav>



        <div class="form">
            <h2><i class="fa fa-cube" aria-hidden="true"></i> <?php echo $TPL_VAR["cfg"]["site_name"]?> 프로그램</h2>
            <table>
                <colgroup>
                    <col width="180px">
    				<col>
    			</colgroup>
                <tr>
    				<th>코어 프로그램 버전</th>
                    <td><?php echo $TPL_VAR["data"]["core_version"]?></td>
    			</tr>
                <tr>
    				<th>관리 프로그램 버전</th>
                    <td><?php echo $TPL_VAR["data"]["solution_version"]?></td>
    			</tr>
                <tr>
    				<th>개발회사</th>
                    <td><?php echo $TPL_VAR["data"]["maker"]?></td>
    			</tr>
                <tr>
    				<th>개발회사 홈페이지</th>
                    <td><a href="<?php echo $TPL_VAR["data"]["homepage"]?>" target="_blnak" class="blue"><?php echo $TPL_VAR["data"]["homepage"]?></a></td>
    			</tr>
    		</table>
        </div>


        <div class="form">
            <h2><i class="fa fa-cube" aria-hidden="true"></i> 개발자 가이드</h2>
            <a href="<?php echo $TPL_VAR["data"]["dev_guide"]?>" target="_blnak" class="blue"><?php echo $TPL_VAR["data"]["dev_guide"]?></a>
        </div>




</div>

<?php $this->print_("footer",$TPL_SCP,1);?>