# DataBase_HomeShopping
2021년도 2학기 데이터베이스 프로그래밍 수업 프로젝트로 제작되었던 레거시 웹 쇼핑몰 시스템의 현대적 리메이크 프로젝트
최신 웹 개발 표준(Docker, PHP 8.2, PDO, Bcrypt, Front Controller 라우팅)에 맞추어 전면 리팩토링

*참고: 구버전의 경우 오랜 세월이 흘러 원본 디자인용 이미지 파일들이 유실되어 엑스박스 아이콘으로 뜨는 단점*

---

## 1. 프로젝트 개요

- **프로젝트명**: MARBLE House (정육 쇼핑몰 웹 시스템)
APMSetup + PHP 기반으로 제작되었던 온라인 정육 쇼핑몰 프로젝트

### 프로젝트 현대화 목적 및 배경
- 2010년대 초반 APMSetup 및 Notepad++ 환경에서 작성되었던 레거시 PHP 5 소스코드를 최신 엔터프라이즈 환경에서 오류 없이 구동할 수 있도록 현대화
- 최신 웹 브라우저 및 운영체제와의 호환성을 확보하고, SQL Injection 및 XSS 공격, 비밀번호 평문 저장 등의 중대한 보안 취약점을 완벽히 해결
- Docker 컨테이너 가상화를 도입하여 별도의 수동 서버 설치 과정 없이 명령어 한 줄로 즉시 구동 가능한 재현성 확보

---

## 2. 구버전(Legacy) vs 현대화 버전(Modern Remake) 상세 비교

| 구분 항목 | 구버전 레거시 (old_README 참조) | 현대화 리메이크 (현재 버전) | 개선 효과 및 차이점 |
| :--- | :--- | :--- | :--- |
| **실행 환경** | APMSetup 7 (로컬 PC 직접 설치) | Docker + Docker Compose (멀티 컨테이너) | OS 종속성 없이 무설치 가동, 윈도우/맥/리눅스 어디서나 동일 구동 |
| **서버 제어** | APMSetup GUI 제어판 또는 윈도우 서비스 | Makefile (`make up`, `make down`) | 터미널 단축 명령어로 원클릭 가동, 종료, 재시작, 로그 확인 |
| **백엔드 언어** | PHP 5.x (5.2 ~ 5.6 권장) | 최신 PHP 8.2.34 (Debian Bookworm) | EOL된 구형 PHP 탈피, 최신 PHP 8.2 엔진 및 보안 패치 적용 |
| **데이터베이스 엔진** | MySQL 5.0 ( shopmall DB ) | MariaDB 10.3 ( shopmall DB ) | utf8mb4 문자셋 기본 적용, 한글 및 특수문자 완벽 호환 |
| **DB 연동 API** | mysql_* 구형 함수 (`mysql_connect` 등) | 표준 PDO (PHP Data Objects) + Prepared Statement | PHP 7/8에서 삭제된 mysql_* 함수 대체 및 SQL Injection 원천 차단 |
| **인증 / 상태 관리** | 클라이언트 브라우저 쿠키 (`SetCookie`) | 서버 사이드 메모리 세션 (`$_SESSION`) | 쿠키 변조를 통한 관리자 권한 탈취 취약점 완벽 차단 |
| **비밀번호 보안** | DB에 평문(Plaintext)으로 노출 저장 | Bcrypt 단방향 암호화 (`password_hash`) | DB 유출 시에도 회원 비밀번호 복호화 불가 |
| **비밀번호 분실 처리** | 기존 비밀번호 평문 팝업 안내 | 8자리 난수 임시 비밀번호 발급 및 해싱 갱신 | 단방향 암호화 표준 준수 및 보안성 강화 |
| **웹 보안 (XSS 방어)** | 미적용 (사용자 입력 태그 그대로 실행) | `h()` 전역 이스케이프 (`htmlspecialchars`) | 게시판 및 상품평의 악성 스크립트 실행 공격 무력화 |
| **접근 권한 제어** | 관리자 페이지 URL 직접 접근 가능 | 세션 기반 엄격한 Access Control 적용 | 비인가 사용자의 관리자 페이지 및 마이페이지 접근 차단 |
| **디렉토리 구조** | 루트 디렉토리에 50여 개 파일 평면 나열 | 기능별 6대 도메인 폴더 분리 (`product/`, `board/` 등) | README 5번 명세를 준수한 깔끔한 모듈화 (디자인 100% 보존) |
| **웹 아키텍처** | 각 파일 개별 직접 호출 및 스파게티 구조 | Front Controller 라우터 (`index.php`) & `.env` 분리 | 단일 진입점 라우팅(?r=products 등)과 환경설정 외부화 실현 |
| **우편번호 검색** | 우체국 대용량 텍스트 파일 DB 수동 적재 필요 | 카카오(다음) 공식 우편번호 API 연동 | 별도 텍스트 다운로드 없이 전국 도로명/지번 주소 100% 실시간 검색 |
| **누락 기능 복원** | 게시글수정/댓글삭제/게시판검색/회원탈퇴 누락 | mprocess, cdelete, search, withdraw 신규 구현 | 미완성으로 남아있던 4대 비즈니스 기능 완성 및 결함 해결 |
| **주문 및 포인트** | 포인트 객체 연산 버그, 주문번호 중복 버그 | 누적 포인트 정상 합산, 유니크 주문번호 생성 | 이커머스 핵심 결제 트랜잭션 정상화 |

