Mini E-Commerce

Projeto base para desafio técnico de um mini sistema de e-commerce.

Tecnologias usadas

PHP 8.2+
Laravel 12
MySQL 8
jQuery
CoreUI

Rodando com Docker

Subir o projeto

docker compose up -d

Instalar dependências

docker compose exec app composer install

Configurar ambiente

cp .env.example .env

Gerar chave do Laravel

docker compose exec app php artisan key:generate

Rodar migrations

docker compose exec app php artisan migrate

Popular banco (opcional)

docker compose exec app php artisan db:seed

Acessar

http://localhost:8000

Rodando sem Docker

Instalar dependências

composer install

Configurar ambiente

cp .env.example .env

php artisan key:generate

Configure o banco no arquivo .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_challenge
DB_USERNAME=root
DB_PASSWORD=

Criar banco

CREATE DATABASE ecommerce_challenge;

Rodar migrations

php artisan migrate

Popular banco (opcional)

php artisan db:seed

Iniciar projeto

php artisan serve

Acessar

http://localhost:8000

Estrutura do projeto

app/

Http/
Models/
Services/

database/

migrations/
seeders/

resources/views/

routes/

Funcionalidades

Login e cadastro
Listagem de produtos
Visualização de pedidos
CRUD de produtos
Controle de status do pedido

Status dos pedidos

pendente
confirmado
em_preparacao
enviado
entregue
cancelado

O que precisa ser feito

[x] Fluxo de pedidos
[x] Controle de estoque
[x] Alteração de status
[x] Integração com logística
[x] API de pedidos
[x] CRUD de produtos
[ ] Testes automatizados

Os pontos com TODO no projeto são os locais sugeridos para implementação.
