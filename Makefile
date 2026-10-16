# ==============================================================================
# MARBLE House - Docker Control Makefile
# ==============================================================================

.PHONY: help up down restart build ps logs logs-web logs-db shell db clean

# 기본 도움말 출력
help:
	@echo "======================================================================"
	@echo " MARBLE House - Docker Control Commands"
	@echo "======================================================================"
	@echo " make up        : Start all containers in background (Web, DB, phpMyAdmin)"
	@echo " make down      : Stop and remove all containers (data is preserved)"
	@echo " make restart   : Restart all containers"
	@echo " make build     : Rebuild Docker images and start"
	@echo " make ps        : Show container status"
	@echo " make logs      : View live logs of all containers"
	@echo " make logs-web  : View live logs of Web container (Apache/PHP 8.2)"
	@echo " make logs-db   : View live logs of DB container (MariaDB 10.3)"
	@echo " make shell     : Open bash shell in Web container"
	@echo " make db        : Open MySQL CLI in DB container"
	@echo " make clean     : Stop containers and remove volumes (Full Reset)"
	@echo "======================================================================"

# 컨테이너 실행
up:
	docker compose up -d
	@echo ""
	@echo "MARBLE House is now running!"
	@echo "  - Shop Website : http://localhost:8080"
	@echo "  - phpMyAdmin   : http://localhost:8081"

# 컨테이너 종료
down:
	docker compose down
	@echo "Containers stopped successfully."

# 컨테이너 재시작
restart:
	docker compose restart
	@echo "Containers restarted successfully."

# 이미지 재빌드 후 시작
build:
	docker compose up -d --build
	@echo "Images rebuilt and containers started."

# 컨테이너 상태 확인
ps:
	docker compose ps

# 전체 로그 실시간 확인
logs:
	docker compose logs -f

# 웹서버 로그 확인
logs-web:
	docker compose logs -f web

# 데이터베이스 로그 확인
logs-db:
	docker compose logs -f db

# 웹 컨테이너 쉘 접속
shell:
	docker exec -it marble_web bash

# MariaDB CLI 접속
db:
	docker exec -it marble_db mysql -u root -papmsetup shopmall

# 볼륨 데이터까지 완전 삭제 (주의)
clean:
	@echo "WARNING: Removing containers and database volumes..."
	docker compose down -v
	@echo "Clean completed."
