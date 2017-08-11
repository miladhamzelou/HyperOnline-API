insert into ho_authors(unique_id, name, phone, mobile, email, state, city, address, mCode, create_date, created_at) values ('a1', 'امیر حاجی بابایی', '08138263324', '09188167800', 'amir@gmail.com', 'همدان', 'همدان', 'خیابان مهدیه', '3860467174', '2017-08-07 03:30:00', '2017-08-07 03:30:00');

insert into ho_sellers(unique_id, author_id, name, address, open_hour, close_hour, type, confirmed, phone, state, city, create_date, created_at) values ('s1', 'a1', 'هایپرآنلاین', 'خیابان مهدیه', '9', '22', '0', '1', '08138263324', 'همدان', 'همدان', '2017-08-07 03:30:00', '2017-08-07 03:30:00');

insert into ho_category1s(unique_id, name, create_date, created_at) values('c1', 'لبنیات', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_category1s(unique_id, name, create_date, created_at) values('c2', 'بهداشتی', '2017-08-07 03:30:00', '2017-08-07 03:30:00');

insert into ho_category2s(unique_id, parent_id, name, create_date, created_at) values('c3', 'c1', 'شیر', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_category2s(unique_id, parent_id, name, create_date, created_at) values('c4', 'c1', 'ماست', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_category2s(unique_id, parent_id, name, create_date, created_at) values('c5', 'c2', 'دستمال کاغذی', '2017-08-07 03:30:00', '2017-08-07 03:30:00');

insert into ho_category3s(unique_id, parent_id, name, create_date, created_at) values('c6', 'c3', 'شیر کم چرب', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_category3s(unique_id, parent_id, name, create_date, created_at) values('c7', 'c3', 'شیر پر چرب', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_category3s(unique_id, parent_id, name, create_date, created_at) values('c8', 'c4', 'ماست کم چرب', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_category3s(unique_id, parent_id, name, create_date, created_at) values('c9', 'c5', 'دستمال رول', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_category3s(unique_id, parent_id, name, create_date, created_at) values('c10', 'c5', 'دستمال جعبه ای', '2017-08-07 03:30:00', '2017-08-07 03:30:00');

insert into ho_users(unique_id, name, phone, address, encrypted_password, salt, state, city, create_date, created_at) values('u1', 'امیر حاجی بابایی', '09188167800', 'خیابان مهدی', 'DbKg4dzhlIIwjprSFqByheMMs681ODFjM2E3ZmI5', '581c3a7fb9', 'همدان', 'همدان', '2017-08-07 03:30:00', '2017-08-07 03:30:00');

insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p1', 's1', 'c6', 'شیر کم چرب میهن', '1', '1', '3200', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p2', 's1', 'c6', 'شیر کم چرب کاله', '1', '1','3500', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p3', 's1', 'c7', 'شیر پر چرب کاله', '1', '1','4500', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p4', 's1', 'c7', 'شیر پرچرب میهن', '1', '1','4000', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p5', 's1', 'c8', 'ماست کم چرب کاله کوچک', '1', '1','2500', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p6', 's1', 'c8', 'ماست کم چرب کاله بزرگ', '1', '1','3150', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p7', 's1', 'c9', 'دستمال کاغذی مینا - 4 عددی', '1', '1','8200', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p8', 's1', 'c9', 'دستمال کاغذی مینا - 6 عددی', '1', '1','10000', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p9', 's1', 'c9', 'دستمال کاغذی پاپیا - 6 عددی', '1', '1','8500', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p10', 's1', 'c10', 'دستمال کاغذی سافتلن - 300 برگ', '1', '1','3600', '2017-08-07 03:30:00', '2017-08-07 03:30:00');
insert into ho_products(unique_id, seller_id, category_id, name, count, confirmed, price, create_date, created_at) values('p11', 's1', 'c10', 'دستمال کاغذی سافتلن - 150 برگ', '1', '1','1700', '2017-08-07 03:30:00', '2017-08-07 03:30:00');