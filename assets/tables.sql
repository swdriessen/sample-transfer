-- creates tables, not the database itself
DROP TABLE `uploads`;
DROP TABLE `users`;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `local_filename` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `description` text NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expiration_date` datetime NOT NULL,
  `downloads` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `identifier` int(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `displayname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(535) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



-- test data for localhost demo user
-- todo: move into seperate file

INSERT INTO `users` (`id`, `identifier`, `username`, `displayname`, `email`, `avatar`, `profile`, `active`) 
VALUES (6, 1234567, 'demouser', 'Demo User', 'demo@server.example', 'https://help.github.com/assets/images/help/profile/identicon.png', 'https://github.com/home', 1);

INSERT INTO `uploads` (`id`, `user_id`, `original_filename`, `local_filename`, `filesize`, `description`, `upload_date`, `expiration_date`, `downloads`) VALUES
(15, 6, 'file1.zip', '5b9a98f8c6e28', 1234567, 'description of file 1', '2018-09-13 19:06:00', '2018-09-10 19:06:00', 0),
(16, 6, 'file2.zip', '5b9bfec95f167', 1234567, 'description of file 2', '2018-09-14 20:32:41', '2018-09-10 20:32:41', 42);