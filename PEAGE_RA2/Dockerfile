# Utilisation de l'image officielle PHP avec Apache
FROM php:8.3-apache

# Mise à jour et installation des dépendances utiles
RUN apt update && apt upgrade -y && apt install -y \
    apt-transport-https \
    gnupg2 \
    unixodbc-dev \
    curl \
    libldap2-dev \
    && rm -rf /var/lib/apt/lists/*


# Télécharger et ajouter la clé GPG de Microsoft
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -

# Ajouter le référentiel Microsoft SQL Server
RUN curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list -o /etc/apt/sources.list.d/mssql-release.list

# Mettre à jour la liste des paquets et installer les outils MS SQL Server
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y \
    msodbcsql18 \
    mssql-tools18

# Installation du driver ODBC Microsoft
RUN apt update && ACCEPT_EULA=Y apt install -y msodbcsql18

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install mysqli \
 && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
 && docker-php-ext-install ldap \
 && docker-php-ext-configure opcache --enable-opcache \
 && docker-php-ext-install opcache \
 && docker-php-ext-install pdo \
 && docker-php-ext-install pdo_mysql

# Installation des extensions pour SQL Server via PECL
RUN pecl install sqlsrv pdo_sqlsrv \
 && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Configuration personnalisée d'Apache et PHP
COPY BUILD/PHP/php.ini /usr/local/etc/php/php.ini
COPY BUILD/APACHE2/sites-available/001-intranet.conf /etc/apache2/sites-available/
COPY BUILD/APACHE2/sites-available/001-intranet.conf /etc/apache2/sites-enabled/
COPY BUILD/APACHE2/conf-available/ /etc/apache2/conf-available/
COPY BUILD/APACHE2/conf-enabled/ /etc/apache2/conf-enabled/

# Activation éventuelle des modules Apache requis
RUN a2enmod rewrite ldap

# Suppression de la conf Apache par défaut
RUN rm /etc/apache2/sites-available/000-default.conf && rm -rf /var/www/html

# Copie du code applicatif
COPY BUILD/SRC/ /var/www/
RUN mkdir /var/www/log/

# Exposition du port
EXPOSE 80

# Lancement du service Apache
CMD ["apache2ctl", "-D", "FOREGROUND"]
