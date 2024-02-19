# Tienda PHP
## Como instalar

1. Clonar el repositorio
```
git clone https://github.com/m4u6/tienda-php.git
```

3. Crear carpeta para las imagenes del producto
```
docker exec tienda-php_php_1 bash -c "mkdir /var/www/php-shop/public/assets/img"
```

2. Cambiar el dueño de las carpetas para imagenes de producto y logs.
```
docker exec tienda-php_php_1 bash -c "chown www-data:www-data -R /var/www/php-shop/logs/"
docker exec tienda-php_php_1 bash -c "chown www-data:www-data -R /var/www/php-shop/public/assets/img/"
```