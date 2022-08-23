<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/pdo/config.php');
//Запрос в БД списка групп товаров
$name_groups_query = $pdo->prepare("SELECT `name` FROM `groups`");
	$name_groups_query->execute();
	$group_names = $name_groups_query->fetchAll(PDO::FETCH_COLUMN);
	
	//Вывод ошибок SQL запросов
	$info = $name_groups_query->errorInfo();
    //var_dump($info);
    var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script type="text/javascript" src="js/jQuery v3.6.0.js"></script>
</head>
<body>
	<form  id="ajax_form" enctype="multipart/form-data">
		<input type="text" name="name" placeholder="Название товара"><br><br>
		<input type="number" name="price" placeholder="Цена"><br><br>
		<label>Изображение товара</label><br>
		<input type="file" name="image[]" id="image" multiple><br><br>
		<label>Выберте категорию</label><br>
		<select name="categories">
			<?php foreach ($group_names as $value) {?>
				<option value="<?=$value?>"><?=$value?></option>
			<?php } ?>
		</select><br><br>
		<label>New</label>
		<input type="radio" id="new" name="groups" value="New">
		<label>Sale</label>
		<input type="radio" id="sale" name="groups" value="Sale"><br><br>
		<button type="submit" id="btn" name="submit">Отправить</button>
		<div id="result_form"></div>
		<?php
            if ($messages) {
                echo '<p class="msg" id="result">' . $messages . '</p>';
            };
            unset($messages);
        ?>
	</form>
	 <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script> -->
	 <script src="js/ajax.js"></script>
</body>
</html>