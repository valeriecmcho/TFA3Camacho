#!/usr/bin/env bash
set -euo pipefail
mkdir -p writable/cache writable/logs writable/session writable/uploads
exec php -S 0.0.0.0:"${PORT:-8080}" -t public public/router.php
