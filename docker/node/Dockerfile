FROM node:18.20.2-alpine3.19

ARG UID=1000
ARG GID=1000

RUN apk --update add wget \
    curl \
    git \
    shadow

WORKDIR /var/www

RUN usermod --uid ${UID} --gid ${GID} node

USER node

CMD yarn install && yarn dev
