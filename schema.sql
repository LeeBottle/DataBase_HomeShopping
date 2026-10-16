-- ============================================================================
-- MARBLE House Database Schema & Sample Data
-- Database: shopmall
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `shopmall` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `shopmall`;

-- ----------------------------------------------------------------------------
-- 1. member : 회원 정보 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
    `uid` VARCHAR(30) NOT NULL COMMENT '회원 아이디',
    `upass` VARCHAR(255) NOT NULL COMMENT '비밀번호',
    `uname` VARCHAR(50) NOT NULL COMMENT '회원 이름',
    `mphone` VARCHAR(25) DEFAULT '' COMMENT '휴대전화 번호',
    `email` VARCHAR(100) DEFAULT '' COMMENT '이메일 주소',
    `zipcode` VARCHAR(10) DEFAULT '' COMMENT '우편번호',
    `addr1` VARCHAR(150) DEFAULT '' COMMENT '기본 주소',
    `addr2` VARCHAR(150) DEFAULT '' COMMENT '상세 주소',
    `approved` INT DEFAULT 0 COMMENT '관리자 승인 여부 (1: 승인, 0: 미승인)',
    `point` INT DEFAULT 0 COMMENT '적립금 포인트',
    PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='회원 정보';

-- ----------------------------------------------------------------------------
-- 2. product : 상품 정보 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
    `code` VARCHAR(30) NOT NULL COMMENT '상품 고유 코드',
    `class` INT NOT NULL DEFAULT 1 COMMENT '카테고리 (1:Beef, 2:Pork, 3:Chicken, 4:Others, 5:Processed)',
    `name` VARCHAR(100) NOT NULL COMMENT '상품명',
    `content` TEXT COMMENT '상품 상세 설명',
    `contry` VARCHAR(50) DEFAULT '' COMMENT '원산지',
    `price1` INT NOT NULL DEFAULT 0 COMMENT '시중가',
    `price2` INT NOT NULL DEFAULT 0 COMMENT '할인/판매가',
    `userfile` VARCHAR(150) DEFAULT '' COMMENT '상품 이미지 파일명',
    `hit` INT NOT NULL DEFAULT 0 COMMENT '조회수/인기순위',
    PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='상품 정보';

