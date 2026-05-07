# E-Commerce Challenge — Starter Kit

Projeto base para desafio técnico de mini sistema de e-commerce.

## Stack

| Tecnologia | Versão |
|---|---|
| PHP | 8.2+ |
| Laravel | 12.x |
| MySQL | 8.0+ |
| jQuery | 3.7.x (CDN) |
| CoreUI | 5.x (CDN) |

## Pré-requisitos

| Opção | Requisitos |
|---|---|
| **Docker** (recomendado) | Docker 24+ e Docker Compose v2 |
| **Local** | PHP 8.2+, Composer 2.x, MySQL 8.0+ |

---

## Setup com Docker (recomendado)

### 1. Setup completo em um comando

Com `make` instalado:
```bash
make setup
```

Sem `make` (shell puro):
```bash
./setup.sh          # sobe sem seed
./setup.sh --seed   # sobe + popula banco
```

O entrypoint cuida automaticamente de `key:generate` e `migrate` na primeira execução.

### 2. Popular com dados de exemplo

```bash
make seed
# ou
docker compose exec app php artisan db:seed
```

Cria:
- Usuário padrão: `admin@example.com` / `password`
- 8 produtos de exemplo

### 3. Acessar

```
http://localhost:8000
```

### Comandos úteis

| Com `make` | Equivalente direto |
|---|---|
| `make up` | `docker compose up -d` |
| `make down` | `docker compose down` |
| `make logs` | `docker compose logs -f` |
| `make shell` | `docker compose exec app bash` |
| `make migrate` | `docker compose exec app php artisan migrate` |
| `make fresh` | `docker compose exec app php artisan migrate:fresh --seed` |
| `make tinker` | `docker compose exec app php artisan tinker` |
| `make test` | `docker compose exec app php artisan test` |
| `make db-shell` | `docker compose exec db mysql -ularavel -psecret ecommerce_challenge` |

> Para instalar o `make` no Ubuntu/Debian: `sudo apt-get install -y make`

### Serviços e portas padrão

| Serviço | URL / Porta |
|---|---|
| Aplicação (Nginx) | http://localhost:8000 |
| MySQL | localhost:3306 |
| PHP-FPM | interno (porta 9000) |

> Para alterar as portas, edite `APP_PORT` e `DB_FORWARD_PORT` no `.env`.

---

## Setup local (sem Docker)

### 1. Instalar dependências PHP

```bash
composer install
```

### 2. Configurar o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Edite o `.env` e preencha as credenciais do banco:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_challenge
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

### 3. Criar o banco de dados

```sql
CREATE DATABASE ecommerce_challenge CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Executar as migrações

```bash
php artisan migrate
php artisan db:seed   # opcional — dados de exemplo
```

### 5. Iniciar o servidor

```bash
php artisan serve
```

Acesse: [http://localhost:8000](http://localhost:8000)

---

## Arquitetura Docker

```
┌─────────────────────────────────────────────┐
│              docker-compose                  │
│                                             │
│  ┌──────────┐   ┌──────────┐   ┌─────────┐ │
│  │  nginx   │──▶│  app     │──▶│  db     │ │
│  │ :8000    │   │ PHP-FPM  │   │ MySQL   │ │
│  │          │   │ :9000    │   │ :3306   │ │
│  └──────────┘   └──────────┘   └─────────┘ │
│                                             │
│  Volume: dbdata (dados MySQL persistidos)   │
└─────────────────────────────────────────────┘
```

| Arquivo | Função |
|---|---|
| `Dockerfile` | Imagem PHP 8.2-FPM com extensões e Composer |
| `docker-compose.yml` | Orquestra app + nginx + MySQL |
| `docker/nginx/default.conf` | Virtual host Nginx → PHP-FPM |
| `docker/php/local.ini` | Configurações PHP (upload, timezone, etc.) |
| `docker/mysql/my.cnf` | Charset UTF-8 para o MySQL |
| `docker/entrypoint.sh` | Inicialização: aguarda DB, key:generate, migrate |
| `.env.docker` | Variáveis de ambiente prontas para Docker |
| `Makefile` | Atalhos para os comandos mais comuns |

---

## Estrutura do projeto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/               # Autenticação (Breeze)
│   │   ├── DashboardController.php
│   │   ├── ProductController.php
│   │   └── OrderController.php
│   └── Requests/
│       └── Auth/LoginRequest.php
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Order.php
│   ├── OrderItem.php
│   └── OrderStatusHistory.php
└── Services/
    ├── OrderService.php        # TODO: implementar lógica de pedidos
    └── ProductService.php      # TODO: implementar lógica de estoque

database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    └── ProductSeeder.php

resources/views/
├── layouts/
│   ├── app.blade.php           # Layout principal (sidebar + navbar CoreUI)
│   └── guest.blade.php         # Layout para login/registro
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── dashboard.blade.php
├── products/
│   ├── index.blade.php
│   └── show.blade.php
└── orders/
    ├── index.blade.php
    └── show.blade.php

routes/
├── web.php                     # Rotas principais (protegidas por auth)
└── auth.php                    # Rotas de autenticação
```

## Rotas disponíveis

| Método | URI | Nome | Descrição |
|--------|-----|------|-----------|
| GET | `/` | — | Redireciona para dashboard |
| GET | `/login` | `login` | Formulário de login |
| POST | `/login` | — | Processar login |
| GET | `/register` | `register` | Formulário de cadastro |
| POST | `/register` | — | Processar cadastro |
| POST | `/logout` | `logout` | Encerrar sessão |
| GET | `/dashboard` | `dashboard` | Dashboard |
| GET | `/produtos` | `products.index` | Lista de produtos |
| GET | `/produtos/{id}` | `products.show` | Detalhes do produto |
| GET | `/pedidos` | `orders.index` | Lista de pedidos |
| GET | `/pedidos/{id}` | `orders.show` | Detalhes do pedido |

## Models e relacionamentos

```
User         hasMany  Order
Order        belongsTo  User
             hasMany    OrderItem
             hasMany    OrderStatusHistory
OrderItem    belongsTo  Order
             belongsTo  Product
Product      hasMany    OrderItem
```

## Status de pedidos

| Valor | Descrição |
|-------|-----------|
| `pendente` | Aguardando confirmação |
| `confirmado` | Pedido confirmado |
| `em_preparacao` | Em separação |
| `enviado` | Despachado para entrega |
| `entregue` | Entregue ao cliente |
| `cancelado` | Pedido cancelado |

---

## O que o candidato deve implementar

- [ x ] Fluxo completo de criação de pedido com validação de estoque
- [ x ] Transição de status com regras de negócio
- [ x ] Integração com serviço de logística (rastreamento / cálculo de frete)
- [ x ] Endpoints REST para pedidos (`store`, `updateStatus`, cancelamento)
- [ x ] CRUD completo de produtos
- [ ] Testes unitários/feature para lógica de pedidos

Os métodos marcados com `// TODO (candidato)` nos controllers e services são os pontos de entrada sugeridos.
