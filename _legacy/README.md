# DataBase_HomeShopping
2021년도 2학기 데이터베이스 프로그래밍 수업 프로젝트


##  1. 프로젝트 개요

- **프로젝트명**: MARBLE House (정육 쇼핑몰 웹 시스템)
APMSetup + PHP 기반으로 제작되었던 온라인 정육 쇼핑몰 프로젝트

### 프로젝트 배경 및 핵심 목적 (대학 과제: 데이터베이스의 이해)
본 프로젝트는 대학교 **2021년도 2학기 '데이터베이스 프로그래밍' 과목의 텀 프로젝트(Term Project)**로 진행

본 과제의 궁극적인 목적은 단순히 화려한 웹 서비스를 구축하는 것이 아니라, **관계형 데이터베이스(RDBMS, Relational Database Management System)의 핵심 원리와 동작 구조를 심도 있게 이해하고 실습하는 것**에 있었습니다.

1. **로우 레벨(Low-level) 데이터베이스 조작 이해**
   - 본 과제에서는 **Notepad++** 텍스트 에디터와 **PHP + SQL(Raw Query)** 방식을 채택하여, 웹 애플리케이션과 MySQL 데이터베이스가 실제로 어떻게 통신하고 데이터를 교환하는지 밑바닥부터 직접 설계하고 구현
2. **관계형 데이터 모델링 및 정규화 실습**
   - 실제 이커머스(정육 쇼핑몰) 비즈니스 도메인을 분석하여, 회원, 상품, 장바구니, 주문서, 배송지, 후기, 게시판 등 9개의 테이블을 설계
   - 중복 데이터를 최소화하고 데이터 무결성을 유지하기 위한 정규화 원리를 체득
3. **실무적 CRUD와 비즈니스 트랜잭션 흐름 체득**
   - 회원 가입 및 인증(중복 체크, 관리자 승인)
   - 비회원/회원 세션(Session) 기반 장바구니 및 구매 전환
   - 주문 생성 시 수령인 정보(`receivers`)와 세부 주문 품목(`orderlist`)으로 분리 적재되는 1:N 관계 처리
   - 주문 상태 변경, 적립금(Point) 누적 등 실제 데이터의 삽입(`INSERT`), 조회(`SELECT`), 수정(`UPDATE`), 삭제(`DELETE`) 과정을 손수 작성하며 DB의 라이프사이클을 깊이 있게 이해했습니다.

---

## 2. 개발 환경 및 사용 기술

| 구분 | 사용 기술 / 도구 | 목적 및 비고 |
| :--- | :--- | :--- |
| **Course** | 2021년 2학기 데이터베이스 프로그래밍 | 학부 전공 텀프로젝트 |
| **Database** | **MySQL (v5.x)** | 데이터베이스 설계, 테이블 명세, 관계 설정, Raw SQL 쿼리 작성 |
| **Server / Backend** | **APMSetup (Apache + PHP 5.x)** | 로컬 웹 서버 구동 및 `mysql_*` 네이티브 드라이버를 통한 DB 연동 |
| **Editor** | **Notepad++** | 프레임워크 없이 순수 HTML, PHP, JavaScript, CSS 파일 직접 코딩 |
| **Frontend** | **HTML4/5, CSS, JavaScript** | 프레임셋 기반 UI 렌더링 및 클라이언트 사이드 폼 검증 |

- **로컬 DB 기본 접속 정보**:
  - Host: `localhost`
  - User: `root`
  - Password: `apmsetup`
  - Database: `shopmall`

---

## 3. 데이터베이스 구조 (Database Schema)

본 프로젝트는 쇼핑몰 운영에 필요한 핵심 데이터들을 체계적으로 관리하기 위해 `shopmall` 데이터베이스를 생성하고 총 9개의 테이블로 관계형 모델을 구축

### MySQL CLI 테이블 조회

```sql
mysql> use shopmall;
Database changed
mysql> show tables;
+---------------------+
| Tables_in_shopmall  |
+---------------------+
| board               |
| boardmemo           |
| member              |
| orderlist           |
| product             |
| productmemo         |
| receivers           |
| shoppingbag         |
| zipcode             |
+---------------------+
9 rows in set (0.00 sec)
```

---

### 테이블별 상세 설계 명세

