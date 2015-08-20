// Переменная куда будут располагаться данные файлов
 
var files;
 
// Вешаем функцию на событие
// Получим данные файлов и добавим их в переменную
 
$('input[type=file]').change(function(){
    files = this.files;
    alert("ok");
});
// Вешаем функцию ан событие click и отправляем AJAX запрос с данными файлов
 
$('.submit.button').click(function( event ){
    event.stopPropagation(); // Остановка происходящего
    event.preventDefault();  // Полная остановка происходящего
 
    // Создадим данные формы и добавим в них данные файлов из files
 
    var data = new FormData();
    $.each( files, function( key, value ){
        alert("ok");
        data.append( key, value );
    });
 
    // Отправляем запрос
 
    $.ajax({
        url: 'scr_techmap.php?f=11',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Не обрабатываем файлы (Don't process the files)
        contentType: false, // Так jQuery скажет серверу что это строковой запрос
        success: function( respond, textStatus, jqXHR ){
 
            // Если все ОК
 
            if( typeof respond.error === 'undefined' ){
                // Файлы успешно загружены, делаем что нибудь здесь
 alert('OK');
                // выведем пути к загруженным файлам в блок '.ajax-respond'
 
                var files_path = respond.files;
                var html = '';
                $.each(files_path,function(key,val){html += val + '<br>';})
                $('#note').html(html);
            }
            else{
                console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
            }
        },
        error: function( jqXHR, textStatus, errorThrown ){
            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
        }
    });
 
});