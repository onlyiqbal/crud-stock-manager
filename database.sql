use db_stock;

use db_stock_test;

create table users(
id varchar(255) primary key,
username varchar(255) not null,
password varchar(255) not null,
email varchar(255) not null
);

create table sessions(
id varchar(255) primary key,
user_id varchar(255) not null,
constraint fk_sessios_user
foreign key (user_id) references users (id)
);

create table products(
id int primary key auto_increment,
name varchar(255) not null,
quantity int not null,
price decimal not null,
update_at timestamp
);

desc products;

drop table products;

select * from users;

select * from sessions;

select * from products;