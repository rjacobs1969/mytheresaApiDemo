USE `catalog`;

INSERT INTO `catalog`.`products`
    (
        `sku`,
        `name`,
        `category`,
        `price`
    )
    VALUES
    (
        '000001',
        'BV Lean leather ankle boots',
        'boots',
        89000
    ),(
        "000002",
        "BV Lean leather ankle boots",
        "boots",
        99000
    ),(
        "000003",
        "Ashlington leather ankle boots",
        "boots",
        71000
    ),(
        "000004",
        "Naima embellished suede sandals",
        "sandals",
        79500
    ),(
        "000005",
        "Nathane leather sneakers",
        "sneakers",
        59000
    );

    INSERT INTO `catalog`.`discounts`
    (
        `sku`,
        `category`,
        `discount_percent`
    )
    VALUES
    (
        "",
        "boots",
        30
    ),(
        "000003",
        "",
        15
    );