<meta charset="utf-8"><link rel="stylesheet" href="//kodaktor.ru/css/formstyle1?hehe">
<h1>Работа с отзывами... </h1>
<?php
  $conn = require_once ('bd.php');
  $conn -> exec('SET CHARACTER SET utf8');
  $f = '<h2>Форма для заполнения... </h2>';
  if ($_SERVER['REQUEST_METHOD']==='POST') {
      $r = array_map(function($x){return htmlentities($x);}, [ $_POST['name']  ??  'Unknown user', $_POST['email']  ?? 'anon@mail.ru', $_POST['text']  ?? 'Пустое сообщение']);
      $sql =  "INSERT  INTO `reviews` (`name`, `email`, `text`) VALUES ('{$r[0]}','{$r[1]}', '{$r[2]}');";
      $result = $conn -> query($sql);
      if ($result) {
         $f = '<style>.right {width: 60%; margin-left: 35%; zoom: 80%}</style><div class="right"><h2>Добавить ещё один отзыв...</h2></div>';
         $i = '<h3>Данные успешно вставлены!</h3>';
         $f = fopen('log.txt', 'a'); fwrite($f, $conn -> lastInsertId());
         fwrite($f, "\n"); fclose($f);
      } else {
         $i = '<h4>Что-то не так!</h4>';
      }
      echo $i;
  }
  echo $f;
  echo "<div class=\"right\"><form method=\"post\" action=\"//{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}\" >";
  echo require_once ('form.php');
  echo "</form></div>";
  echo "<h2>Список отзывов... </h2>\n";
  echo require_once ('table.php');
