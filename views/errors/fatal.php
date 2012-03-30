<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ups! Something went wrong!</title>
    <style>
      body { font-family: Calibri, Arial, sans-serif; text-align: center; width: 100%; position: absolute; top: 30% }
      a    { color: #777 }
      h1   { font-size: 24px; color: #555; margin: 0 0 15px }
      p    { font-size: 16px; color: #999; margin: 0 }
      img  { margin-bottom: 20px; border: 0 }
    </style>
  </head>
  <body>
    <div>
<?php if (file_exists(DOCROOT.'images/logo.png')): ?>
      <a href="<?php echo Kohana::$base_url.Route::get('site-index')->uri() ?>">
        <img src="<?php echo Kohana::$base_url ?>images/logo.png" alt="">
      </a>
<?php endif ?>
      <h1>Ups! Something went wrong.</h1>
      <p>We have been informed about the problem and we will try to fix it as soon as possible.</p>
      <p>For now, please try go back to <a href="<?php echo Kohana::$base_url.Route::get('site-index')->uri() ?>">home page</a>.</p>
    </div>
  </body>
</html>