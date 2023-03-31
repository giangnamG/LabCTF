FROM nginx:latest
RUN apt-get update && apt-get upgrade -y vim
COPY ./config/nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80