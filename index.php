<?php
declare(strict_types=1);

require __DIR__ . '/storage.php';

$errors = [];
$oldName = '';
$oldMsg  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // read input
    $name = trim($_POST['name'] ?? '');
    $msg  = trim($_POST['message'] ?? '');

    // keep old values
    $oldName = $name;
    $oldMsg  = $msg;

    // validate
    if (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters long.';
    }

    if (strlen($msg) < 5) {
        $errors[] = 'Message must be at least 5 characters long.';
    }

    // if ok -> save + redirect (PRG)
    if (!$errors) {
        add_message($name, $msg);
        header('Location: /');
        exit;
    }
}

// load messages
$messages = load_messages();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mini Guestbook</title>
</head>
<body>
  <h1>Mini Guestbook</h1>

  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= e($error) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post">
    <p>
      <label>
        Name:
        <input name="name" required minlength="2" value="<?= e($oldName) ?>">
      </label>
    </p>

    <p>
      <label>
        Message:<br>
        <textarea name="message" required minlength="5" rows="4" cols="50"><?= e($oldMsg) ?></textarea>
      </label>
    </p>

    <button type="submit">Save</button>
  </form>

  <hr>

  <h2>Messages</h2>

  <?php if (!$messages): ?>
    <p>No messages yet.</p>
  <?php endif; ?>

  <?php foreach ($messages as $m): ?>
    <div>
      <p>
        <strong><?= e($m['name']) ?></strong>
        <small><?= date('Y-m-d H:i', $m['time']) ?></small>
      </p>

      <p><?= nl2br(e($m['message'])) ?></p>
      <hr>
    </div>
  <?php endforeach; ?>
</body>
</html>
