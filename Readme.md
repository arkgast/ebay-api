# Ebay Api

Simple app that use ebay api to search a product by its item number


## Sql script

    create database ebay_search default character set utf8 default collate utf8_general_ci;

    create table search_log (
		    id int primary key auto_increment,
		    title varchar(120) not null,
		    seller varchar(30) not null,
	      price decimal(3,2) not null,
	      images text not null,
	      item_id bigint not null
    );
