<?php

$_MYSQL = mysqli_connect('localhost', 'root', 'root', '');

$query = "CREATE DATABASE IF NOT EXISTS minishop";
mysqli_query($_MYSQL, $query);

mysqli_close($_MYSQL);

include "config/database.php" ;

$query = "DROP TABLE IF EXISTS *";
mysqli_query($_MYSQL, $query);

$query = "CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `total` int(11) NOT NULL,
  `creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

mysqli_query($_MYSQL, $query);

$query = "INSERT INTO `carts` (`id`, `user_id`, `content`, `total`, `creation`) VALUES
(2, 1, 'a:4:{i:1;s:1:\"2\";i:2;s:1:\"0\";i:3;s:1:\"8\";i:5;s:1:\"0\";}', 1210, '2017-01-15 17:04:05'),
(6, 1, 'a:1:{i:1;i:10;}', 50, '2017-01-15 19:15:10'),
(7, 3, 'a:2:{i:1;i:0;i:2;s:1:\"1\";}', 2500, '2017-01-15 19:15:13');";

mysqli_query($_MYSQL, $query);

$query = "CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

mysqli_query($_MYSQL, $query);

$query = "INSERT INTO `categories` (`id`, `name`, `parent`) VALUES
(1, 'Slaves', NULL),
(2, 'Accessories', NULL),
(4, 'Asian', 1),
(5, 'African', 1),
(6, 'North American', 1),
(7, 'Latino American', 1),
(8, 'European', 1),
(9, 'Other continents', 1),
(10, 'Chinese', 4),
(11, 'Congolese', 5),
(12, 'Male', 1),
(13, 'Female', 1),
(14, 'Adult', 1),
(15, 'Child', 1),
(16, 'Artisans', 1),
(17, 'Intellectuals', 1),
(18, 'Gatherers', 1),
(19, 'Other functions', 1),
(20, 'Punishment tools', 2),
(21, 'Shackles', 2),
(22, 'Indian', 4),
(23, 'Packs', NULL),
(24, 'Japanese', 4);";

mysqli_query($_MYSQL, $query);

$query = "CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `categories` text,
  `price` int(11) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

mysqli_query($_MYSQL, $query);

$query = "INSERT INTO `items` (`id`, `name`, `categories`, `price`, `picture`, `description`) VALUES
(1, 'Young chinese boy', '1,4,10,15,16', 5, 'http://1.bp.blogspot.com/-7ntJ1i86ElY/Tj1b-9nmD5I/AAAAAAAABhw/SJQy_SIdNJg/s1600/hoch_trip-to-china036.jpg', 'A young chinese boy, perfect to play and distract your children. Also, he has great crafting skills, as he can repair your electronic devices in no time !'),
(2, 'Geisha m.1992', '1,4,13,14,16,17,19,24', 2500, 'http://weknowyourdreams.com/images/geisha/geisha-02.jpg', 'A young Geidha born in 1992. She knows everything she should : how to make tea, music, dance, poesy, and sex.'),
(3, 'Iron chains', '2,21', 150, 'https://a.1stdibscdn.com/archivesE/1stdibs/041112/dogfork/8/DSC_5738.jpg', 'Perfect to restrain your slaves. Lock not included.'),
(4, 'Barbwire whip', '2,20', 200, 'http://i.ebayimg.com/00/s/MTI3M1gxNjAw/$(KGrHqJHJCQE9qvQ6vpoBPjkstsSjw~~60_35.JPG', 'When your slave has done something wrong, use this to punish it.'),
(5, 'Old samurai', '1,4,12,14,19,24', 4500, 'http://2.bp.blogspot.com/-4AathzfEfp4/TnxBB8rgzLI/AAAAAAAAAts/PC8jR0vLM9s/s1600/2348597171_2a4deca69d.jpg', 'This samurai knows what to do to protect you, and your children. Comes with his own equipment.'),
(6, 'Coton gatherers - mom and child', '1,5,11,13,14,15,18,23', 150, 'https://africafashionguide.files.wordpress.com/2011/12/1401as10.jpeg', 'Those two slaves are linked by a solid bound. If you take care of the child, she might just become a new slave for you.'),
(7, 'Great black man', '1,5,11,12,14,19', 100, 'http://www.coupecheveuxhomme.com/wp-content/uploads/2014/10/homme-noir-mannequin.jpg', 'This man has multiple functions : moving furnitures, great sex, and you can send him to win the Olympic Games for you !'),
(8, 'IMPOSSIBLE mk.II', '1,4,10,12,14,16,17,18,19', 20, 'https://popdustroar-img.rbl.ms/simage/https%3A%2F%2Fassets.rbl.ms%2F6651661%2F980x.jpg/2000,2000/4Lvr4CcOPhAWNMYS/img.jpg', 'He can do anything that is impossible ! (And he only eats rice, which is nice)'),
(9, 'Indian chief', '1,6,12,14,17,19', 4000, 'https://s-media-cache-ak0.pinimg.com/originals/2e/6e/6d/2e6e6d5a7844c9e8c9e4d5a84a55de5c.jpg', 'This one knows how to manage a team...'),
(10, 'Kitty american whore', '1,6,13,14,19', 600, 'http://www.dhresource.com/avim_1109237025_00.jpg', 'This girl will do exactly what she is told, just as your favourite kitten.'),
(11, 'Taco-maker', '1,7,12,14,16', 10, 'http://www.riviera-maya-holidays.com/images/mexican-culture.jpg', 'He will make you good tacos. And Ladies, he sure knows how to eat your !'),
(12, 'Flanders\' Coffee-maker', '1,7,12,14,16', 400, 'http://i.skyrock.net/2871/73562871/pics/2897929341_small_1.jpg', 'This ones sure knows how to make coffee !'),
(13, 'Sharpshooter', '1,8,12,14', 125, 'http://img.over-blog-kiwi.com/0/40/38/63/20150316/ob_dc1819_fb-img-1426544252165.jpg', 'This portugese sharpshooter wil shoot down your walls in no time!'),
(14, 'Young Shooter', '1,8,12,15,19', 150, 'http://www.ww2incolor.com/d/225612-4/Bild+183-J28836A%23', 'This young boy will work well with any of your ovens.'),
(15, 'Kangaroo', '1,9,13,14,19', 50, 'http://2.bp.blogspot.com/-UfS9SA3CZy0/T0PbwYpfhNI/AAAAAAAAGj0/e0Y7ax9b5E8/s1600/Nice-Animal-Grey-Kangaroo-Sitting-Picture.jpg', 'This slave will carry your kids anywhere !'),
(16, 'Inuit fisher', '1,9,13,14,16,18', 60, 'http://4.bp.blogspot.com/-bSXIT9evWlk/UMoEl5-VEPI/AAAAAAAAWmM/Hd5WK0nvu4I/s1600/Edward+S.+Curtis+-+Inuit+Woman.JPG', 'She sure knows how to get some fish, and she also cooks dinner.'),
(18, 'Not yet married', '1,4,13,14,22', 600, 'http://ideas.bestwedding-dresses.com/wp-content/uploads/2012/10/Indian-wedding-dresses-ideas.bestwedding.dresses-3.jpg', 'Become the new husband of this gorgeous indan woman ! Special offer : this woman\'s family will receive half of the price for it !'),
(19, 'Indian doctor', '1,4,12,14,16,19,22', 500, 'http://media2.intoday.in/indiatoday/images/stories/witch-story_647_072715051833.jpg', 'This doctor will cure any illness you may encounter. Additional price may be necessary, like blood of souls.'),
(20, 'Leather whip', '2,20', 100, 'http://www.westernwhips.com/images/whips/98.jpg', 'This leather is perfect for light, swift punishments.'),
(21, 'Iron restraints', '1,21', 120, 'http://www.danielgreenphotography.com/ebay/shackles/asirik.jpg', 'Those restrains can\'t be taken off without the key. Perfect for keeping your slave in the position you want.'),
(22, 'Lock and Key', '2,23', 25, 'http://2.bp.blogspot.com/_cmibqHEYw_g/S7aQtypKuhI/AAAAAAAAB_Y/-s4yAcGknCk/s1600/silver+lock+2.jpg', 'This pack contains a lock and its key. ');";

mysqli_query($_MYSQL, $query);

$query = "CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `cart` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

mysqli_query($_MYSQL, $query);

$query = "INSERT INTO `users` (`id`, `username`, `mdp`, `cart`) VALUES
(1, 'admin', '754429c9e04b48f0c429fb8615d841e6d056b5c20ef01e449e3b14288dfb6bd2', 'b:0;'),
(3, 'patate', 'a68b95a60a0ba0f4f559b39c2de4770ef5d9ac992f277804ad45f80b04b4212b', 'b:0;');";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;";

mysqli_query($_MYSQL, $query);

$query = "ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;";

mysqli_query($_MYSQL, $query);


echo "<a href='index.php'>Done ! You can now explore the site !</a>";