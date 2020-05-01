CREATE TABLE purchase_history (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id INT,
    total_price INT,
    puechase_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE purchase_detail (
    purchase_detail_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    id INT,
    item_id INT,
    price INT,
    purchase_number INT
);