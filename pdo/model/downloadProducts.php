<?php 
require_once ($_SERVER['DOCUMENT_ROOT'] . '/pdo/config.php');
//var_dump($_FILES);
if (isset($_POST['name'])) {
	$productName = $_POST['name'];
	$productPrice = floatval($_POST['price']);
	$productGroups = $_POST['groups'];
	$productCategories = $_POST['categories'];
	$count = count($_FILES['image']['name']);

	for ($i=0; $i < $count; $i++) {
		
		// Получаем имя файла
		$fileName = $_FILES['image']['name'][$i];
		// Получаем расширение файла как есть
		$fileType = $_FILES['image']['type'][$i];
		// Получаем путь к файлу
		$fileTmp = $_FILES['image']['tmp_name'][$i];
		// Получаем данные об имеющихся ошибках
		$fileError = $_FILES['image']['error'];
		// Получаем размер файла в байтах
		$fileSize = $_FILES['image']['size'][$i];
		// Отделяем расширение от имени файла
		$fileExt = explode(".", $_FILES['image']['name'][$i]);
		// Получим актуальное расширение
		$fileActualExt = strtolower(end($fileExt));
		// Создаем массив расширений
		$exp = ["jpg", "jpeg", "png"];
		//Создаём массив для вывода ошибок
		$messages = [];

		// Проверяем загруженные файлы на соответствие количеству, формату и размеру
		if (!is_uploaded_file($_FILES['image']['filename'])) {
	    	$messages = "Файл не загружен! Загрузите изображение";
	    	exit();
	    } else {
	    	if ($count > 5) {
				$messages = "ERROR.Слишком много файлов!";
				exit();
			} else {
				if (!in_array($fileActualExt, $exp)) {
					$messages = "Неверный формат!";
					exit();
				} elseif ($fileSize > 5300576) {
					$messages = "ERROR. Файл слишком большой!";
					exit();
				} else {
					if (is_uploaded_file($fileTmp)) {
							$newFileName = uniqid('', true) . "." . $fileActualExt;
			 				$filePuth = '../pdo/uploads/' . $newFileName;
						if (move_uploaded_file($fileTmp, $filePuth)) {
							$messages = "Файл загружен!";
						} else {
							$messages = "При загрузке файла произошла ошибка!";

						}
					
					} else {
						$messages = "Файл не загружен";
						exit();
					}
				}
			}
			header('Content-Type: application/json');
			echo json_encode($messages, JSON_UNESCAPED_UNICODE);
			exit();
	    }
    }
	
	//Отправляем запрос на добавление данных в БД
	$query = $pdo->prepare("INSERT INTO `products` (id, name, price, image) VALUES (:id, :name, :price,:image)");
	$query->bindParam(':id', $id);
	$query->bindParam(':name', $productName);
	$query->bindParam(':price', $productPrice);
	$query->bindParam(':image', $filePuth);
	$id = NULL;
	$query->execute();

	//Вывод ошибок SQL запросов
	$info = $query->errorInfo();
    var_dump($info);
	
	// Получаем id вставленной записи
	$product_id = $pdo->lastInsertId();
	
	//Получаем id группы товаров
	$groupsQuery = $pdo->prepare("SELECT `id` FROM `groups` WHERE `name`=:name");
	$groupsQuery->bindParam(':name', $productCategories);
	$groupsQuery->execute();
	$idArr = $groupsQuery->fetch(PDO::FETCH_ASSOC);
	$idGroups = intval($idArr['id']);
	//Вывод ошибок SQL запросов
	$info = $groupsQuery->errorInfo();
    var_dump($productCategories);
    var_dump($idArr['id']);
    var_dump($idGroups);
    var_dump($info);

	//Отправлям запрос на добавление id товара и id группы
	$sqlQuery = $pdo->prepare("INSERT INTO `groups_has_products`(groups_id, products_id) VALUES (:gr_id, :pr_id)");
	$sqlQuery->bindParam(':gr_id', $idGroups);
	$sqlQuery->bindParam(':pr_id', $product_id);
	$sqlQuery->execute();
	//Вывод ошибок SQL запросов
	$info = $sqlQuery->errorInfo();
    var_dump($info);
}
