<?php /* Template_ 2.2.7 2018/07/21 06:50:43 /volume1/web/lab4.work6.kr/data/skin/admin/_header.htm 000004626 */ ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $TPL_VAR["cfg"]["site_name"]?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
	<meta name="Author" content="<?php echo $TPL_VAR["cfg"]["company_name"]?>">
	<meta name="Keywords" content="<?php echo $TPL_VAR["cfg"]["site_keywords"]?>">
	<meta name="Description" content="<?php echo $TPL_VAR["cfg"]["site_description"]?>">
	<meta name="format-detection" content="telephone=no">

    <meta property="og:type" content="article">
	<meta property="og:title" content="<?php echo $TPL_VAR["cfg"]["site_name"]?>">
	<meta property="og:description" content="<?php echo $TPL_VAR["cfg"]["site_description"]?>">
	<meta property="og:image" content="/ogimage.jpg">
	<meta property="og:url" content="http://<?php echo $GLOBALS["_SERVER"]["HOST"]?>">


	<link href="/favicon.ico" rel="shortcut icon">

	<link rel="stylesheet" type="text/css" href="/data/skin/<?php echo $TPL_VAR["cfg"]["skin"]?>/css/reset.css?v=<?php echo time()?>">
	<link rel="stylesheet" type="text/css" href="/data/skin/<?php echo $TPL_VAR["cfg"]["skin"]?>/css/style.css?v=<?php echo time()?>">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" />

	<!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="/data/js/jquery-ui.js"></script>
    <script src="/data/js/designSelect_1.6.js?v=<?php echo time()?>"></script>
    <script src="/data/js/designToggle_1.2.js?v=<?php echo time()?>"></script>
    <script src="/data/js/designCheckbox_1.2.js?v=<?php echo time()?>"></script>
    <script src="/data/js/fullPopup_1.5.js"></script>
	<script src="/data/skin/<?php echo $TPL_VAR["cfg"]["skin"]?>/js/common.js?v=<?php echo time()?>"></script>


</head>
<body>

    <div id="admin_body" class="relative">

        <div class="menu">
            <div class="admin_name size16"><a class="white" href="/admin"><?php echo $TPL_VAR["cfg"]["site_name"]?></a></div>
            <ul>
<?php if($this->admin_menu){?>
<?php if(is_array($TPL_R1=$this->admin_menu)&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if($TPL_K2== 0){?>
                            <li class="title white"><?php echo $TPL_V2[ 1]?> <?php echo $TPL_V2[ 0]?></li>
<?php }else{?>
                            <li><a href="<?php echo $TPL_V2[ 1]?>" class="block"><?php echo $TPL_V2[ 0]?></a></li>
<?php }?>
<?php }}?>
<?php }}?>
<?php }?>
            </ul>
            <div id="copyright" class="size10"><a href="http://work6.kr" target="_blank">Program created by work6.kr</a></div>
        </div>

        <div class="body left">

            <div id="body_header" class="bg_white relative">
                <a href="#" class="size20 btn_menu"><i class="fas fa-bars" ></i></a>
                <div class="profile absolute right">
                    <div class="btn_element">
                        <div class="photo inline_block">
<?php if($TPL_VAR["sess"]["photo"]){?>
                                <img src="/data/skin/<?php echo $TPL_VAR["cfg"]["skin"]?>/img/admin_photo/<?php echo $TPL_VAR["sess"]["photo"]?>" alt="<?php echo $TPL_VAR["sess"]["name"]?>">
<?php }else{?>
                                <img src="/data/skin/<?php echo $TPL_VAR["cfg"]["skin"]?>/img/admin_photo/user.jpg" alt="<?php echo $TPL_VAR["sess"]["name"]?>">
<?php }?>
                        </div>
                        <span class="inline_block"> <?php echo $TPL_VAR["sess"]["name"]?> </span>
                        <span class="size16 inline_block mr20"><i class="fas fa-chevron-down"></i></span>
                    </div>

                    <ul class="relative bg_white border mt10 left">
                        <li><a href="/admin/member/profile/<?php echo $TPL_VAR["sess"]["idx"]?>" class="block hover_green"><i class="fas fa-cog center"></i> 프로필</a></li>
                        <li><a href="/admin/login/out" class="block hover_red"><i class="fas fa-power-off center"></i> 로그아웃</a></li>
                    </ul>
                </div>
            </div>