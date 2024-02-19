-- Creamos la base de datos si no existe
CREATE DATABASE IF NOT EXISTS tienda_db;
USE tienda_db;

-- TABLAS

-- Tabla users
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    u_password VARCHAR(64),
    u_name VARCHAR(255),
    u_surname VARCHAR(255),
    u_phone VARCHAR(20),
    u_email VARCHAR(255),
    u_address VARCHAR(255),
    default_address VARCHAR(255),
    billing_address VARCHAR(255),
    is_admin BOOLEAN,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Tabla productos
CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    p_name VARCHAR(255),
    p_description TEXT,
    price DECIMAL(10, 2),
    p_rating DECIMAL(3, 2),
    stock INT,
    is_hidden BOOLEAN,
    seo_name VARCHAR(255),
    default_img_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla imagenes
CREATE TABLE IF NOT EXISTS images (
    img_id INT AUTO_INCREMENT PRIMARY KEY,
    img_location VARCHAR(255),
    img_name VARCHAR(255),
    img_placeholder VARCHAR(255),
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);


-- Tabla categorias
CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(255),
    cat_description TEXT,
    cat_parent_id INT,
    img_id INT,
    seo_name VARCHAR(255),
    FOREIGN KEY (cat_parent_id) REFERENCES categories(category_id),
    FOREIGN KEY (img_id) REFERENCES images(img_id)
);


-- Tabla productos-categorias
CREATE TABLE IF NOT EXISTS products_categories (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Tabla filtros
CREATE TABLE IF NOT EXISTS filters (
    filter_id INT AUTO_INCREMENT PRIMARY KEY,
    filter_name VARCHAR(255),
    filter_desc TEXT
);

-- Tabal productos-filtros
CREATE TABLE IF NOT EXISTS products_filters (
    product_id INT,
    filter_id INT,
    PRIMARY KEY (product_id, filter_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (filter_id) REFERENCES filters(filter_id)
);



-- Tabla promociones
CREATE TABLE IF NOT EXISTS deals (
    deal_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    category_id INT,
    percentage_discount DECIMAL(5, 2),
    absolute_discount DECIMAL(5, 4),    -- 100% descuento deberia guardarse como 1
    promo_code VARCHAR(12),
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    exp_date TIMESTAMP,
    max_deals INT,      -- numero de veces totales que se puede aplicar una promocion. Hacer un trigger para cada vez que se añada una entrada en orders?
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);



-- Tabla pedidos
CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    checkout_price DECIMAL(10, 2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_address VARCHAR(255),
    deal_id INT,
    status ENUM('procesando', 'enviado', 'pagado', 'contactar soporte', 'completado'),    -- puede que lo ideal sea tener una tabla aparte para los estados, pero no me voy a complicar por ahora
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (deal_id) REFERENCES deals(deal_id)
);

CREATE TABLE IF NOT EXISTS orders-products (
    order_product_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    price_per_unit DECIMAL(10, 2),
    quantity INT,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Tabla comentarios / ratings
CREATE TABLE IF NOT EXISTS ratings (         -- igual habria que añadir un campo para order_id , en caso de que se quieran limitar los ratings a gente que haya hecho un pedido
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    rating DECIMAL(3, 2),
    comment TEXT,
    responds_to INT,
    date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (responds_to) REFERENCES ratings(comment_id)
);


-- Trigger para actualizar p_rating en la tabla productos cuando se añada una valoracion nueva
DELIMITER //
CREATE TRIGGER update_product_rating
AFTER INSERT ON ratings
FOR EACH ROW
BEGIN
    DECLARE avg_rating DECIMAL(3, 2);

    SELECT AVG(rating) INTO avg_rating
    FROM comentarios_valoraciones
    WHERE product_id = NEW.product_id;

    UPDATE products
    SET p_rating = avg_rating
    WHERE product_id = NEW.product_id;
END;
//
DELIMITER ;



-- Tabla para mensajes de soporte / issues. -- opcional
CREATE TABLE IF NOT EXISTS support_msgs (
    msg_id INT PRIMARY KEY,
    product_id INT,
    order_id INT,
    user_id INT,
    msg_title VARCHAR(255),
    msg_body TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


