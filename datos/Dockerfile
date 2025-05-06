# Dockerfile para crear una imagen de PHP con Apache y Composer

FROM php:apache

#establesco esa carpete como la carpeta de trabajo del contenedor osea 
# Exacto! /var/www/html es el directorio predeterminado donde Apache busca los archivos que debe servir como parte de tu aplicación web. Esto significa que:
#     Archivos del proyecto: Todos los archivos de tu aplicación web (como HTML, PHP, CSS, JavaScript, etc.) deben estar en ese directorio para que Apache pueda servirlos al navegador.  
#     Comandos ejecutados: Cualquier comando que uses después de la línea WORKDIR /var/www/html en el Dockerfile (como COPY, RUN, etc.) se ejecutará en ese directorio, a menos que especifiques otro.
WORKDIR /var/www/html 

# esto es par a instalar las extensiones de php que se necesitan para el proyecto
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql mysqli

# esto es para descargar el manejador de paquetes de php composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" && \
php composer-setup.php && \
php -r "unlink('composer-setup.php');" && \
mv composer.phar /usr/local/bin/composer 

# esto copia el archivo de configuracion de apache y el archivo de configuracion de composer.json (al contenedor desde tu máquina local al contenedor) 
# ademas recordar que estos archivos deben estar en la misma carpeta que el Dockerfile y ya listos para ser copiados
COPY ./datos/composer.json .
COPY ./datos/.htaccess .


# intala git y zip para poder descargar el proyecto desde github y descomprimirlo y ademas instala las dependencias de composer
RUN apt-get update && apt-get install -y zip && \
apt-get update && apt-get install -y git


#esto es para que se instale el composer osea el manejador de paquetes de php y se instalen las dependencias que se encuentran en el archivo composer.json
RUN composer install 

#Este comando le dice a Composer que regenere el archivo de autoload, lo que asegura que las clases de PHP se carguen correctamente.
RUN composer dump-autoload 


#Este comando utiliza sed, una herramienta de edición de texto, para cambiar la configuración de Apache. Lo que hace es modificar el archivo 000-default.conf de Apache para que el document root (la carpeta desde donde Apache servirá los archivos) apunte a /var/www/html/public.
RUN sed -i 's/DocumentRoot.*$/DocumentRoot \/var\/www\/html\/public/' /etc/apache2/sites-enabled/000-default.conf