| 번호 | 테이블명 (`Table`) | 담당 도메인 | 주요 필드 (Columns) | DB 설계 목적 및 핵심 역할 |
|:---:|:---|:---|:---|:---|
| **1** | **`member`** | 회원 관리 | `uid`, `upass`, `uname`, `mphone`, `email`, `zipcode`, `addr1`, `addr2`, `point`, `approved` | 쇼핑몰 회원 계정 정보. 비밀번호, 적립금 포인트(`point`), 그리고 관리자 승인 여부(`approved`) 플래그를 통한 인가 제어 |
| **2** | **`product`** | 상품 마스터 | `class`, `code`, `name`, `content`, `contry`, `price1`, `price2`, `userfile`, `hit` | 5대 카테고리(Beef, Pork, Chicken, Others, Processed), 상품 코드, 상품명, 원산지, 가격(정가/할인가), 이미지 파일명, 조회수 관리 |
| **3** | **`productmemo`** | 상품 리뷰 및 평점 | `code`, `name`, `id`, `passwd`, `message`, `star`, `wdate` | 상품 코드(`code`)를 외래 참조하여 고객이 남긴 한줄 후기 및 1~5점 별점(`star`) 평가 저장 |
| **4** | **`shoppingbag`**| 장바구니 | `id`, `session`, `pcode`, `quantity` | 로그인 유저(`id`) 또는 브라우저 세션(`session`) 단위로 담긴 상품 코드와 수량 임시 보관 |
| **5** | **`receivers`** | 주문 기본 / 배송 | `ordernum`, `id`, `session`, `sender`, `receiver`, `phone`, `address`, `message`, `buydate`, `status` | 주문 마스터 테이블. 고유 주문번호(`ordernum`), 주문자, 수령인 배송지 정보, 결제일자 및 배송 상태(`status`: 입금/배송/완료) 관리 |
| **6** | **`orderlist`** | 세부 주문 품목 | `id`, `session`, `pcode`, `quantity` | `receivers`와 `session` 키로 결합되는 1:N 상세 주문 목록. 실제 주문 완료된 개별 상품 코드와 수량 영구 기록 |
| **7** | **`zipcode`** | 우편번호 마스터 | `zipcode`, `area1`, `area2`, `area3`, `area4` | 회원가입 및 주문 배송지 입력을 위한 전국 시/도, 구/군, 동/리 우편번호 주소 참조 테이블 |
| **8** | **`board`** | Q&A 고객 게시판 | `id`, `writer`, `email`, `passwd`, `topic`, `content`, `hit`, `wdate`, `space`, `filename`, `filesize` | 쇼핑몰 고객 문의 게시글 관리. 비밀번호 인증 기반 수정/삭제, 파일 첨부 기능 지원 |
| **9** | **`boardmemo`** | 게시글 댓글 | `id`, `name`, `passwd`, `message`, `wdate` | 게시판 원글 번호(`id`)를 참조하여 관리자 또는 타 사용자가 남긴 문의 답변 및 댓글 데이터 |

---

###  데이터 관계 및 비즈니스 데이터 흐름 (Entity Relationship)

```plaintext
   [member] (회원정보, 포인트)
      │
      ├───────────────────────────────┐
      │ (1:N)                         │ (1:N)
      ▼                               ▼
 [shoppingbag] (임시 장바구니)      [receivers] (주문 마스터 / 배송정보)
   (session 단위)                      │ ordernum / session
      │                               │ (1:N)
      │ 결제 전환 시 전이                ▼
      └─────────────────────────► [orderlist] (상세 주문 품목 내역)
                                      ▲
                                      │ pcode 참조
                                [product] (상품 마스터: Beef, Pork 등)
                                      │
                                      │ (1:N) code 참조
                                      ▼
                                [productmemo] (구매 후기 & 별점)

 [board] (고객 Q&A 게시글) ──(1:N id 참조)──► [boardmemo] (게시글 답변/댓글)
 [zipcode] (우편번호 검색 데이터) ──────────► [member], [receivers] 주소 연동
```