-- ----------------------------------------------------------------------------
-- 3. productmemo : 상품 리뷰 및 별점 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `productmemo`;
CREATE TABLE `productmemo` (
    `num` INT NOT NULL AUTO_INCREMENT COMMENT '리뷰 고유 번호',
    `code` VARCHAR(30) NOT NULL COMMENT '상품 코드',
    `id` VARCHAR(30) NOT NULL COMMENT '작성자 회원 ID',
    `name` VARCHAR(50) NOT NULL COMMENT '작성자 이름',
    `passwd` VARCHAR(255) DEFAULT '' COMMENT '리뷰 비밀번호',
    `message` TEXT NOT NULL COMMENT '리뷰 내용',
    `star` INT NOT NULL DEFAULT 5 COMMENT '별점 평점 (1~5)',
    `wdate` VARCHAR(30) NOT NULL COMMENT '작성 일시',
    PRIMARY KEY (`num`),
    KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='상품 한줄 리뷰 및 평점';

-- ----------------------------------------------------------------------------
-- 4. shoppingbag : 장바구니 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `shoppingbag`;
CREATE TABLE `shoppingbag` (
    `session` VARCHAR(100) NOT NULL COMMENT '세션 ID',
    `pcode` VARCHAR(30) NOT NULL COMMENT '상품 코드',
    `id` VARCHAR(30) DEFAULT '' COMMENT '회원 ID (비회원 가능)',
    `quantity` INT NOT NULL DEFAULT 1 COMMENT '구매 수량',
    PRIMARY KEY (`session`, `pcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='장바구니';

-- ----------------------------------------------------------------------------
-- 5. receivers : 주문 및 배송 수령인 정보 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `receivers`;
CREATE TABLE `receivers` (
    `ordernum` VARCHAR(50) NOT NULL COMMENT '주문번호',
    `id` VARCHAR(30) NOT NULL COMMENT '주문자 회원 ID',
    `session` VARCHAR(100) NOT NULL COMMENT '주문 당시 세션 ID',
    `sender` VARCHAR(50) NOT NULL COMMENT '주문자 이름',
    `receiver` VARCHAR(50) NOT NULL COMMENT '수령인 이름',
    `phone` VARCHAR(25) NOT NULL COMMENT '수령인 연락처',
    `address` TEXT NOT NULL COMMENT '배송지 주소',
    `message` TEXT COMMENT '배송 요청사항',
    `buydate` VARCHAR(30) NOT NULL COMMENT '주문 일시',
    `status` INT NOT NULL DEFAULT 1 COMMENT '배송 상태 (1:결제완료, 2:배송준비, 3:배송중, 4:배송완료)',
    PRIMARY KEY (`ordernum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='주문 및 배송 정보';

-- ----------------------------------------------------------------------------
-- 6. orderlist : 상세 주문 품목 내역 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `orderlist`;
CREATE TABLE `orderlist` (
    `num` INT NOT NULL AUTO_INCREMENT COMMENT '주문 상세 고유번호',
    `ordernum` VARCHAR(50) DEFAULT '' COMMENT '주문번호',
    `session` VARCHAR(100) NOT NULL COMMENT '세션 ID',
    `id` VARCHAR(30) NOT NULL COMMENT '회원 ID',
    `pcode` VARCHAR(30) NOT NULL COMMENT '상품 코드',
    `quantity` INT NOT NULL DEFAULT 1 COMMENT '주문 수량',
    PRIMARY KEY (`num`),
    KEY `idx_session` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='주문 상세 품목 내역';

-- ----------------------------------------------------------------------------
-- 7. zipcode : 우편번호 검색 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `zipcode`;
CREATE TABLE `zipcode` (
    `num` INT NOT NULL AUTO_INCREMENT COMMENT '고유번호',
    `zipcode` VARCHAR(10) NOT NULL COMMENT '우편번호',
    `sido` VARCHAR(30) NOT NULL COMMENT '시/도',
    `gugun` VARCHAR(30) NOT NULL COMMENT '구/군',
    `dong` VARCHAR(50) NOT NULL COMMENT '읍/면/동',
    `bunji` VARCHAR(50) DEFAULT '' COMMENT '번지/건물번호',
    PRIMARY KEY (`num`),
    KEY `idx_dong` (`dong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='우편번호';

-- ----------------------------------------------------------------------------
-- 8. board : 고객 게시판 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `board`;
CREATE TABLE `board` (
    `id` INT NOT NULL COMMENT '게시글 번호',
    `writer` VARCHAR(50) NOT NULL COMMENT '작성자 이름',
    `email` VARCHAR(100) DEFAULT '' COMMENT '작성자 이메일',
    `passwd` VARCHAR(255) NOT NULL COMMENT '비밀번호',
    `topic` VARCHAR(200) NOT NULL COMMENT '게시글 제목',
    `content` TEXT NOT NULL COMMENT '게시글 내용',
    `hit` INT NOT NULL DEFAULT 0 COMMENT '조회수',
    `wdate` VARCHAR(30) NOT NULL COMMENT '작성 일시',
    `space` INT NOT NULL DEFAULT 0 COMMENT '답글 들여쓰기 깊이',
    `filename` VARCHAR(150) DEFAULT '' COMMENT '첨부 파일명',
    `filesize` VARCHAR(30) DEFAULT '' COMMENT '첨부 파일 크기',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='고객 게시판';

-- ----------------------------------------------------------------------------
-- 9. boardmemo : 고객 게시판 댓글 테이블
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `boardmemo`;
CREATE TABLE `boardmemo` (
    `num` INT NOT NULL AUTO_INCREMENT COMMENT '댓글 고유 번호',
    `id` INT NOT NULL COMMENT '게시글 번호 (board.id)',
    `name` VARCHAR(50) NOT NULL COMMENT '댓글 작성자',
    `passwd` VARCHAR(255) DEFAULT '' COMMENT '댓글 비밀번호',
    `message` TEXT NOT NULL COMMENT '댓글 내용',
    `wdate` VARCHAR(30) NOT NULL COMMENT '댓글 작성 일시',
    PRIMARY KEY (`num`),
    KEY `idx_board_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='고객 게시판 댓글';


-- ============================================================================
-- 초기 기본 데이터 (Seed Data)
-- ============================================================================

-- 1. 관리자 계정 생성 (admin / apmsetup)
INSERT INTO `member` (`uid`, `upass`, `uname`, `mphone`, `email`, `zipcode`, `addr1`, `addr2`, `approved`, `point`) VALUES
('admin', 'apmsetup', '관리자', '010-1234-5678', 'admin@marblehouse.com', '06236', '서울특별시 강남구 테헤란로 152', '마블빌딩 10층', 1, 10000);

-- 2. 기본 우편번호 데이터
INSERT INTO `zipcode` (`zipcode`, `sido`, `gugun`, `dong`, `bunji`) VALUES
('06236', '서울특별시', '강남구', '역삼동', '737'),
('06237', '서울특별시', '강남구', '역삼동', '738'),
('04524', '서울특별시', '중구', '태평로1가', '31'),
('03045', '서울특별시', '종로구', '청진동', '149');
