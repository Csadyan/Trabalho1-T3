-- 1. Cria o banco de dados (schema) se ele ainda não existir.
CREATE SCHEMA IF NOT EXISTS loja_db 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- 2. Seleciona o banco de dados 'loja_db' para usar nos comandos seguintes.
USE loja_db;

-- 3. Cria as tabelas dentro do 'loja_db'

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  tipo ENUM('cliente', 'vendedor') NOT NULL DEFAULT 'cliente'
);

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10, 2) NOT NULL
);

-- Tabela do carrinho
CREATE TABLE IF NOT EXISTS carrinho (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_produto INT NOT NULL,
  quantidade INT NOT NULL DEFAULT 1,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
    ON DELETE CASCADE, -- (Opcional) Se o usuário for deletado, limpa o carrinho dele.
  FOREIGN KEY (id_produto) REFERENCES produtos(id)
    ON DELETE CASCADE  -- (Opcional) Se o produto for deletado, remove ele do carrinho.
);