1. **주문 트랜잭션의 테이블 분리 (1:N 정규화 모델링)**
   - 하나의 주문(`receivers`)에 여러 개의 상품 품목(`orderlist`)이 담길 수 있는 다대일/일대다 관계를 정확히 이해하고 정규화하여 설계
   - 주문이 성공적으로 체결되면 `shoppingbag`에 임시 저장되어 있던 데이터가 `orderlist`로 정식 전환되고 쇼핑백 테이블은 비움
2. **세션(Session) 키를 활용한 데이터 무결성 유지**
   - 비회원과 회원 모두 고유 `session` ID를 부여하여 장바구니 담기 및 주문 절차를 매끄럽게 연결하도록 설계
3. **상품-후기 간의 외래 참조 관계**
   - `product` 테이블의 상품 고유 코드(`code`)를 `productmemo`가 참조함으로써 특정 상품에 종속적인 리뷰 리스트 및 평균 평점을 계산

---

## 4. 시스템 주요 기능

### 사용자 (고객) 기능
- **메인 및 카테고리 네비게이션 (`top.html`, `p-list.php`)**
  - 상단 배너를 클릭하여 언제든 메인 홈 화면으로 복귀
  - 5개 정육 카테고리별 상품 필터링: **Beef(소고기)**, **Pork(돼지고기)**, **Chicken(닭고기)**, **Others(기타)**, **Processed(가공육)**
- **상품 검색 (`p-search.php`)**
  - 메인 우측 하단 검색창을 통한 키워드 검색 (검색어 누락 시 JavaScript Alert 방어)
- **회원 인증 시스템 (`join.html`, `join2.html`, `id_check.php`, `login.php`, `findidpw.php`)**
  - 회원가입 약관 동의 및 상세 정보 입력 폼
  - 팝업창을 통한 실시간 아이디 중복 검사
  - 우편번호 DB 연동 주소 자동 입력 (`zipcode.php`)
  - 로그인/로그아웃 세션 제어 및 아이디/비밀번호 찾기
- **장바구니 및 주문/결제 (`tobag.php`, `showbag.php`, `endshopping.php`, `buy.php`)**
  - 장바구니 상품 수량 변경 및 선택 삭제
  - 주문서 작성 및 배송지 입력
  - 상품 구매 금액에 따른 회원 적립금(Point) 지급 및 누적 처리
- **마이페이지 (`mypage.php`, `detailview.php`, `ordercancel.php`)**
  - 회원 정보 수정 및 보유 포인트 잔액 확인
  - 과거 주문 내역 목록 및 실시간 배송 진행 상태 조회
  - 주문 상세 내역 확인 및 배송 전 주문 취소
- **상품 후기 및 별점 평가 (`p-show.php`, `p-memo.php`)**
  - 구매 고객의 한줄 리뷰 작성 및 1~5점 별점 평가
- **고객 문의 게시판 (`show.php`, `input.php`, `content.php`, `memo.php`)**
  - Q&A 문의글 작성, 조회수 카운트, 첨부파일 업로드
  - 비밀번호 기반 게시글 및 댓글 수정/삭제 권한 제어

### 관리자 (Admin) 기능
- **관리자 전용 로그인 (`left.html`, `admin.php`)**
  - `admin` 계정 로그인 시 사이드바에 [관리자 메뉴] 활성화
- **상품 관리 CRUD (`p-input.php`, `p-adminlist.php`, `p-modify.php`, `p-delete.php`)**
  - 카테고리별 신규 상품 이미지 및 정보 등록
  - 등록 상품 목록 조회, 정보 수정 및 상품 삭제
- **주문 및 배송 상태 관리 (`orderlist.php`, `changestatus.php`)**
  - 전체 고객 주문 리스트 확인
  - 주문 배송 상태 단계별 변경 (`결제완료` ➔ `배송준비` ➔ `배송중` ➔ `배송완료`)
- **회원 관리 (`membershow.php`, `memberchange.php`)**
  - 전체 가입 회원 목록 및 상세 정보 열람
  - 회원 가입 승인(`approved`), 관리자 권한 부여 등 회원 상태 변경

---

## 5. 프로젝트 디렉터리 및 파일 구성 (총 54개)

