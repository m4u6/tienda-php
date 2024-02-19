# Tienda PHP
## Como instalar

1. Clonar el repositorio
```
git clone https://github.com/m4u6/tienda-php.git
```
2. Levantar el docker compose
```
cd tienda-php/ && docker-compose up -d
```

3. Crear carpeta para las imagenes del producto y los logs
```
docker exec tienda-php_php_1 bash -c "mkdir /var/www/php-shop/public/assets/img"
docker exec tienda-php_php_1 bash -c "mkdir /var/www/php-shop/logs"
```

3. Cambiar el dueño de las carpetas para imagenes de producto y logs.
```
docker exec tienda-php_php_1 bash -c "chown www-data:www-data -R /var/www/php-shop/logs/"
docker exec tienda-php_php_1 bash -c "chown www-data:www-data -R /var/www/php-shop/public/assets/img/"
```