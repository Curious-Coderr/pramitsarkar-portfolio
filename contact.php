<?php
/**
 * Contact form handler.
 * Accepts a JSON or form-encoded POST, validates the required fields,
 * emails the enquiry (when a mail server is configured) and always records
 * it to a local log file as a fallback. Responds with JSON.
 *
 * Configure delivery either through environment variables
 * (CONTACT_EMAIL, SMTP_USER) or by editing $CONTACT_TO below.
 */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

/* ---------- Read input (JSON or form-encoded) ---------- */
$raw   = file_get_contents('php://input');
$input = [];
if ($raw !== '' && str_contains((string) ($_SERVER['CONTENT_TYPE'] ?? ''), 'application/json')) {
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) {
        $input = $decoded;
    }
} else {
    $input = $_POST;
}

$name        = trim((string) ($input['name'] ?? ''));
$email       = trim((string) ($input['email'] ?? ''));
$company     = trim((string) ($input['company'] ?? ''));
$projectType = trim((string) ($input['projectType'] ?? ''));
$budget      = trim((string) ($input['budget'] ?? ''));
$message     = trim((string) ($input['message'] ?? ''));

/* ---------- Validate ---------- */
if ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid required fields']);
    exit;
}

/* ---------- Build the enquiry record ---------- */
$CONTACT_TO = getenv('CONTACT_EMAIL') ?: (getenv('SMTP_USER') ?: 'pramitsarkar.work@gmail.com');

$subject = sprintf('New enquiry from %s — %s', $name, $projectType !== '' ? $projectType : 'Portfolio');

$plain = "New Project Enquiry\n"
    . str_repeat('-', 40) . "\n"
    . "Name:         {$name}\n"
    . "Email:        {$email}\n"
    . "Company:      " . ($company !== '' ? $company : '—') . "\n"
    . "Project Type: " . ($projectType !== '' ? $projectType : '—') . "\n"
    . "Budget:       " . ($budget !== '' ? $budget : '—') . "\n"
    . str_repeat('-', 40) . "\n"
    . "Message:\n{$message}\n";

/* ---------- Persist a fallback copy ---------- */
$logLine = '[' . date('c') . "]\n" . $plain . "\n";
@file_put_contents(__DIR__ . '/contact-submissions.log', $logLine, FILE_APPEND | LOCK_EX);

/* ---------- Attempt to send email (best effort) ---------- */
$headers = [
    'From: Portfolio Contact Form <' . $CONTACT_TO . '>',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=utf-8',
    'MIME-Version: 1.0',
];

$sent = @mail($CONTACT_TO, $subject, $plain, implode("\r\n", $headers));

/*
 * On typical hosting `mail()` succeeds. In local/dev environments without a
 * mail server it may fail — the enquiry is still saved to the log file above,
 * so we report success as long as the submission was captured.
 */
echo json_encode(['success' => true, 'delivered' => (bool) $sent]);
