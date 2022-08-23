/* #btn это слушатель положения кнопки
При нажатии кнопки вызывается метод sendAjaxForm */
$(document).ready(function() {
    $('#ajax_form').on('submit', function (e) {
            e.preventDefault();
			sendAjaxForm();
		}
	);
});
 
function sendAjaxForm() {
    
    formData = new FormData(document.getElementById("ajax_form"));
    formData.append('file', $("#image")[0].files[0]);

    $.ajax({
        url:    "http://localhost/pdo/model/downloadProducts.php", //url страницы
        method: "post", //метод отправки
        contentType: false, // убираем форматирование данных по умолчанию
        processData: false, // убираем преобразование строк по умолчанию
        //dataType: "json", //формат данных
        data: formData,  // Сеарилизуем объект
        cache: false,
    	success: function(response) {
           // var data = JSON.parse(response);
           console.log(response);
           // $('#result_form').html(data);
    	},
         error: function(response) {
            console.log(response);
            $('#result_form').html('Ошибка. Что-то пошло не так!');
        },
 	});
    return false;
}