<!DOCTYPE html>
<html>
<head>
	<title>관리 프로그램 설치</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">

	<link rel="stylesheet" type="text/css" href="/data/skin/admin/css/reset.css?v=<?=time()?>">
	<link rel="stylesheet" type="text/css" href="/data/skin/admin/css/style.css?v=<?=time()?>">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" />

	<!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="/data/js/jquery-ui.js"></script>
    <script src="/data/js/designSelect_1.6.js?v=<?=time()?>"></script>
    <script src="/data/js/designToggle_1.2.js?v=<?=time()?>"></script>
    <script src="/data/js/designCheckbox_1.2.js?v=<?=time()?>"></script>
	<script src="/data/skin/admin/js/common.js?v=<?=time()?>"></script>

</head>
<body>

    <div id="admin_body" class="full">

        <div class="body">

            <div id="install" class="bg_white">

                <dl>
                    <dd>
                        <h1>관리 프로그램 설치</h1>
                        <form method="post" action="./install_indb.php" target="ifrmh">
                            <div class="pt10">
                                <h2 class="pb10"><i class="fa fa-cube" aria-hidden="true"></i> 관리자 계정 생성</h2>
                                <input type="text" name="uid" value="" placeholder="이메일" required="required">
                				<input type="password" name="upw" value="" placeholder="패스워드(6자 이상)" required="required">
                				<input type="password" name="upw2" value="" placeholder="패스워드 확인(6자 이상)" required="required">
                            </div>

                            <div class="pt20">
                                <h2 class="pb10"><i class="fa fa-cube" aria-hidden="true"></i> 데이터베이스</h2>
                				<input type="text" name="db_host" value="localhost" required="required" placeholder="호스트">
                				<input type="text" name="db_name" value="" placeholder="데이터베이스명" required="required">
                				<input type="text" name="db_id" value="" placeholder="아아디" required="required">
                				<input type="password" name="db_pw" value="" placeholder="패스워드" required="required">
                            </div>


                            <div class="btn_area">
                                <input type="submit" class="white bg_black hover_white" value="프로그램 설치">
                            </div>
                        </form>
                    </dd>
                </dl>

                <span class="block relative size10 center gray"><a href="http://work6.kr" target="_blank">Program created by work6.kr</a></span>
            </div>

        </div>
    </div>
    <iframe id="ifrmh" name="ifrmh" src="" style="display:none;"></iframe>
</body>
</html>
