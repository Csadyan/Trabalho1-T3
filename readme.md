# T1 - Sistema de Vendas (WEB 2)

Este é um projeto para a disciplina de WEB 2, que implementa um sistema de vendas simples com PHP puro, MySQL e Bootstrap.

O sistema possui dois tipos de usuários (Cliente e Vendedor) e implementa funcionalidades de autenticação, CRUD de produtos e um carrinho de compras.

---

## Tecnologias Utilizadas

* **Front-end:** HTML5, CSS3, Bootstrap 5
* **Back-end:** PHP 8 
* **Banco de Dados:** MySQL
* **Conexão DB:** PDO
* **Relatórios:** Biblioteca FPDF

---

## Instruções de Instalação e Execução
**Pré-requisitos:**
* Xamp
* MySQL (MariaDB)
* PHP

**Passos:**

1.  Clone ou baixe este repositório para a pasta `htdocs` do seu XAMPP.

2.  Abra o `phpMyAdmin` (ex: `http://localhost/phpmyadmin`).

3.  Crie um novo banco de dados chamado `loja_db`.

4.  Selecione o banco `loja_db` e vá para a aba **Importar**.

5.  Importe o arquivo `banco.sql` (disponível neste repositório) para criar todas as tabelas. 

6.  Acesse o projeto no seu navegador: `http://localhost/T3 Trabalho-1/`

---

## 📝 Como Usar

### Vendedor (Administrador)
1.  Acesse a pagina de registro
2.  Crie um novo usuário e selecione o tipo **"Vendedor"**.
3.  Faça login.
4.  Use o link **"Administração"** no menu para acessar o CRUD de produtos.
5.  Você pode criar, editar, deletar e gerar relatórios em PDF dos produtos.

### Cliente
1.  Acesse a pagina de registro
2.  Crie um novo usuário (o tipo padrão é "Cliente").
3.  Faça login.
4.  Na página inicial, você pode adicionar produtos ao carrinho.
5.  Use o link **"Consultar Carrinho"** para ver seus itens e "finalizar a compra" (que esvazia o carrinho).