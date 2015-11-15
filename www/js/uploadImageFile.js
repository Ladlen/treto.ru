$(function () {

    /*$("#upload_file").click(function (event) {
        event.stopPropagation();

        var file = $("#uploaded_file").val();
        if (file) {
            var data = new FormData();
            data.append("file", file);
            sendFile(data);
        }
        else {
            alert("Выберите файл со списком изображений.");
        }
        return false;
    });*/

    $("#upload_file_form").submit(function (event) {
        event.stopPropagation();
        event.preventDefault();

        var file = $("#file_to_upload").val();
        if (file) {
            var data = new FormData();
            //data.append("file", file);
            data.append("file", $("#file_to_upload").get(0).files[0]);
            sendFile(data);
        }
        else {
            alert("Выберите файл со списком изображений.");
        }
        return false;
    });


    function sendFile(data) {
        $.ajax({
            url: '/images/addFile',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            success: function (respond, textStatus, jqXHR) {

                // Если все ОК

                /*if (typeof respond.error === 'undefined') {
                    // Файлы успешно загружены, делаем что нибудь здесь

                    // выведем пути к загруженным файлам в блок '.ajax-respond'

                    var files_path = respond.files;
                    var html = '';
                    $.each(files_path, function (key, val) {
                        html += val + '<br>';
                    })
                    $('.ajax-respond').html(html);
                }
                else {
                    console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error);
                }*/
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ОШИБКИ AJAX запроса: ' + textStatus);
            }
        });
    }

});



