CREATE DATABASE pro_tracker;

CREATE TABLE users (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
address VARCHAR(30) NOT NULL,
tel_no VARCHAR(10) NOT NULL,
nic VARCHAR(10) NOT NULL,
email VARCHAR(50) NOT NULL,
password VARCHAR(32) NOT NULL,
user_type VARCHAR(16) NOT NULL, /*administrator, customer, supervisor,superuser, employer */
user_img VARCHAR(50),
user_registered DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customer (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
address VARCHAR(30) NOT NULL,
tel_no VARCHAR(10) NOT NULL,
nic VARCHAR(10) NOT NULL,
occupation VARCHAR(15) NOT NULL,
email VARCHAR(50) NOT NULL,
password VARCHAR(32) NOT NULL,
user_type VARCHAR(16) NOT NULL, /* administrator, customer, superuser, employer */
user_img VARCHAR(50),
user_registered DATETIME DEFAULT CURRENT_TIMESTAMP
);

/* email: admin@bfc.com, password: 123 */
INSERT INTO users(first_name, last_name, address, tel_no, nic, email, password, user_type, user_img)
VALUES ('admin','admin','1874/B Sri pura','0778956123','789456123v','admin@bfc.com','202cb962ac59075b964b07152d234b70','administrator','');

INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('kamal','sanath','1874/B Sri pura','0778956123','789456123v','service','cus458@bfc.com','202cb962ac59075b964b07152d234b70','customer','');
INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('ruwan','kumara','1874/B Sri pura','0778956123','789456123v','service','cus789@bfc.com','202cb962ac59075b964b07152d234b70','customer','');
INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('nimal','kura','1874/B Sri pura','0778956123','789456123v','service','cus78@bfc.com','202cb962ac59075b964b07152d234b70','customer','');
INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('john','jack','1874/B Sri pura','0778956123','789456123v','service','cus12@bfc.com','202cb962ac59075b964b07152d234b70','customer','');
INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('jack','malee','1874/B Sri pura','0778956123','789456123v','service','cus978@bfc.com','202cb962ac59075b964b07152d234b70','customer','');
INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('nimash','isuru','1874/B Sri pura','0778956123','789456123v','service','cus36@bfc.com','202cb962ac59075b964b07152d234b70','customer','');
INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('shan','kumara','1874/B Sri pura','0778956123','789456123v','service','cus36@bfc.com','202cb962ac59075b964b07152d234b70','customer','');
INSERT INTO customer(first_name, last_name, address, tel_no, nic, occupation, email, password,user_type, user_img) VALUES ('mery','mery','1874/B Sri pura','0778956123','789456123v','service','cus@bfc.com','202cb962ac59075b964b07152d234b70','customer','');

CREATE TABLE project (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
pro_owner_id INT UNSIGNED NOT NULL,
pro_name VARCHAR(30) NOT NULL,
address VARCHAR(30) NOT NULL,
geo_locate VARCHAR(30) NOT NULL,
approx_budget DECIMAL (11,2) NOT NULL,
start_date DATE NOT NULL,
end_date DATE NOT NULL,
plan_doc VARCHAR(100) NOT NULL,
boq_doc VARCHAR(100) NOT NULL,
in_paid_state BOOLEAN NOT NULL,
full_paid_state BOOLEAN NOT NULL,
status VARCHAR (15), /* in progress, not start, finished */
release_user VARCHAR(30) NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (pro_owner_id) REFERENCES customer(id)
);

CREATE TABLE uom (
uom_code VARCHAR(6) NOT NULL PRIMARY KEY,
uom_desc VARCHAR(50),
allow_decimal BOOLEAN NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE product (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
product_name VARCHAR(30) NOT NULL,
product_desc VARCHAR(50) NOT NULL,
uom_code VARCHAR(6) NOT NULL,
unit_cost DECIMAL(11,2) NOT NULL,
product_type VARCHAR(10) NOT NULL,
release_user VARCHAR(30) NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (uom_code) REFERENCES uom(uom_code)
);

CREATE TABLE stages(
stage_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
pro_id INT UNSIGNED NOT NULL,
stage_name VARCHAR(30) NOT NULL,
stage_desc VARCHAR(30) NOT NULL,
approx_budget DECIMAL(11,2) NOT NULL,
outstanding DECIMAL(11,2) NOT NULL,
stages_status VARCHAR (15), /* in progress, not start, finished */
release_user VARCHAR(30) NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (pro_id) REFERENCES project(id)
);

CREATE TABLE stages_item(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
stage_id INT UNSIGNED NOT NULL,
item_id INT UNSIGNED NOT NULL,
item_cost DECIMAL(11,2) NOT NULL,
qty DECIMAL(11,2) NOT NULL,
available_qty DECIMAL(11,2) NOT NULL DEFAULT 0,
total_amount DECIMAL(11,2) NOT NULL,
release_user VARCHAR(30) NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (stage_id) REFERENCES stages(stage_id),
FOREIGN KEY (item_id) REFERENCES product(id)
);

CREATE TABLE payment(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
customer_id INT UNSIGNED NOT NULL ,
project_id INT UNSIGNED NOT NULL ,
amount DECIMAL (11,2) NOT NULL ,
release_user VARCHAR(30) NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (customer_id) REFERENCES customer(id),
FOREIGN KEY (project_id) REFERENCES project(id)
);

CREATE TABLE project_remark (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
pro_id INT UNSIGNED NOT NULL,
remark VARCHAR (255) NOT NULL ,
customer_visible BOOLEAN NOT NULL,
release_user VARCHAR(30) NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (pro_id) REFERENCES project(id)
);

CREATE TABLE stages_img (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
stages_id INT UNSIGNED NOT NULL,
img VARCHAR (50) NOT NULL,
release_user VARCHAR(30) NOT NULL,
release_date DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (stages_id) REFERENCES stages(stage_id)
);



SELECT project.pro_name,project.,stages.stage_id,stages.stage_name,project.in_paid_state FROM project JOIN stages ON project.id = stages.pro_id
WHERE project.id = '1';