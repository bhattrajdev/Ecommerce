-- For creating Database
CREATE DATABASE SneakerStation;

-- For creating users
CREATE TABLE Users(
    users_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(200),
    email varchar(100),
    password varchar(200),
    verification_code int,
    is_verified ENUM('0','1') DEFAULT '0'
);

-- for creating color 
CREATE TABLE color(
    color_id int AUTO_INCREMENT PRIMARY KEY NOT NULL ,
    name varchar(100)
    );

-- for inserting color 
INSERT INTO color (name)
VALUES ('red'), ('blue'), ('black'), ('white'), ('green'), ('gray'), ('pink'), ('yellow'), ('brown'), ('purple'), 
('orange'), ('silver'), ('gold'), ('navy'), ('teal'), ('olive'), ('maroon'), ('beige'), ('cream'), ('turquoise'), 
('coral'), ('violet'), ('indigo'), ('magenta'), ('salmon'), ('khaki'), ('lavender'), ('ruby'), ('emerald'), 
('sapphire');

-- for creating size 
CREATE TABLE size(
    size_id int AUTO_INCREMENT PRIMARY KEY NOT NULL ,
    name varchar(100)
    );

-- for inserting size 
INSERT INTO size (name)
VALUES ('29'), ('30'), ('31'), ('32'), ('33'), ('34'), ('35'), ('36'), ('37'), ('38'), ('39'), ('40'), ('41'), ('42'), ('43'), ('44'), ('45'), ('46'), ('47'), ('48'), ('49'), ('50');

-- for creating category 
CREATE TABLE category(
    category_id int AUTO_INCREMENT PRIMARY KEY NOT NULL ,
    name varchar(100)
    );

-- for inserting category 
INSERT INTO category (name) VALUES ('male'),('women'),('kids'),('used');

-- for creating brand
CREATE TABLE brand(
    brand_id int AUTO_INCREMENT PRIMARY KEY NOT NULL ,
    name varchar(100)
    );

-- for inserting brand
INSERT INTO brand (name)
VALUES ('Nike'), ('Adidas'), ('Puma'), ('Reebok'), ('New Balance'), ('Vans'), ('Converse'), ('Under Armour'), ('Skechers'), ('ASICS'), ('Fila'), ('Salomon'), ('Merrell'), ('Brooks'), ('Lacoste'), ('Timberland'), ('Dr. Martens'), ('Mizuno'), ('Hoka One One'), ('Columbia');


-- for product table
CREATE TABLE product (
	product_id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name varchar(200),
    brand_id int NOT NULL,
    FOREIGN KEY (brand_id) REFERENCES brand(brand_id),
  	category_id int,
    FOREIGN KEY (category_id) REFERENCES category(category_id),
    slug varchar(250),
    price int NOT NULL,
    quantity int NOT NULL,
    discount int,
   	description varchar(255)
    );


-- for product variation
CREATE TABLE productvariation (
	productvariation_id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    product_id int,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
  	color_id int,
    FOREIGN KEY (color_id) REFERENCES color(color_id),
    size_id int,
    FOREIGN KEY (size_id) REFERENCES size(size_id)
    );

-- for product gallery
CREATE TABLE productgallery(
    id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    product_id int,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    name varchar(100)
    );



-- for admin table
CREATE TABLE admin (
    admin_id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    email varchar(100),
    password varchar(100)
    );

-- admin query
INSERT INTO admin (email,password)VALUES('devrajbhatt010@gmail.com',MD5('123'));

-- creating cart 
-- CREATE TABLE cart(
--     cart_id int PRIMARY KEY  AUTO_INCREMENT NOT NULL,
--     user_id int,
--     FOREIGN KEY (user_id) REFERENCES users(users_id),
--      product_id int,
--     FOREIGN KEY (product_id) REFERENCES product(product_id),
--   	productvariation_id int,
--     FOREIGN KEY (productvariation_id) REFERENCES productvariation(productvariation_id),
--     quantity int
--     );

-- creating address table
CREATE TABLE address(
    address_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id int,
    FOREIGN KEY (user_id) REFERENCES users(users_id),
    address varchar(255),
    email varchar(100),
    phone varchar(100)
    );

-- creating order table
CREATE TABLE orders (
    order_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(users_id),
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES address(address_id),
    purchase_date VARCHAR(100),
    payment_method VARCHAR(100),
    is_accepted ENUM('0', '1') DEFAULT NULL,
    is_paid ENUM('0', '1') DEFAULT '0',
    is_delivered ENUM('0', '1') DEFAULT '0',
    delivery_date VARCHAR(100)
);

ALTER TABLE orders
ADD total varchar(100);

-- ordered product table
CREATE TABLE orderproducts(
    ordersproducts_id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    order_id int,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    product_id int,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    productvariation_id int,
    FOREIGN KEY (productvariation_id) REFERENCES productvariation(productvariation_id)
);
ALTER TABLE `orderproducts` ADD `quantity` INT NOT NULL AFTER `productvariation_id`;