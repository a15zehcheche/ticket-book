
CREATE DATABASE IF NOT EXISTS bar;

USE bar;

-- DELETING
DROP TABLE IF EXISTS PRODUCTO;
DROP TABLE IF EXISTS PRODUCTO_TIPOS;
DROP TABLE IF EXISTS ESPACIO;
DROP TABLE IF EXISTS TIKET_ITEM;
DROP TABLE IF EXISTS TIKET;



-- CREATING TABLES

CREATE TABLE PRODUCTO_TIPOS(
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL UNIQUE,
  detall VARCHAR(255) DEFAULT '',
  active BOOLEAN DEFAULT 1,
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME DEFAULT NOW()
);

CREATE TABLE PRODUCTO (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL UNIQUE,
  detall VARCHAR(255) DEFAULT '',
  price DECIMAL(3,2),
  photo_path VARCHAR(255) DEFAULT '',
  active BOOLEAN DEFAULT 1,
  id_tipos INTEGER , -- FK
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME DEFAULT NOW()
);

CREATE TABLE ESPACIO (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL,
  active BOOLEAN DEFAULT 1,
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME DEFAULT NOW()
);

CREATE TABLE TIKET (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_ESPACIO INTEGER NOT NULL,
  name_ESPACIO VARCHAR(30), 
  name VARCHAR(30) NOT NULL,
  active BOOLEAN DEFAULT 1,
  price_to_pay DECIMAL(3,2),
  pay_at DATETIME,
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME DEFAULT NOW()
);

CREATE TABLE TIKET_ITEM (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL,
  id_tiket INTEGER NOT NULL, -- FK
  id_producto INTEGER NOT NULL, 
  price_producto DECIMAL(5,2),
  quantity INTEGER(2) DEFAULT 1,
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME DEFAULT NOW()
);


-- FK --

ALTER TABLE TIKET_ITEM ADD FOREIGN KEY (id_tiket) REFERENCES TIKET(id) ON DELETE CASCADE;
ALTER TABLE PRODUCTO ADD FOREIGN KEY (id_tipos) REFERENCES PRODUCTO_TIPOS(id) ON DELETE SET NULL;


ALTER USER 'root'@'localhost' IDENTIFIED BY 'P@ssword';
GRANT ALL PRIVILEGES ON * . * TO 'root'@'localhost';



