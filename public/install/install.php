<?php

require __DIR__.'/../../system/vendor/autoload.php';

$app = require_once __DIR__.'/../../system/bootstrap/app.php';

use Illuminate\Encryption\Encrypter;

function generateRandomKey()
{
    return 'base64:'.base64_encode(
        Encrypter::generateKey('AES-256-CBC')
    );
}

function rrmdir($dir) 
{ 
    if (is_dir($dir)) { 
      $objects = scandir($dir); 
      foreach ($objects as $object) { 
        if ($object != "." && $object != "..") { 
          if (is_dir($dir."/".$object))
            rrmdir($dir."/".$object);
          else
            unlink($dir."/".$object); 
        } 
      }
      rmdir($dir); 
    } 
  }

if (isset($_POST['submit'])) {
    $host         = $_POST['host'];
    $database     = $_POST['database'];
    $username     = $_POST['username'];
    $password     = $_POST['password'];
    $envatoApiKey = $_POST['envato'];
    $url          = $_POST['url'];

    $env = file_get_contents('.env.template');
    $env = str_replace('[MYSQL_HOST]', $host, $env);
    $env = str_replace('[MYSQL_DATABASE]', $database, $env);
    $env = str_replace('[MYSQL_USER]', $username, $env);
    $env = str_replace('[MYSQL_PASS]', $password, $env);
    $env = str_replace('[ENVATO_API_KEY]', $envatoApiKey, $env);

    $env = str_replace('[APP_URL]', $url, $env);
    $env = str_replace('[APP_KEY]', generateRandomKey(), $env);

    if (!file_exists('../../.DEV-MODE')) {
      file_put_contents('../../system/.env', $env);
      rrmdir(realpath('../install'));
    } else {
      echo '<pre>' . $env . '</pre>';
    }
}