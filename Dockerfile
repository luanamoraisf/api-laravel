# Use a imagem base php:8.1-fpm
FROM php:8.1-fpm

# Instale pacotes do sistema necessários e extensões do PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instale o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www

# Copie todos os arquivos do projeto para o contêiner antes de instalar as dependências do Composer
COPY . .

# Instale as dependências do Composer (defina a variável para permitir superuser)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissões (se necessário)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Exponha a porta (não necessário se não houver necessidade de acesso direto)
EXPOSE 9000
