FROM nginx:1.25.4-alpine

ARG UID=1000
ARG GID=1000

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

RUN addgroup -S -g ${GID} developer && adduser developer -S -H --disabled-password -g "developer" -h /dev/null -u ${UID} -G developer

RUN chown -R developer:developer /var/cache/nginx/
RUN touch /var/run/nginx.pid && \
            chown -R developer:developer /var/run/nginx.pid

USER developer
