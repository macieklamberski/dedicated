<?php foreach ($messages as $message): ?>
  <div class="message message-<?php echo $message['type'] ?>">
    <p><?php echo $message['text'] ?></p>
    <a href="#" class="close"><?php echo __('Zamknij') ?></a>
  </div>
<?php endforeach ?>