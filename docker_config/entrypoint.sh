#!/bin/sh
set -e

# Run standard Laravel production commands

# Note: In a real production environment with horizontal scaling, 
# migrations should be run by a separate release phase or a single leader instance,
# not by every container on startup.
# However, for this setup, we'll run it here.
echo "Running migrations..."
php artisan migrate --force

echo "Creating storage link..."
php artisan storage:link

echo "Starting Apache..."
exec "$@"
