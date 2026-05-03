#!/usr/bin/env bash
# Uso: ./setup.sh [--seed]
set -e

COMPOSE="docker compose"

echo "==> Copiando .env.docker para .env..."
cp .env.docker .env

echo "==> Buildando imagens..."
$COMPOSE build --no-cache

echo "==> Subindo containers..."
$COMPOSE up -d

echo "==> Aguardando aplicação ficar pronta..."
sleep 5

if [[ "$1" == "--seed" ]]; then
    echo "==> Populando banco com dados de exemplo..."
    $COMPOSE exec app php artisan db:seed
fi

echo ""
echo "✓ Pronto! Acesse: http://localhost:${APP_PORT:-8000}"
echo ""
echo "Outros comandos úteis:"
echo "  docker compose exec app php artisan migrate"
echo "  docker compose exec app php artisan db:seed"
echo "  docker compose exec app bash"
echo "  docker compose logs -f"
echo "  docker compose down"