```plaintext
├── top.html                # 상단 헤더 및 카테고리 네비게이션
├── bottom.html             # 하단 푸터 (고객센터 번호, 고객게시판 링크, 카피라이트)
├── left.html               # 좌측 사이드바 (로그인 폼, 마이페이지/장바구니/관리자 메뉴)
├── join.html               # 회원가입 약관 및 동의서
├── join2.html              # 회원가입 상세 정보 입력 폼
│
├── [상품 관련]
│   ├── p-list.php          # 메인 상품 진열 및 카테고리별 상품 목록
│   ├── p-show.php          # 상품 상세 정보 보기 (설명, 가격, 후기 목록)
│   ├── p-search.php        # 상품 키워드 검색 결과 페이지
│   ├── p-memo.php          # 상품 후기/별점 등록 DB 처리
│   ├── p-input.php         # [관리자] 신규 상품 등록 폼
│   ├── p-process.php       # [관리자] 신규 상품 INSERT DB 처리
│   ├── p-adminlist.php     # [관리자] 전체 등록 상품 목록 관리
│   ├── p-modify.php        # [관리자] 상품 정보 수정 폼
│   ├── p-modify2.php       # [관리자] 상품 UPDATE DB 처리
│   ├── p-delete.php        # [관리자] 상품 삭제 확인 폼
│   └── p-delete2.php       # [관리자] 상품 DELETE DB 처리
│
├── [회원 및 인증]
│   ├── login.php           # 사용자 로그인 검증 및 세션 등록
│   ├── logout.php          # 로그아웃 및 세션 종료
│   ├── id_check.php        # 아이디 중복 체크 팝업
│   ├── findidpw.php        # 아이디/비밀번호 분실 찾기 폼
│   ├── findid.php          # 아이디 조회 SELECT 처리
│   ├── findpw.php          # 임시 비밀번호 조회/발급 처리
│   ├── register.php        # 회원가입 INSERT DB 처리
│   ├── zipcode.php         # 회원가입 우편번호 검색 팝업
│   └── zip-process.php     # 우편번호 DB 검색 처리
│
├── [장바구니 및 주문/결제]
│   ├── tobag.php           # 장바구니 담기 INSERT 처리
│   ├── showbag.php         # 장바구니 담긴 품목 목록 보기
│   ├── q-modift.php        # 장바구니 수량 UPDATE 변경
│   ├── itemdelete.php      # 장바구니 선택 품목 DELETE
│   ├── endshopping.php     # 배송지 입력 및 최종 결제 폼
│   ├── buy.php             # 주문 체결(receivers, orderlist 저장) DB 처리
│   ├── register2.php       # 비회원/주문 수령인 정보 등록
│   ├── zipcode2.php        # 주문서 배송지 우편번호 검색 팝업
│   └── zip2-process.php    # 주문서 우편번호 DB 검색 처리
│
├── [마이페이지 및 회원정보]
│   ├── mypage.php          # 마이페이지 메인 (포인트 확인, 주문 목록)
│   ├── detailview.php      # 특정 주문 상세 품목 조회
│   ├── ordercancel.php     # 주문 취소 DELETE 처리
│   └── imodify.php         # 회원 개인정보 UPDATE 수정
│
├── [관리자 전용]
│   ├── admin.php           # 관리자 대시보드 메인
│   ├── orderlist.php       # 전체 고객 주문 내역 모니터링
│   ├── changestatus.php    # 주문 배송 상태 UPDATE 처리
│   ├── membershow.php      # 전체 회원 목록 조회
│   └── memberchange.php    # 회원 승인/상태 UPDATE 처리
│
└── [고객 Q&A 게시판]
    ├── show.php            # 고객 게시판 게시글 목록
    ├── input.php           # 신규 게시글 작성 폼
    ├── process.php         # 게시글 INSERT DB 처리 (파일 첨부 지원)
    ├── content.php         # 게시글 본문 보기 및 댓글 목록 출력
    ├── memo.php            # 게시글 댓글 INSERT DB 처리
    ├── pass.php            # 글 수정/삭제 비밀번호 확인 폼
    ├── pass2.php           # 글 수정/삭제 비밀번호 검증 DB 처리
    ├── cpass.php           # 댓글 삭제 비밀번호 확인 폼
    ├── cpass2.php          # 댓글 삭제 비밀번호 검증 DB 처리
    ├── modify.php          # 게시글 UPDATE 수정 폼
    └── delete.php          # 게시글 DELETE 삭제 처리
```
