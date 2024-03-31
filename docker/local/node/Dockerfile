FROM node:20-buster

RUN mkdir /front
RUN mkdir /front/vue
RUN mkdir /front/webroot
WORKDIR /front/vue

ENV NODE_ENV development

COPY frontend/package.json /front/vue/package.json
COPY frontend/package-lock.json /front/vue/package-lock.json

RUN npm install

EXPOSE 5173
