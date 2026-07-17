<?php
// Ultra-light health/keep-alive endpoint (~20 bytes) for uptime pings
// (e.g. cron-job.org). Avoids "output too large" errors from full-page fetches.
http_response_code(200);
header('Content-Type: text/plain; charset=utf-8');
echo 'ok';