---

## 3. 사용된 기술 스택 및 개발 환경

| 구분 | 사용 기술 / 도구 | 비고 |
| :--- | :--- | :--- |
| **Containerization** | Docker & Docker Compose | Web, MariaDB, phpMyAdmin 3개 컨테이너 오케스트레이션 |
| **Web Server** | Apache 2.4.68 (Debian) | `mod_rewrite`, `.htaccess` 보안 규칙 및 301 리다이렉트 적용 |
| **Backend Runtime** | PHP 8.2.34 (Apache Module) | PDO, PDO_MySQL, GD, mbstring 모듈 활성화 |
| **Database** | MariaDB 10.3 / MySQL 호환 | DB명: `shopmall`, character-set: `utf8mb4` |
| **DB Admin Tool** | phpMyAdmin (Latest) | 웹 브라우저 기반 GUI 데이터베이스 관리 |
| **Build Tool** | GNU Make 4.4.1 (`Makefile`) | `make up`, `make down` 등 프로젝트 라이프사이클 관리 |
| **Frontend** | HTML5, CSS, Vanilla JavaScript | 테이블 기반 프레임 레이아웃 100% 보존, 카카오 주소 API |
| **Configuration** | Dotenv (`.env`, `.env.example`) | 데이터베이스 계정 및 포트 정보 외부화 |

---

## 4. 구버전과 비교한 현대화 버전의 특징 및 장점

1. 무설치 원클릭 실행 환경 (Zero-Configuration)
   - APMSetup이나 MySQL을 윈도우에 설치할 필요 없이, Docker가 설치된 환경이라면 `make up` 명령어 한 줄로 웹 서버, 데이터베이스, phpMyAdmin이 즉시 실행됩니다.
   - 로컬 작업 폴더가 실시간으로 볼륨 마운트되므로 코드를 수정하면 브라우저 새로고침만으로 즉시 반영됩니다.
   - PC를 재부팅해도 Docker 컨테이너의 자동 재시작 정책(`restart: always`)에 따라 별도 작업 없이 바로 브라우저에서 사이트가 동작합니다.

