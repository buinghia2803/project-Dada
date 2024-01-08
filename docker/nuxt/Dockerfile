# base image
FROM node:12-alpine as builder

WORKDIR /www/html

COPY . .

RUN yarn install \
  --prefer-offline \
  --frozen-lockfile \
  --non-interactive \
  --production=false

# RUN yarn build

RUN rm -rf node_modules && \
  NODE_ENV=local yarn install \
  --prefer-offline \
  --pure-lockfile \
  --non-interactive \
  --production=false

# FROM node:12-alpine

# WORKDIR /www/html

# COPY --from=builder /www/html  .

# ENV HOST 0.0.0.0
#EXPOSE 9089

CMD ["yarn", "dev" ]
