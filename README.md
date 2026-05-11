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




Integração ASAAS (PIX + Boleto)

O sistema possui integração com a API do ASAAS para pagamentos via:

PIX
Boleto bancário

Configurar variáveis no .env
ASAAS_API_URL=https://sandbox.asaas.com/api/v3
ASAAS_API_KEY=
ASAAS_WEBHOOK_SECRET=

Para produção:

ASAAS_API_URL=https://api.asaas.com/api/v3
Rodar migrations

Docker:

docker compose exec app php artisan migrate

Sem Docker:

php artisan migrate
Configurar webhook do ASAAS

O webhook é responsável por atualizar automaticamente o status dos pedidos após confirmação do pagamento.

Rota do webhook:

POST /asaas/webhook

Exemplo usando ngrok:

https://SEU_NGROK.ngrok-free.app/asaas/webhook
Eventos recomendados

Ativar no painel do ASAAS:

PAYMENT_RECEIVED
PAYMENT_CONFIRMED
PAYMENT_OVERDUE
PAYMENT_CANCELED
Testar webhook localmente

Rodar ngrok:

ngrok http 8000

Depois configurar a URL gerada no painel do ASAAS.

Fluxo de pagamento
Cliente adiciona produtos ao carrinho
Escolhe pagamento via PIX ou boleto
Sistema gera cobrança no ASAAS
ASAAS envia webhook após confirmação
Pedido é atualizado automaticamente
Campos adicionados na tabela orders
asaas_payment_id
asaas_invoice_url
asaas_bank_slip_url
Status automáticos do pedido
aguardando_pagamento
pago
vencido
cancelado

