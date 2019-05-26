# work6-php-framework : 워크식스 프레임워크
php를 이용한 웹 서비스를 구축하는 개발자들을 위한 개발 프레임워크 입니다.
꼭 필요한 클래스와 메소드를 제공함으로써 훨씬 빠르게 프로젝트를 개발할 수 있게 합니다.
프레임워크를 이용하면 코드의 양을 최소화하여 개발 스트레스로부터 해방 시켜주며, 창의적인 개발에 집중할 수 있도록 해줍니다.
<br>
<br>
<br>
## 특징
- 한국어 프레임워크 가이드를 제공합니다.
- 가볍고 탁월한 성능을 자랑합니다.
- MVC(model-view-controller)를 지원 합니다.
- UI 설치가 가능합니다.
- 손쉬운 버전 업그레이드를 지원합니다.
- 솔루션 개발에 필요한 기본 관리자가 포함되어 있습니다.
- 표준적으로 사용되는 제이쿼리 플러그인 및 스타일을 포함하고 있습니다.
- 코어와 커스터마이징 영역이 분리되어 관리가 쉽습니다.
<br>
<br>
<br>
## 포함
- [Template_ 2.2.7](https://tpl.xtac.net/introduction/)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer/)
- [워크식스 제이쿼리 플러그인](https://work6.kr/plugin)
<br>
<br>
<br>
## 설치환경
최소한의 설치환경을 요구합니다.
- Linux(CentOS 또는 Ubuntu)
- Apache 2.2+
- php7.0+
- MariaDB 5.0+
- Charset UTF-8
<br>
<br>
<br>

## git으로 설치하기
1. 웹 서버에 git을 서버에 설치합니다.
1. 웹서비스의 홈 디렉토리로 이동합니다.
1. git clone https://github.com/work6kr/work6-php-framework.git 합니다.
1. 데이터베이스를 만듭니다.
1. 웹브라우저로 대표도메인에 접속합니다.
1. 사용할 관리자 계정 정보 및 데이터베이스 정보를 입력합니다.
1. http://도메인/admin 으로 접속되면 설치가 완료된 것입니다.

<br>
<br>
<br>
## zip으로 설치하기
1. zip으로 다운로드 받습니다.
1. 웹서비스의 홈 디렉토리로 이동합니다.
1. 압축을 풀어서 웹서버에 업로드 합니다.
1. .htaccess 파일이 업로드 되었는지 다시 한번 체크 합니다.
1. 데이터베이스를 만듭니다.
1. 웹브라우저로 대표도메인에 접속합니다.
1. 사용할 관리자 계정 정보 및 데이터베이스 정보를 입력합니다.
1. http://도메인/admin 으로 접속되면 설치가 완료된 것입니다.

<br>
<br>
<br>

## 디렉토리 구조
##### 코어
common, controller 디렉토리가 해당합니다. 이곳의 파일들은 불가피한 경우를 제외하고 수정/삭제를 권하지 않습니다. 코어 영역 디렉토리들을 교체하여 프레임워크 버전을 업데이트를 할 수 있습니다. common는 템플릿, 다운로드, 파일 업로드, 메일과 같이 공통으로 사용될수 있는 클래스들이 있습니다. controller는 직원 관리, 로그인, 로그아웃 등 솔루션 개발에 필요한 기본 페이지를 구성하는 클래스들이 있습니다. controller/admin에는 관리자 페이지들이, controller/front에는 사용자 페이들이 구성되어 있습니다.
<br>
<br>
##### 커스텀마이징
custom 디렉토리가 해당합니다. 코어의 controller 안에 클래스들을 직접 수정하지 않고 커스텀마이징하기 위하여 존재합니다. controller와 같은 디렉토리 구조를 가집니다.
<br>
<br>

##### 모델
model 디렉토리가 해당합니다. 데이터베이스 select, insert, update 동작 클래스로 구성되어 있습니다.
<br>
<br>
##### 데이터
data 디렉토리가 해당합니다. data/skin/admin는 기본으로 제공되는 관리자 페이지의 퍼블리싱 파일 HTML, CSS, JS가 있습니다. data/skin/error는 에러 발생시 퍼블리싱 파일이 있습니다. data/document와 같이 디렉토리를 생성하여 업로드 파일, 공통 이미지 등을 저장할 수 있습니다.
<br>
<br>
<br>

## 캡슐화 구조
디렉토리 구조를 따릅니다.
```
namespace common
namespace controller
namespace controller\admin
namespace controller\front
namespace custom
namespace custom\admin
namespace custom\front
namespace model
namespace model\admin
namespace model\front
```

<br>
<br>
<br>

## URL 구조
##### 관리자
```
https://도메인/admin/클래스/메소드/파라미터1/파라미터2/...
```
##### 프론트
```
https://도메인/클래스/메소드/파라미터1/파라미터2/...
```
<br>
<br>
<br>


## 데이터베이스 기본 테이블
프레임워크 설치 중에 가장 간단한 구조의 데이터베이스 테이블이 함께 설치됩니다.
<br>
<br>
##### w_config : 설정 테이블
| 번호 | 컬럼 | 컬럼명 | 타입 | 비고 |
|:--------:|:--------|:--------|:--------|:--------|
| 1 | idx | 인덱스 | int(10) | auto_increment, primary key |
| 2 | code | 코드 | varchar(30) | 데이터 고유코드 |
| 3 | data | 값 | text |  |

<br>
##### w_level : 직원등급 테이블
| 번호 | 컬럼 | 컬럼명 | 타입 | 비고 |
|:--------:|:--------|:--------|:--------|:--------|
| 1 | idx | 인덱스 | int(10) | auto_increment, primary key |
| 2 | name  | 직원등급명  | varchar(30) | 데이터 고유코드 |
| 3 | admin_permision  | 접속허용여부  | varchar(1) | Y/N |
| 4 | admin_menu_permit  | 접근허용메뉴  | text  |  |
| 5 | level  | 직원등급  | int(4) |  |
| 6 | insdt  | 등록일  | datetime  |  |
| 7 | moddt  | 수정일  | datetime  |  |

<br>
##### w_member : 직원 테이블
| 번호 | 컬럼 | 컬럼명 | 타입 | 비고 |
|:--------:|:--------|:--------|:--------|:--------|
| 1 | idx | 인덱스 | int(10) | auto_increment, primary key |
| 2 | uid   | 아이디   | varchar(255) | 이메일 |
| 3 | upw   | 패스워드   | text | PASSWORD() |
| 4 | team   | 소속   | varchar(255)   |  |
| 5 | name   | 이름   | 	varchar(100) |  |
| 6 | level   | 직원등급  | int(4)  |  |
| 7 | insdt   | 가입일   | datetime  |  |
| 8 | moddt   | 수정일  | datetime  |  |
| 9 | logindt   | 최근접속일   | datetime  |  |
| 10 | ip   | 최근접속아이피   | varchar(45)  |  |
| 11 | photo   | 사진   | text   |  |

<br>
##### w_log_login : 접속 로그 테이블
| 번호 | 컬럼 | 컬럼명 | 타입 | 비고 |
|:--------:|:--------|:--------|:--------|:--------|
| 1 | idx | 인덱스 | int(10) | auto_increment, primary key |
| 2 | member_idx  | 직원 idx  | int(10) |  |
| 3 | logindt  | 최근접속일  | datetime  |  |
| 4 | ip  | 접속아이피  | varchar(45)  |  |

<br>
##### w_notice : 공지 테이블
| 번호 | 컬럼 | 컬럼명 | 타입 | 비고 |
|:--------:|:--------|:--------|:--------|:--------|
| 1 | idx | 인덱스 | int(10) | auto_increment, primary key |
| 2 | member_idx   | 작성자  | int(10) |  |
| 3 | subject   | 제목  | varchar(255) |  |
| 4 | contents   | 내용   | text  |  |
| 5 | file   | 첨부파일   | text |  |
| 6 | insdt  | 작성일  | datetime  |  |
| 7 | moddt  | 수정일  | datetime  |  |
<br>
<br>
<br>

## 추가한 데이터베이스 테이블 선언하기
테이블을 추가한 경우, custom/conf/tables.php 파일에 다음과 같이 추가합니다.
```php
$table['virtual_name'] ='real_table_name';
```
<br>
<br>
<br>


## 클래스 추가하기
- custom 디렉토리 안에 클래스명과 동일하게 파일을 만듭니다. 파일명은 소문자로 합니다. 클래스명은 첫글자를 대문자로 합니다.
- namespace를 지정해줍니다.
- 화면 출력이 필요한 경우 관리자는 common\AdminLibrary, 프론트는 common\FrontLibrary를 extends 합니다.
- extends 할때는 반드시 parent::__construct(); 를 추가합니다.
<br>
<br>
##### 방법1 : 새로운 클래스 추가
```php
/* custom/sample.php */
namespace custom\admin;
use common;
class Sample extends common\AdminLibrary{

    function __construct(){

        parent::__construct();

    }

}
```
<br>
##### 방법2 : controller 내에 클래스 대체
```php
/* custom/sample.php */
namespace custom\admin;
use common;
class Sample extends controller\admin\Sample{

    function __construct(){

        parent::__construct();

    }

}
```
<br>
<br>
<br>

## 클래스 수정하기
- <font style='color:red'>controller 디렉토리 내에 클래스/메소드 직접 수정을 추천하지 않습니다.</font>
- **클래스 추가하기 - 방법2 : controller 내에 클래스 대체** 방법을 이용합니다.
<br>
<br>
<br>

## 클래스 선언 : 불러오기
##### 방법1 : use 사용
```php
use common\Page as Page;
class YourClass{

    function __construct()
    {
        $this->page = new Page;
    }

}
```
<br>
##### 방법2 : 인라인
```php
class YourClass{

    function __construct()
    {
        $this->page = new common\Page;
    }

}
```




<br>
<br>
<br>

## 라이센스
재판매 및 수정 후 재판매는 할 수 없습니다. 프레임워크 사용으로 인하여 발생하는 모든 피해는 사용자에게 있습니다.
<br>
<br>
<br>
