# NginX image with netstat install

FROM nginx:latest

RUN rm /etc/nginx/conf.d/default.conf

ADD ./nginx.conf /etc/nginx/conf.d/nginx.conf

RUN apt-get update \
	&& apt-get install -y net-tools
