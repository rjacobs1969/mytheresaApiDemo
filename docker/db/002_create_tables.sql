
USE `catalog`;

CREATE TABLE products
(
    `sku`              CHAR(6)      NOT NULL,
    `name`             VARCHAR(255) NOT NULL,
    `category`         VARCHAR(64)  NOT NULL,
    `price`            INT          NOT NULL,
    PRIMARY KEY (sku),
    INDEX         by_category_price (category ASC, price ASC),
    INDEX         by_price (price ASC)
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;



