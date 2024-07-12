CREATE DATABASE IF NOT EXISTS php;

USE php;

SELECT * FROM prova_final;

CREATE TABLE prova_final(
	idFornecedor int(10) NOT NULL AUTO_INCREMENT primary key,
    razaoSocial varchar(50),
	nomeFantasia varchar(50),
    cnpj int(18),
    responsavel varchar(50),
    email varchar(50),
    ddd int(3),
    telefone varchar(15)
);

INSERT INTO prova_final (idFornecedor, razaoSocial, nomeFantasia, cnpj, responsavel, email, ddd, telefone) VALUES (1, 'TESTE', 'teste', 123456, 'teste', 'teste@gmail.com', 041, 41996602222);

drop table prova_final;

DROP DATABASE php;
