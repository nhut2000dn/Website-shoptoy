<?php

CREATE TABLE `product` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name_pd` varchar(255) NOT NULL,
	`url_name_pd` varchar(255) NOT NULL,
	`image_pd` varchar(1000) NOT NULL,
	`describe_pd` varchar(1000) NOT NULL,
	`material_pd` INT NOT NULL,
	`recommended_age` INT NOT NULL,
	`ideal_for` INT NOT NULL,
	`species_pd` INT NOT NULL,
	`amount_pd` INT NOT NULL,
	`price_pd` FLOAT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `pd_species` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name_species` varchar(300) NOT NULL,
	`url_name_species` varchar(300) NOT NULL,
	`describe_species` varchar(1000) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `account` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`first_name` varchar(300) NOT NULL,
	`last_name` varchar(300) NOT NULL,
	`email` varchar(300) NOT NULL,
	`password` varchar(300) NOT NULL,
	`GT` varchar(10) NOT NULL,
	`date_of_birth` DATE NOT NULL,
	`status` INT NOT NULL,
	`classify` INT NOT NULL,
	`avatar` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `pd_comments` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`id_pd` INT NOT NULL,
	`id_account` INT NOT NULL,
	`comment_content` varchar(500) NOT NULL,
	`date` DATETIME NOT NULL,
	`status` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `order_product` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`id_account` INT NOT NULL,
	`created_date` DATETIME NOT NULL,
	`date_of_delivery` DATE,
	`address` varchar(300) NOT NULL,
	`phone_number` varchar(300) NOT NULL,
	`pay` INT NOT NULL,
	`status` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `order_details` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`id_order` INT NOT NULL,
	`id_product` INT NOT NULL,
	`amount` INT NOT NULL,
	`price_product` FLOAT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `contact` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`email_contact` varchar(255) NOT NULL,
	`content_message` varchar(255) NOT NULL,
	`status` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `pd_recommended_age` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name_r_age` varchar(255) NOT NULL,
	`url_name_r_age` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `pd_ideal_for` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name_ideal_for` varchar(255) NOT NULL,
	`url_name_ideal` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `pd_material` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name_material` varchar(255) NOT NULL,
	`url_name_material` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `product` ADD CONSTRAINT `product_fk0` FOREIGN KEY (`material_pd`) REFERENCES `pd_material`(`id`);

ALTER TABLE `product` ADD CONSTRAINT `product_fk1` FOREIGN KEY (`recommended_age`) REFERENCES `pd_recommended_age`(`id`);

ALTER TABLE `product` ADD CONSTRAINT `product_fk2` FOREIGN KEY (`ideal_for`) REFERENCES `pd_ideal_for`(`id`);

ALTER TABLE `product` ADD CONSTRAINT `product_fk3` FOREIGN KEY (`species_pd`) REFERENCES `pd_species`(`id`);

ALTER TABLE `pd_comments` ADD CONSTRAINT `pd_comments_fk0` FOREIGN KEY (`id_pd`) REFERENCES `product`(`id`);

ALTER TABLE `pd_comments` ADD CONSTRAINT `pd_comments_fk1` FOREIGN KEY (`id_account`) REFERENCES `account`(`id`);

ALTER TABLE `order_product` ADD CONSTRAINT `order_product_fk0` FOREIGN KEY (`id_account`) REFERENCES `account`(`id`);

ALTER TABLE `order_details` ADD CONSTRAINT `order_details_fk0` FOREIGN KEY (`id_order`) REFERENCES `order_product`(`id`);

ALTER TABLE `order_details` ADD CONSTRAINT `order_details_fk1` FOREIGN KEY (`id_product`) REFERENCES `product`(`id`);






INSERT INTO `pd_species`(`id`, `name_species`, `url_name_species`, `describe_species`) VALUES ('1','Vehicles and remote control cars', 'vehicles-and-remote-control-cars',
'Remote control toys have long been popular gifts for tech-savvy kids, and are more engaging than ever since toy makers have started using Android, Windows and iOS devices as a control system');
INSERT INTO `pd_species`(`id`, `name_species`, `url_name_species`, `describe_species`) VALUES ('2','Stuffed Animals & Plush Toys', 'bup-be-and-thu-nhoi-bong','mô hình
phỏng theo hình dáng của con người và thường làm đồ chơi của trẻ em');
INSERT INTO `pd_species`(`id`, `name_species`, `url_name_species`, `describe_species`) VALUES ('3','action figure', 'action-figure','loại máy có
thể thực hiện những công việc một cách tự động bằng sự điều khiển của máy tính hoặc các vi mạch
điện tử được lập trình.');

INSERT INTO `pd_ideal_for`(`id`, `name_ideal_for`, `url_name_ideal`) VALUES ('1','Boys', 'boys');
INSERT INTO `pd_ideal_for`(`id`, `name_ideal_for`, `url_name_ideal`) VALUES ('2','Girls', 'girls');
INSERT INTO `pd_ideal_for`(`id`, `name_ideal_for`, `url_name_ideal`) VALUES ('3','Boys And Girls', 'boys-and-girls');

INSERT INTO `pd_material`(`id`, `name_material`, `url_name_material`) VALUES ('1','plassic', 'plassic');
INSERT INTO `pd_material`(`id`, `name_material`, `url_name_material`) VALUES ('2','wood', 'wood');
INSERT INTO `pd_material`(`id`, `name_material`, `url_name_material`) VALUES ('3','fabric', 'fabric');
INSERT INTO `pd_material`(`id`, `name_material`, `url_name_material`) VALUES ('4','metal', 'metal');

INSERT INTO `pd_recommended_age`(`id`, `name_r_age`, `url_name_r_age`) VALUES ('1','0 to 2 Years', '0-to-2-years');
INSERT INTO `pd_recommended_age`(`id`, `name_r_age`, `url_name_r_age`) VALUES ('2','3 to 4 Years', '3-to-4-years');
INSERT INTO `pd_recommended_age`(`id`, `name_r_age`, `url_name_r_age`) VALUES ('3','4 to 5 Years', '4-to-5-years');
INSERT INTO `pd_recommended_age`(`id`, `name_r_age`, `url_name_r_age`) VALUES ('4','5 to 7 Years', '5-to-7-years');
INSERT INTO `pd_recommended_age`(`id`, `name_r_age`, `url_name_r_age`) VALUES ('5','8 to 11 Years', '8-to-11-years');
INSERT INTO `pd_recommended_age`(`id`, `name_r_age`, `url_name_r_age`) VALUES ('6','12 Years & Up', '12-years-and-up');

INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Nguyễn Hoàng', 'Nhựt', 'nhnhut.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nam', '2000-9-2', '1', '1', '');
INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Hoàng Minh', 'Bình', 'hmbinh.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nam', '2000-8-5', '1', '0', '');
INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Nguyễn Hoàng', 'Hải', 'nhhai.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nam', '2000-4-7', '1', '0', '');
INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Lê Thị Kiều', 'Oanh', 'ltkoanh.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nữ', '2000-1-2', '1', '0', '');
INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Phạm Phú', 'Thịnh', 'ppthinh.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nam', '2000-5-9', '1', '0', '');

INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Nguyễn Yến', 'Nhi', 'nynhi.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nữ', '2000-6-3', '1', '0', '');
INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Nguyễn Thị Trâm', 'Em', 'nttem.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nữ', '2000-7-2', '1', '0', '');
INSERT INTO `account` (`first_name`, `last_name`, `email`, `password`, `GT`, `date_of_birth`, `status`,
`classify`, `avatar`) VALUES ('Trương Quang', 'Nhã', 'tqnha.18it4@sict.udn.vn',
'e10adc3949ba59abbe56e057f20f883e', 'Nam', '2000-8-3', '1', '0', '');



INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Máy bay trực thăng cứu thương ', 'may-bay-truc-thang-cuu-thuong', 'product1.jpg,product1-1.jpg,product1-2.jpg,product1-3.jpg,product1-4.jpg,product1-5.jpg', 'Máy bay
trực thăng cứu thương Alpha đồ chơi – Polesie Toys mang kích thước thu nhỏ của máy bay trực thăng
cứu thương trong thực tế. Sản phẩm sẽ mang lại niềm vui cho các bé, giúp bé tưởng tượng nhập vai
làm chú phi công trực thăng cứu thương', '1', '4', '1', '1', '20', '220.14');
INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Car Model Assembly GE-684', 'car-model-assembly-ge-684', 'product2.jpg,product2-1.jpg,product2-2.jpg,product2-3.jpg,product2-4.jpg,product2-5.jpg,product2-6.jpg,product2-7.jpg', 'Quanzhou
Lucky Star Light Industrial Artcrafts Co., Ltd. Was founded in Oct, 2001. It is headquartered in Quanzhou
city, Fujian province with supporting offices in Chenghai city, Guangdong province and Yiwu city', '1', '4', '1', '1', '20', '280.65');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Xe Đồ Chơi Mô Hình Máy Xúc Cho Bé', 'xe-do-choi-mo-hinh-may-xuc-cho-be', 'product3.jpg,product3-1.jpg,product3-2.jpg,product3-3.jpg,product3-4.jpg,product3-5.jpg,product3-6.jpg,product3-7.jpg,product3-8.jpg', 'Xe Đồ
Chơi Mô Hình Máy Xúc Cho Bé được làm từ các thành phần vật liệu chất lượng tốt có độ bền cao, vật
liệu chống ăn mòn, thân thiện với môi trường, an toàn cho sức khỏe của người dùng.', '1', '4', '1', '1', '20', '295.78') , (NULL, 'Mô Hình Xe Đồ Chơi (5 Xe)', 'mo-hinh-xe-do-choi-5-xe', 'product4.jpg,product4-1.jpg,product4-2.jpg,product4-3.jpg,product4-4.jpg,product4-5.jpg,product4-6.jpg,product4-7.jpg,product4-8.jpg', 'Due to the difference between different
monitors, the picture may not be reflecting the actual the item, please consider this before the
purchase.\r\n Please allow 1-3 cm tolerance due to manual measurement.', '1', '3', '1', '1', '20', '280.46');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Mô Hình Đồ Chơi Xe Ủi', 'mo-hinh-do-choi-xe-ui', 'product5.jpg,product5-1.jpg,product5-2.jpg,product5-3.jpg,product5-4.jpg,product5-5.jpg,product5-6.jpg,product5-7.jpg,product5-8.jpg', 'The colourful box
packaged,it is good ideal as gift for your kid Good quality,environmental material safe and health for
children To attractive children attentin,improve children aknowledge', '4', '4', '1', '1', '20', '275.44'), (NULL, 'Xe
Đồ Chơi Điều Khiển Xiaomi', 'xe-do-choi-dieu-khien-xiaomi', 'product6.jpg,product6-1.jpg,product6-2.jpg,product6-3.jpg,product6-4.jpg,product6-5.jpg,product6-6.jpg,product6-7.jpg,product6-8.jpg,product6-9.jpg', 'xe Đồ Chơi Điều Khiển Xiaomi là món đồ chơi tuyệt vời cho
bé, giúp kíck thích thị giác cũng như tính sáng tạo, tỉ mỉ của bé, giúp bé phát triển trí thông minh ngay cả
khi đang chơi Bé có thể lắp ráp một chiếc xe tải lớn từ những mảnh nhỏ, đi khám phá những điều chưa
biết.', '1', '4', '1', '1', '20', '290.99');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Đồ Chơi Xe Leo Tường', 'do-choi-xe-leo-tuong', 'product7.jpg,product7-1.jpg,product7-2.jpg,product7-3.jpg,product7-4.jpg,product7-5.jpg,product7-6.jpg,product7-7.jpg,product7-8.jpg,product7-9.jpg', 'his super cool RC
climbing car is perfect gift for children over 3 years old. It\'s anti-gravity, infrared remote controlled by
transmitter and can drive almost anywhere, on ground, tilted planum, vertical wall even ceiling. You will
definitely enjoy it with lots of fun.', '1', '4', '1', '1', '20', '310.33'), (NULL, 'Xe Địa Hình RTR RC Off-road', 'xe-dia-hinh-rtr-rc-off-road',
'product8.jpg,product8-1.jpg,product8-2.jpg,product8-3.jpg,product8-4.jpg,product8-5.jpg,product8-6.jpg,product8-7.jpg,product8-8.jpg,product8-9.jpg', 'Hệ thống vô tuyến 2CH 2.4Ghz, chống nhiễu tầm xa, cho khoảng cách điều khiển khoảng
80m Hệ thống truyền động 4WD Hệ thống độc lập bốn bánh. Xe chạy êm ái, giảm xóc hiệu quả. Có
bánh răng kim loại trước và sau.', '1', '5', '1', '1', '20', '290.11');


INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Robot Thông Minh Điều Khiển Bằng Giọng Nói', 'robot-thong-minh-dieu-khien-bang-giong-noi',
'product9.jpg,product9-1.jpg,product9-2.jpg,product9-3.jpg,product9-4.jpg,product9-5.jpg,product9-6.jpg,product9-7.jpg,product9-8.jpg,product9-9.jpg', '827 Intelligent Robot with exquisite craftsmanship, excellent appearance and perfect
qualityhas been empowered with multiple functions, such as Auto display,Program, Recording, English,
Science, Story, Save money, Tongue twister, Colorful light ', '1', '4', '1', '1', '20', '274.22'), (NULL, 'Đồ Chơi
Robot Thông Minh Kaizhi Y6', 'do-choi-robot-thong-minh-kaizhi-y6', 'product10.jpg,product10-1.jpg,product10-2.jpg,product10-3.jpg,product10-4.jpg,product10-5.jpg,product10-6.jpg,product10-7.jpg,product10-8.jpg', 'control, touchable control, sound control. It assists and
accompany kids to explore new things with fun and curiosity. With those amazing functions, 827
Intelligent Robotwill be dramatically welcome among child and provide unprecedented delight for
children. Come ', '1', '3', '3', '1', '20', '290.36');



INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Xe Tăng Mô Hình Điều Khiển Từ Xa Yu Line Yh4101A', 'xe-tang-mo-hinh-dieu-khien-tu-xa-yu-line-yh4101a',
'product11.jpg,product11-1.jpg,product11-2.jpg,product11-3.jpg,product11-4.jpg,product11-5.jpg,product11-6.jpg,product11-7.jpg', 'Xe Tăng Mô Hình Điều Khiển Từ Xa Yu Line Yh4101A thuộc dòng xe điều khiển từ xa

với tỷ lệ 1:20 và tần số kênh 4.0 Được làm từ chất liệu nhựa ABS bảo vệ môi trường, là chất liệu an
toàn, không gây độc hại với môi trường. ', '1', '6', '1', '1', '20', '210.30');
INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'1', '1', 'Đồ Chơi Tốt Chất lượng cao lắm ((:', '0');


INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Nhà búp bê Ngôi nhà thu nhỏ lắp ghép Happiness ', 'nha-bup-be-ngoi-nha-thu-nho-lap-ghep-happiness',
'product30.jpg,product30-1.jpg,product30-2.jpg,product30-3.jpg,product30-4.jpg,product30-5.jpg,product30-6.jpg,product30-7.jpg,product30-8.jpg,product30-9.jpg', 'Đây sẽ là một món quà thật 
dễ thương dành tặng cho người mà bạn yêu quý hoặc chính bạn có thể tự thưởng cho mình những phút giây thư giãn bên bàn làm việc. Chất liệu mô hình hoàn toàn bằng gỗ nhẹ, vải, giấy và 
silicon để các bạn có thể tự tay lắp ghép những mô hình mà mình yêu thích.', '2', '3', '2', '2', '20', '274.22');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Mô hình nhà lắp ghép Tiệm hoa Robotime', 'mo-hinh-nha-lap-ghep-tiem-hoa-robotime',
'product32.jpg,product32-1.jpg,product32-2.jpg,product32-3.jpg,product32-4.jpg,product32-5.jpg,product32-6.jpg,product32-7.jpg,product32-8.jpg,product32-9.jpg', 'Đây sẽ là một món quà thật 
dễ thương dành tặng cho người mà bạn yêu quý hoặc chính bạn có thể tự thưởng cho mình những phút giây thư giãn bên bàn làm việc. Chất liệu mô hình hoàn toàn bằng gỗ nhẹ, vải, giấy và 
silicon để các bạn có thể tự tay lắp ghép những mô hình mà mình yêu thích.', '2', '3', '2', '2', '20', '290.22');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Nhà búp bê lắp ghép Dorami HongDaC009', 'nha-bup-be-lap-ghe-dorami-hongdacc009',
'product27.jpg,product27-1.jpg,product27-2.jpg,product27-3.jpg,product27-4.jpg,product27-5.jpg,product27-6.jpg,product27-7.jpg,product27-8.jpg,product27-9.jpg', 'Nếu bạn đang tìm kiếm một món quà để tặng bạn bè hoặc người thân nhân dịp đặc biêt, đây là một sự lựa chọn tuyệt vời cho bạn
Nhà búp bê lắp ghép DIY  Doll douse được làm bởi chính các bạn theo sách hướng dẫn từng bước -DIY Doll  house là mô hình thu nhỏ của ngôi nhà thực sự, dễ thương và xinh đẹp, theo ty lệ
 1:24', '2', '3', '2', '2', '20', '110.22');
 
INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Nhà búp bê Ngôi nhà thu nhỏ lắp ghép Sweet World', 'nha-bup-be-ngoi-nha-thu-nho-lap-ghep-sweet-world',
'product29.jpg,product29-1.jpg,product29-2.jpg,product29-3.jpg,product29-4.jpg,product29-5.jpg,product29-6.jpg,product29-7.jpg,product29-8.jpg,product29-9.jpg', 'Nếu bạn đang tìm kiếm một món quà để tặng bạn bè hoặc người thân nhân dịp đặc biêt, đây là một sự lựa chọn tuyệt vời cho bạn
Nhà búp bê lắp ghép DIY  Doll douse được làm bởi chính các bạn theo sách hướng dẫn từng bước -DIY Doll  house là mô hình thu nhỏ của ngôi nhà thực sự, dễ thương và xinh đẹp, theo ty lệ
 1:24', '2', '3', '2', '2', '20', '110.22');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Nhà búp bê Ngôi nhà thu nhỏ lắp ghép Kitten Diary', 'nha-bup-be-ngoi-nha-thu-nho-lap-ghep-kitten-diary',
'product29.jpg,product29-1.jpg,product29-2.jpg,product29-3.jpg,product29-4.jpg,product29-5.jpg,product29-6.jpg,product29-7.jpg,product29-8.jpg,product29-9.jpg', 'Chất liệu mô hình hoàn toàn 
bằng gỗ nhẹ, vải, giấy và silicon an toàn với môi trường và con người, vật nuôi để các bạn có thể tự tay lắp ghép những mô hình mà mình yêu thích. Đây sẽ là một món quà thật dễ 
thương dành tặng cho người mà bạn yêu quý hoặc chính bạn có thể tự thưởng cho mình những phút giây thư giãn bên bàn làm việc.', '2', '3', '2', '2', '20', '150.12');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'ebba Lil Benny Phant, Pink Plush', 'ebba-lil-benny-phant,-pink-plush',
'product15.jpg,product15-1.jpg,product15-2.jpg,product15-3.jpg,product15-4.jpg,product15-5.jpg,product15-6.jpg,product15-7.jpg,product15-8.jpg,product15-9.jpg', 'bba Lil Benny Phantom 
characters have wonderful super-soft plush that is perfect for snuggling. L.E. Phants are in a seated position and wear an endearing expression on their face. Each piece is constructed 
using top quality materials for durability and softness.', '3', '1', '2', '2', '20', '172.72');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'GUND Nayla Cockapoo Dog Stuffed Animal Plush, 10.5"', 'gund-nayla-cockapoo-dog-stuffed-animal-plush,-10.5',
'product14.jpg,product14-1.jpg,product14-2.jpg,product14-3.jpg,product14-4.jpg,product14-5.jpg,product14-6.jpg,product14-7.jpg,product14-8.jpg,product14-9.jpg', 'GUND is proud to present 
Nayla — a cute and cuddly Cockapoo that’s sure to become any plush lover’s best friend. Features accurate details that are sure to please fans of poodles and cocker spaniels alike! 
Our Designer Pups line features realistic plush versions of popular hybrid breeds', '3', '1', '2', '2', '20', '165.72');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'GUND Snuffles Teddy Bear Stuffed Animal Plush, White, 10', 'gund-snuffles-teddy-bear-stuffed-animal-plush-white-10',
'product16.jpg,product16-1.jpg,product16-2.jpg,product16-3.jpg,product16-4.jpg,product16-5.jpg,product16-6.jpg,product16-7.jpg,product16-8.jpg,product16-9.jpg', 'GUND is proud to present 
one of our oldest and most beloved teddy bears — Snuffles! The best-selling GUND teddy bear of all-time, Snuffles features a unique crescent design that lets him look into your 
eyes with every hug. First debuting in 1980, generations of Snuffles fans have collected, grown up with, loved, and passed on their beloved bears. This white version makes the perfect 
addition to any Snuffles collection', '3', '1', '2', '2', '20', '155.72');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Melissa & Doug Zephyr Dragon Stuffed Animal', 'melissa-and-doug-zephyz-dragon-stuffed-animal',
'product17.jpg,product17-1.jpg,product17-2.jpg,product17-3.jpg,product17-4.jpg,product17-5.jpg,product17-6.jpg,product17-7.jpg,product17-8.jpg,product17-9.jpg', 'Colorful Zephyr Dragon 
has shiny purple wings that look like they could fly at any moment! A perfect stuffed animal to inspire flights of fantasy, this enchanting toy is sure to be the toast of the kingdom. 
From classic wooden toys to crafts, pretend play, and games, Melissa & Doug products provide a launch pad to ignite imagination and a sense of wonder in all children so they can discover 
themselves, their passions, and their purpose. ', '3', '1', '2', '2', '20', '164.72');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'GUND Pusheen Snackables Donut Plush Stuffed Animal Cat, 9.5"', 'gund-pusheen-snackables-donut-plush-stuffed-animal-cat-9.5',
'product13.jpg,product13-1.jpg,product13-2.jpg,product13-3.jpg,product13-4.jpg,product13-5.jpg,product13-6.jpg,product13-7.jpg,product13-8.jpg,product13-9.jpg', 'PUSHEEN WITH PINK FROSTED 
DONUT SNACKABLE PLUSH: Pusheen loves to snack! This classic upright Pusheen plush toy features the kitty satisfying her sweet tooth with a frosted donut. THE PERFECT GIFT: 
Our plush dolls, teddy bears & stuffed animals make perfect gifts for birthdays, baby showers, baptisms, Easter, Valentine is Day & more! A perfect gift for any Pusheen or 
cat lover!', '3', '2', '2', '2', '20', '155.22');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'WowWee Pinkfong Baby Shark Official Song Puppet with Tempo Control - Baby Shark', 'wowwee-pinkfong-baby-shark-official-song-puppet-with-tempo-control-baby-shark',
'product12.jpg,product12-1.jpg,product12-2.jpg,product12-3.jpg,product12-4.jpg,product12-5.jpg,product12-6.jpg,product12-7.jpg,product12-8.jpg,product12-9.jpg', 'Move the mouth of the puppet to start playing the entire hit baby shark song! (Full-length English version)
Control the Tempo! Move the shark’s mouth faster or slower to change the speed of the song! Soft plush fabric (spot cleaning Only) Batteries included Each character sold separately
Produced by WowWee for pinkfong, official creator of the global hit baby shark!', '3', '2', '2', '2', '20', '146.22');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Đồ Chơi Mô Hình Cá Sấu Châu Mỹ Schleich 14727', 'do-choi-mo-hinh-ca-sau-chau-my-schleich-14727',
'product36.jpg,product36-1.jpg,product36-2.jpg,product36-3.jpg,product36-4.jpg,product36-5.jpg,product36-6.jpg,product36-7.jpg,product36-8.jpg,product36-9.jpg', 'Đồ Chơi Mô Hình Cá Sấu 
Châu Mỹ Schleich 14727 được làm từ nhựa cao cấp tuân thủ các quy định châu Âu (EN71) và đạt tiêu chuẩn quốc tế IS0 8124 nên hoàn toàn không chứa các chất độc hại gây hại cho trẻ. Sản phẩm có thiết kế an toàn, bề mặt nhẵn không góc cạnh và không làm trầy xước da bé khi cầm, nắm.', 
'1', '3', '1', '3', '20', '148.22');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Đồ Chơi Mô Hình Hot Toys Cosb(S) - War Machine Mark III - 252', 'do-choi-mo-hinh-hot-toys-cosb(s)-war-machine-mark-iii-252',
'product44.jpg,product44-1.jpg,product44-2.jpg,product44-3.jpg,product44-4.jpg,product44-5.jpg,product44-6.jpg,product44-7.jpg,product44-8.jpg,product44-9.jpg', 'Đồ Chơi Mô Hình Hot Toys Cosb(S) - War Machine Mark III - 252 là đồ chơi mô phỏng dáng vẻ nhân vật War Machine Mark III là một siêu anh hùng xuất hiện trong truyện tranh được xuất bản bởi Marvel Comics. Sản phẩm có kích thước nhỏ gọn, tiện lợi để mang theo đồ chơi bên mình trong những chuyến đi xa.', 
'1', '3', '1', '3', '20', '111.22');

INSERT INTO `product` (`id`, `name_pd`, `url_name_pd`, `image_pd`, `describe_pd`, `material_pd`, `recommended_age`, `ideal_for`, `species_pd`, `amount_pd`, `price_pd`) VALUES (NULL, 'Đồ Chơi Mô Hình Funko Pop Star Wars Rogue One - C2-B5 - 10464', 'do-choi-mo-hinh-funko-pop-star-wars-rogue-one-c2-b5-10464',
'product45.jpg,product45-1.jpg,product45-2.jpg,product45-3.jpg,product45-4.jpg,product45-5.jpg,product45-6.jpg,product45-7.jpg,product45-8.jpg,product45-9.jpg', 'Đồ Chơi Mô Hình Funko Pop Star Wars Rogue One - C2-B5 - 10464 là đồ chơi mô phỏng dáng vẻ nhân vật C2-B5 một người máy vói hình dáng là mắt. Sản phẩm có kích thước nhỏ gọn, tiện lợi để mang theo đồ chơi bên mình trong những chuyến đi xa. Có rất nhiều mẫu nhân vật, từ nhân vật Disney cho đến những movie hay game hot nhất hiện nay.', 
'1', '3', '3', '3', '20', '250.22');


INSERT INTO `order_product` (`id`, `id_account`, `created_date`, `date_of_delivery`, `address`,
`phone_number`, `pay`) VALUES (NULL, '1', '2019-07-11 00:00:00', NULL, '1 / Đ. NGÔ QUYỀN / Q.SƠN
TRÀ / TP.ĐÀ NẴNG', '01284645528', '0');
INSERT INTO `order_details` (`id`, `id_order`, `id_product`, `amount`) VALUES (NULL, '1', '1', '1');
INSERT INTO `order_product` (`id`, `id_account`, `created_date`, `date_of_delivery`, `address`,
`phone_number`, `pay`) VALUES (NULL, '2', '2019-07-12 00:00:00', NULL, 'Số 35 / Q.Thanh Đào Soài',
'012465484', '0');
INSERT INTO `order_details` (`id`, `id_order`, `id_product`, `amount`) VALUES (NULL, '2', '6', '2');

INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'1', '2', 'Đồ dùng đẹp, in rõ nét, ép cẩn thận, cắt góc nhọn an toàn cho trẻ. Mình mua dạy Tiếng Anh cho
trẻ Mầm Non rất thích. Ủng hộ shop lâu dài. Mong shop có thêm nhiều sp cho giảng dạy Tiếng Anh cho
trẻ', '0');
INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'2', '3', 'Dòng sản phẩm đồ chơi thông minh này bản thân m thấy đang rất được quan tâm. Mình cũng
muốn tìm cho con mình những sản phẩm phù hợp cho độ tuổi. Cảm ơn nhân viên shop đã tư vấn rất
nhiệt tình để mình mua những sản phẩm ưng ý nhất', '0');
INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'3', '4', 'Chủ shop có tâm nhiệt tình và yêu trẻ ♥', '0');
INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'4', '5', 'Ba mẹ có thể cho bé tham khảo clip lắp ghép robot Victorion tại đây ạ, các chi tiết cực dễ tháo lắp
và số lượng tại shop không còn nhiều ạ', '0');
INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'5', '2', 'Set 12 bé Pony size 7 cm clear stock giá chỉ 155k freeship . Đảm bảo các bé gái sẽ thích mê đấy.
', '0');
INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'6', '1', 'Bao gồm 12 nàng Pony xinh đẹp, nhỏ nhắn xinh xắn với các kiểu tạo dáng khác nhau, màu sắc
sinh động sẽ là món quà tuyệt vời cho tất cả các con!', '0');
INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `status`) VALUES (NULL,
'7', '4', 'Nhiều ba mẹ inbox hỏi shop kích thước thật của bạn robot tổng, rồi liệu bé có chơi đc không ',
'0');


?>