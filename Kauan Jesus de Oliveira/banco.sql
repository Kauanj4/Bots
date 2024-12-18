-- DROP DATABASE prova; 
CREATE DATABASE prova;
USE prova;

CREATE TABLE usuario(
	codigo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome   VARCHAR(50),
    email  VARCHAR(50));

CREATE TABLE tarefa(
	codigo        INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descricao     VARCHAR(150),
    setor         VARCHAR(150),
    codigoUsuario INT,
    prioridade    VARCHAR(10),
    statusT       VARCHAR(10),
    FOREIGN KEY (codigoUsuario) REFERENCES usuario(codigo));