2. 안전하고 견고한 엔터프라이즈급 보안
   - 최신 Bcrypt 알고리즘을 적용하여 비밀번호를 안전하게 단방향 해싱합니다.
   - 모든 데이터베이스 쿼리를 PDO Prepared Statement로 실행하여 파라미터 변조(SQL Injection)를 차단합니다.
   - 사용자 입력값이 출력되는 모든 뷰에 XSS 방어 필터(`h()`)를 적용하여 스크립트 탈취 공격을 방어합니다.
   - `.htaccess`를 통해 `.env`, `.git`, `schema.sql` 등 핵심 시스템 파일의 브라우저 직접 접근을 차단(403 Forbidden)합니다.

---

## 5. 실행 방법

### 사전 요구사항
- Docker Desktop 설치 및 실행

### 1단계: 컨테이너 가동
터미널에서 프로젝트 디렉토리로 이동 후 아래 명령어를 입력합니다:
```bash
# Makefile 사용 시
make up

# 또는 docker compose 직접 사용 시
docker compose up -d
```

### 2단계: 웹 브라우저 접속
- 쇼핑몰 메인 페이지: http://localhost:8080
- 데이터베이스 관리도구 (phpMyAdmin): http://localhost:8081

### 3단계: 편리한 Makefile 단축 명령어 목록
- `make up` : 컨테이너 백그라운드 가동
- `make down` : 컨테이너 안전 종료 (데이터 보존)
- `make restart` : 컨테이너 빠른 재시작
- `make ps` : 실행 중인 컨테이너 상태 점검
- `make logs` : 전체 실시간 로그 모니터링
- `make shell` : 웹 서버 컨테이너 내부 쉘 접속
- `make db` : MariaDB CLI 콘솔 직접 접속
- `make clean` : 컨테이너 및 DB 볼륨 데이터 완전 초기화

---

## 6. 관리자 및 기본 계정 정보

| 구분 | 아이디 (ID) | 비밀번호 (PW) | 권한 및 기능 |
| :--- | :--- | :--- | :--- |
| **관리자 (Admin)** | **`admin`** | **`apmsetup`** | 로그인 시 사이드바에 [관리메뉴] 활성화 (상품 등록/수정/삭제, 주문 관리, 회원 승인 관리) |

- 계정 정보 저장 위치:
  1. 실제 런타임: `shopmall` DB의 `member` 테이블 (`uid = 'admin'`)
  2. 스키마 파일: `schema.sql` (Line 130)
  3. 환경 설정: `.env` 및 `docker-compose.yml` (`DB_PASS=apmsetup`)
  4. PHP 기본값: `config/database.php`

---

## 7. 프로젝트 디렉토리 구조 (54개 파일 도메인 분리 체계)

