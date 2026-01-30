<?php
declare(strict_types=1);

require __DIR__ . '/storage.php';

$errors = [];
$oldName = '';
$oldMsg  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // TODO: read input
    $name = ''; // $_POST['name']
    $msg  = ''; // $_POST['message']

    // TODO: keep old values
    // $oldName = ...
    // $oldMsg  = ...

    // TODO: validate (name >= 2, message >= 5)
    // $errors[] = '...';

    // TODO: if ok -> add_message + redirect
}

$messages = []; // TODO: load_messages()
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
      <?php /* TODO: print errors */ ?>
    </ul>
  <?php endif; ?>

  <form method="post">
    <p>
      <label>
        Name:
        <input name="name" required minlength="2" value="<?php /* TODO: echo e($oldName) */ ?>">
      </label>
    </p>

    <p>
      <label>
        Message:<br>
        <textarea name="message" required minlength="5" rows="4" cols="50"><?php /* TODO: echo e($oldMsg) */ ?></textarea>
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
        <strong><?php /* TODO: echo e($m['name']) */ ?></strong>
        <small><?php /* TODO: echo date(...) */ ?></small>
      </p>

      <p><?php /* TODO: echo nl2br(e($m['message'])) */ ?></p>
      <hr>
    </div>
  <?php endforeach; ?>
</body>
</html>
