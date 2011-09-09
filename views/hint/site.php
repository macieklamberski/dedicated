<?php foreach ($messages as $message): ?>
  <div class="message message-<?php echo $message['type'] ?>">
    <p><?php echo $message['text'] ?></p>
  </div>
<?php endforeach ?>