```plaintext
├── .env / .env.example     # 환경변수 설정 파일
├── .htaccess               # Apache 보안 규칙 및 301 리다이렉트
├── Dockerfile              # PHP 8.2 웹 컨테이너 빌드 명세
├── docker-compose.yml      # 멀티 컨테이너 오케스트레이션
├── Makefile                # make up / make down 단축 실행 도구
├── index.php               # Front Controller 단일 진입점 라우터 (?r=products 등)
├── top.php, left.php, bottom.php # 공통 레이아웃 (상단, 좌측, 하단)
├── join.php, join2.php     # 회원가입 약관 및 폼 (카카오 주소 연동)
├── schema.sql              # 9개 테이블 복원 DDL 및 관리자 시드 데이터
├── photo/                  # 상품 이미지 업로드 디렉토리
├── pds/                    # 고객 게시판 첨부파일 업로드 디렉토리
├── docs/                   # 원본 과제 요구사항 텍스트 보관 폴더
├── old_README.md           # 구버전 원본 README 보존 파일
├── 수정사항.txt            # Step 0 ~ Step 9 단계별 리팩토링 상세 기록
│
├── config/                 # 시스템 공통 설정
│   ├── bootstrap.php       # 세션 초기화, .env 파서, XSS 방어(h) 헬퍼
│   └── database.php        # PDO 싱글톤 및 PHP 8 호환 래퍼 계층
│
├── product/                # [상품 관리 도메인]
│   ├── p-list.php          # 메인 상품 진열 및 카테고리별 출력
│   ├── p-show.php          # 상품 상세 정보 보기 및 리뷰/별점
│   ├── p-search.php        # 상품 키워드 검색
│   ├── p-memo.php          # 상품 한줄평 및 별점 등록
│   ├── p-input.php         # [관리자] 신규 상품 등록 폼
│   ├── p-process.php       # [관리자] 신규 상품 DB 저장 (PHP 8.2 $_FILES 업로드)
│   ├── p-adminlist.php     # [관리자] 상품 목록 관리 대시보드
│   ├── p-modify.php        # [관리자] 상품 수정 폼
│   ├── p-modify2.php       # [관리자] 상품 수정 DB 저장
│   ├── p-delete.php        # [관리자] 상품 삭제 확인 폼
│   └── p-delete2.php       # [관리자] 상품 삭제 DB 처리
│
├── member/                 # [회원 및 인증 도메인]
│   ├── login.php           # 세션 기반 로그인 처리
│   ├── logout.php          # 세션 파기 및 로그아웃
│   ├── register.php        # 회원가입 처리 (Bcrypt 암호화)
│   ├── withdraw.php        # [신규] 회원 탈퇴 처리
│   ├── id_check.php        # 아이디 중복 확인 팝업
│   ├── findidpw.php        # 아이디/비밀번호 찾기 폼
│   ├── findid.php          # 아이디 조회
│   ├── findpw.php          # 임시 비밀번호 난수 발급
│   ├── zipcode.php         # 우편번호 검색 팝업
│   └── zip-process.php     # 우편번호 검색 처리 (UTF-8)
│
├── cart/                   # [장바구니 및 주문/결제 도메인]
│   ├── tobag.php           # 장바구니 담기
│   ├── showbag.php         # 장바구니 목록 보기
│   ├── q-modift.php        # 장바구니 수량 변경
│   ├── itemdelete.php      # 장바구니 품목 삭제
│   ├── buy.php             # 주문서 작성 페이지
│   ├── endshopping.php     # 최종 결제 및 포인트 적립 (유니크 주문번호)
│   ├── register2.php       # 배송지 정보 수정
│   ├── zipcode2.php        # 주문 배송지 우편번호 검색
│   └── zip2-process.php    # 주문 배송지 우편번호 검색 처리
│
├── mypage/                 # [마이페이지 도메인]
│   ├── mypage.php          # 마이페이지 메인 (포인트, 주문조회, 탈퇴버튼)
│   ├── detailview.php      # 주문 상세 조회
│   ├── ordercancel.php     # 주문 취소 처리
│   └── imodify.php         # 회원 정보 수정
│
├── admin/                  # [관리자 전용 도메인]
│   ├── admin.php           # 관리자 대시보드 메인
│   ├── orderlist.php       # 전체 주문 내역 조회
│   ├── changestatus.php    # 배송 상태 변경 처리
│   ├── membershow.php      # 전체 회원 목록 조회
│   └── memberchange.php    # 회원 승인 상태 변경
│
└── board/                  # [고객 게시판 도메인]
    ├── show.php            # 게시판 글 목록
    ├── input.php           # 게시글 작성 폼
    ├── process.php         # 게시글 등록 DB 처리
    ├── content.php         # 게시글 본문 및 댓글 목록 (XSS 방어)
    ├── memo.php            # 게시글 댓글 등록
    ├── modify.php          # 게시글 수정 폼
    ├── mprocess.php        # [신규] 게시글 수정 DB 처리
    ├── delete.php          # 게시글 삭제 처리
    ├── pass.php, pass2.php # 글 수정/삭제 비밀번호 검증
    ├── cpass.php, cpass2.php # 댓글 삭제 비밀번호 검증
    ├── cdelete.php         # [신규] 댓글 삭제 처리
    └── search.php          # [신규] 게시판 키워드 검색
```
