# shortenlink

Web App for making shorten Link

# SQL code

```
=
CREATE DATABASE IF NOT EXISTS `db_shorten_link`
USE `db_shorten_link`;


CREATE TABLE IF NOT EXISTS `link_list` (
  `p_link` varchar(255) NOT NULL,
  `r_link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`p_link`)
);

```
