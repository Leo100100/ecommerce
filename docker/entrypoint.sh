#!/bin/bash
set -e

echo "==> Aguardando banco de dados em ${DB_HOST}:${DB_PORT}..."
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
    sleep 2
done
echo "==> Banco de dados disponível."

# Garante permissões corretas nos diretórios de escrita
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Instala dependências se vendor estiver ausente (ex: volume montado sem o vendor)
if [ ! -d "/var/www/vendor" ]; then
    echo "==> vendor/ não encontrado — executando composer update..."
    composer update --no-interaction --prefer-dist --optimize-autoloader --no-scripts
fi

# Gera APP_KEY apenas se o .env ainda não tiver uma chave válida
if ! grep -qE '^APP_KEY=base64:.{40,}$' /var/www/.env; then
    echo "==> Gerando APP_KEY..."
    php artisan key:generate --force
fi

# Otimiza configuração
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# Executa migrações
echo "==> Executando migrações..."
php artisan migrate --force

echo "==> Iniciando PHP-FPM..."
exec "$@"
