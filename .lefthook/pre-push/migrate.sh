#!/bin/zsh
# Check if sail is enabled
sailEnabled=$(grep -i '^SAIL_ENABLED' .env | cut -d '=' -f2 | tr '[:upper:]' '[:lower:]')
sailCommand=$([[ "$sailEnabled" = "true" ]] && echo "./vendor/bin/sail" || echo "")
echo "Running Tests"
if [ -n "$sailCommand" ]; then
    $sailCommand php artisan migrate
    $sailCommand php artisan db:seed
    $sailCommand php artisan migrate:rollback
else
    php artisan migrate
    php artisan db:seed
    php artisan migrate:rollback
fi
STATUS_CODE=$?
if [ $STATUS_CODE -ne 0 ]; then
    echo "Migration failed"
    exit 1
else
    echo "Migration passed"
fi
