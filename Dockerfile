# Use a PHP base image
FROM php:latest

# Create .env file
RUN echo 'APP_ENV=local\nDB_HOST=ep-plain-dust-a2execv7.eu-central-1.pg.koyeb.app\nDB_PORT=5432\nDB_USER=koyeb-adm\nDB_PASSWORD=WTPl9gUrLtx5\nDB_NAME=koyebdb\nDB_CHARSET=utf8mb4\nDB_COLLATION=utf8mb4_general_ci' > .env
