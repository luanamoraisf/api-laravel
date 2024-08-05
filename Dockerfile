FROM node:18 AS build-stage

WORKDIR /var/www

COPY package.json ./

RUN npm install

COPY . .

RUN npm run build

# ---------------------------------------------------------------

FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libxml2-dev

# Instala extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instala o Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Copia os arquivos do projeto para o contêiner
COPY . /var/www

# Copia o build do Vite
COPY --from=build-stage /var/www/public/build /var/www/public/build

# Define o diretório de trabalho
WORKDIR /var/www

# Instala as dependências do projeto Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Ajusta permissões para diretórios críticos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Gera chave de aplicação
RUN php artisan key:generate

# Limpa o cache do Laravel
RUN php artisan config:cache

# Expõe a porta para o contêiner
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
