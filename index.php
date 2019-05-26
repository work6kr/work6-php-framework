<?
session_start();
ini_set('display_errors',0);
header("Content-Type: text/html; charset=UTF-8");

include 'autoload.php';

$tpl = new common\Template();
$db = new common\DBLibrary();
$dev = new common\DevLibrary();
$lib = new common\Library();


$cfg = $lib->cfg;


if($lib->segment[2]=='admin'){

    if($lib->segment[3]!=''){
        $namespace = "controller\\admin\\".$lib->segment[3];
        $custom_namespace = "custom\\admin\\".$lib->segment[3];
    }else{
        $namespace = "controller\\admin\\main";
        $custom_namespace = "custom\\admin\\main";
    }

    $class = $lib->getClass($namespace,$custom_namespace);


    if($lib->segment[4]!=''){
        $method = $lib->segment[4];
        if(method_exists($class,$method)){
            $class->$method();
        }else{
            $lib->err404($method." 메서드를 찾을 수 없습니다.");
        }

    }

    exit;

}elseif($lib->segment[2]!=''){

    $namespace = "controller\\front\\".$lib->segment[2];
    $custom_namespace = "custom\\front\\".$lib->segment[2];

    $class = $lib->getClass($namespace,$custom_namespace);


}else{

    $namespace = "controller\\front\\main";
    $custom_namespace = "custom\\front\\main";


    $class = $lib->getClass($namespace,$custom_namespace);

}



if($lib->segment[3]!=''){
    $method = $lib->segment[3];
    if(method_exists($class,$method)){
        $class->$method();
    }else{
        $lib->err404($method." 메서드를 찾을 수 없습니다.");
    }
}
