# NginX image with netstat install

FROM nginx:latest

ADD ./nginx.conf /etc/nginx/conf.d/nginx.conf

RUN apt-get update \
	&& apt-get install -y net-tools
