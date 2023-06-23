-- Create table "doador"
CREATE TABLE doador (
                        nome VARCHAR(100) PRIMARY KEY,
                        endereco VARCHAR(200) NOT NULL,
                        cidade VARCHAR(100) NOT NULL,
                        uf VARCHAR(2) NOT NULL,
                        telefone VARCHAR(15) NOT NULL,
                        email VARCHAR(100) NOT NULL,
                        senha VARCHAR(100) NOT NULL
);

-- Create table "pet"
CREATE TABLE pet (
                     nome VARCHAR(100) PRIMARY KEY,
                     idade INT NOT NULL,
                     especie VARCHAR(50) NOT NULL,
                     raca VARCHAR(50) NOT NULL,
                     local VARCHAR(100) NOT NULL,
                     procedimentos VARCHAR(200),
                     informacoes VARCHAR(200),
                     nome_doador VARCHAR(100),
                     FOREIGN KEY (nome_doador) REFERENCES doador(nome)
);