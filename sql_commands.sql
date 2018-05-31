USE robindb;

CREATE TABLE Customers (
IDnum int primary key,
firstName varchar (15),
lastName varchar(30),
email varchar(50),
passwd varchar(20)
);

CREATE TABLE Products (
ProdId int primary key,
name varchar (20),
description varchar (350),
price decimal(10,2),
image varchar(15)
);

/*Create Admin*/
insert into Customers
values(0, 'Admin', 'Admin', 'admin@jukebox.com', 'beyonce1232');

insert into Products
values(0, 'Year of the Gentlem', 'Year of The Gentleman. Ne-yos third studio album. Released in 2008', 6.95, 'images/YOTG.jpg');

insert into Products
values(1, 'BDay', 'BDay. Beyonces second studio album. Released in 2006', 5.75, 'images/bday.jpg');

insert into Products
values(2, 'In a Perfect World', 'In a Perfect World. Keri Hilsons Debut album. Released in 2009', 2.75, 'images/h.jpg');

insert into Products
values(3, 'My Beautiful Dark Tw', 'My Beautiful Dark Twisted Fantasy. Kanye Wests fifth studio album. Released in 2010', 4.99, 'images/k1.jpg');