INSERT INTO `ESPACIO` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES (NULL, 'Terrassa', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `ESPACIO` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES (NULL, 'Sala1', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `ESPACIO` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES (NULL, 'Sala2', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


INSERT INTO `PRODUCTO_TIPOS` (`id`, `name`, `detall`, `active`, `created_at`, `updated_at`) VALUES (NULL, 'Plato Cominado', '', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `PRODUCTO_TIPOS` (`id`, `name`, `detall`, `active`, `created_at`, `updated_at`) VALUES (NULL, 'Bocadillo', '', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `PRODUCTO_TIPOS` (`id`, `name`, `detall`, `active`, `created_at`, `updated_at`) VALUES (NULL, 'Tapas', '', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `PRODUCTO_TIPOS` (`id`, `name`, `detall`, `active`, `created_at`, `updated_at`) VALUES (NULL, 'Resfresco', '', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO `PRODUCTO` (`id`, `name`, `detall`, `price`, `photo_path`, `active`, `id_tipos`, `created_at`, `updated_at`) VALUES (NULL, 'CocaCola', '','1.70', '', '1', '4', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `PRODUCTO` (`id`, `name`, `detall`, `price`, `photo_path`, `active`, `id_tipos`, `created_at`, `updated_at`) VALUES (NULL, 'Becon con Keso', '', '4.00','', '1', '2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `PRODUCTO` (`id`, `name`, `detall`, `price`, `photo_path`, `active`, `id_tipos`, `created_at`, `updated_at`) VALUES (NULL, 'Bravas', '','3.50', '', '1', '3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO `TIKET` (`id`, `id_ESPACIO`, `name_ESPACIO`, `name`, `active`, `price_to_pay`, `pay_at`, `created_at`, `updated_at`) VALUES (NULL, '1', 'Trrassa', 'T1', '1', NULL, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO `TIKET_ITEM` (`id`, `name`, `id_tiket`, `id_producto`, `price_producto`, `quantity`, `created_at`, `updated_at`) VALUES (NULL, 'CocaCola', '1', '1', '1.70', '2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `TIKET_ITEM` (`id`, `name`, `id_tiket`, `id_producto`, `price_producto`, `quantity`, `created_at`, `updated_at`) VALUES (NULL, 'Bravas', '1', '2', '3.50', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
-- store DATA --

-- INSERT INTO store (name, created_at) VALUES ('Carnisseria', NOW());
-- INSERT INTO store (name, created_at) VALUES ('Peixateria', NOW());
-- INSERT INTO store (name, created_at) VALUES ('Sushi', NOW());
-- INSERT INTO store (name, created_at) VALUES ('Xarcuteria', NOW());
-- INSERT INTO store (name, created_at) VALUES ('Forn de pa', NOW());

-- queue DATA --

-- INSERT INTO queue (id_store, queue_type, priority) VALUES (1, 'VIP', 0);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (1, 'BUCKET_QUEUE', 1);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (1, 'NORMAL', 2);

-- INSERT INTO queue (id_store, queue_type, priority) VALUES (2, 'VIP', 0);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (2, 'bucket_queue', 1);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (2, 'NORMAL', 2);

-- INSERT INTO queue (id_store, queue_type, priority) VALUES (3, 'VIP', 0);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (3, 'bucket_queue', 1);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (3, 'NORMAL', 2);

-- INSERT INTO queue (id_store, queue_type, priority) VALUES (4, 'VIP', 0);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (4, 'bucket_queue', 1);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (4, 'NORMAL', 2);

-- INSERT INTO queue (id_store, queue_type, priority) VALUES (5, 'VIP', 0);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (5, 'bucket_queue', 1);
-- INSERT INTO queue (id_store, queue_type, priority) VALUES (5, 'NORMAL', 2);

-- turnS DATA --

-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (1, NULL, 0, 3, NOW(), 'WAITING');
-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (2, NULL, 0, 3, NOW(), 'WAITING');
-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (3, NULL, 0, 3, NOW(), 'WAITING');
-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (4, NULL, 0, 3, NOW(), 'WAITING');

-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (1, NULL, 0, 2, NOW(), 'WAITING');
-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (2, NULL, 0, 2, NOW(), 'WAITING');

-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (1, NULL, 0, 1, NOW(), 'WAITING');
-- INSERT INTO turn (NUMBER, id_bucket, id_USER, id_queue, DATE_turn, STATE) VALUES (2, NULL, 0, 1, NOW(), 'WAITING');

-- till DATA --

-- INSERT INTO till (id_store, name, active) VALUES (3, 'till1', FALSE);
-- INSERT INTO till (id_store, name, active) VALUES (3, 'till2', FALSE);
-- INSERT INTO till (id_store, name, active) VALUES (3, 'till3', FALSE);

-- bucket_queue

-- INSERT INTO bucket_queue (id_store, id_destination_queue, queue_type, priority) VALUES (1, 2, 'bucket_MOBILES_turnS', 2);

-- bucketS

-- INSERT INTO bucket (id_bucket_queue, hour_start, hour_final, quantity) VALUES (1, '00:00:00', '00:05:00', 3);

-- INTERESTING QUERIES

-- -- GET DE turnS IN ORDER OF priority
-- SELECT *
-- FROM turn T JOIN queue Q ON T.id_queue=Q.id
-- WHERE T.STATE LIKE 'WAITING'
-- ORDER BY Q.priority, T.DATE_turn, T.id;

-- LAST bucket IN TIME

/*
SELECT *
FROM bucket
WHERE hour_start = (SELECT MAX(hour_start)
                    FROM bucket
                    WHERE id_bucket_queue = 1)
      AND hour_final = (SELECT MAX(hour_final)
                        FROM bucket
                        WHERE id_bucket_queue = 1)
      AND bucket.id_bucket_queue = 1;


*/

