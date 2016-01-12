IMAGE_NAME = cursor-education/site
CONTAINER_NAME = cursor-education-site

HOME = /shared
PORT = 8080

.PHONY: all

all: clean build run

clean: remove-image remove-container

remove-image:
	docker rmi -f ${IMAGE_NAME} 2>/dev/null || true
	docker images | grep ${IMAGE_NAME} || true

remove-container:
	docker rm -f ${CONTAINER_NAME} 2>/dev/null || true
	docker ps -a

build: stop
	docker build -t ${IMAGE_NAME} .

stop:
	docker stop -f ${CONTAINER_NAME} 2>/dev/null || true

run: stop
	docker run --name=${CONTAINER_NAME} \
		-p ${PORT}:8080 \
		-v $$PWD:${HOME} \
		-ti -d \
		${IMAGE_NAME}

ssh:
	docker exec -ti ${CONTAINER_NAME} bash