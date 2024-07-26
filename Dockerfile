# Use a imagem base
FROM wyveo/nginx-php-fpm:php80

# Remover o arquivo de configuração padrão do nginx
RUN rm -rf /etc/nginx/conf.d/default.conf
RUN rm -rf /etc/php/8.0/fpm/pool.d/www.conf

# Copiar o arquivo de configuração personalizado
COPY servidor/default.conf /etc/nginx/conf.d/default.conf
COPY servidor/www.conf /etc/php/8.0/fpm/pool.d/www.conf


# Definir o diretório de trabalho
WORKDIR /usr/share/nginx

# Instalar dependências do Composer
COPY composer.json composer.json
COPY composer.lock composer.lock

