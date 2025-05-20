CREATE DATABASE sistema_garantias;

USE sistema_garantias;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (usuario, senha) 
VALUES ('admin', MD5('123'));

-- Tabela de lançamentos
CREATE TABLE lancamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estado VARCHAR(50),
    cidade VARCHAR(50),
    cliente VARCHAR(100),
    data_coleta DATE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de baterias vinculadas a cada lançamento
CREATE TABLE baterias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_lancamento INT,
    modelo VARCHAR(100),
    codigo VARCHAR(50),
    rotulo VARCHAR(100),
    FOREIGN KEY (id_lancamento) REFERENCES lancamentos(id) ON DELETE CASCADE
);

CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    estado VARCHAR(50),
    cidade VARCHAR(50)
);

ALTER TABLE lancamentos
DROP COLUMN cliente;


ALTER TABLE lancamentos
ADD COLUMN cliente_id INT,
ADD FOREIGN KEY (cliente_id) REFERENCES cliente(id);


ALTER TABLE lancamentos
ADD COLUMN usuario_id INT DEFAULT NULL;


ALTER TABLE lancamentos
ADD CONSTRAINT fk_usuario_lancamento
FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
ON DELETE SET NULL;

