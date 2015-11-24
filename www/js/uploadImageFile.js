$(function () {

    breakworkImages.showImage = function (image) {
        var container = "<div><img src='/images/" + image.uid + "'/></div>";
        $("#content").append(container);
    }

    breakworkImages.retrieve = function (amount) {
        var that = this;
        var data = {'amount': amount};
        $.ajax({
            url: '/images/retrieve',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            success: function (respond) {
                if (respond.success) {
                    for (var img in respond.result) {
                        that.showImage(respond.result[img]);
                    }
                }
            },
            error: function (jqXHR, textStatus) {
                alert('Ошибка AJAX запроса: ' + textStatus);
            }
        });
    }

    breakworkImages.sendFile = function (data) {
        var that = this;
        data.append("bundleCount", this.bundleCount);
        $.ajax({
            url: '/images/addFile',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            success: function (respond) {
                if (respond.success) {
                    that.retrieve(that.bundleCount);
                }
            },
            error: function (jqXHR, textStatus) {
                alert('Ошибка AJAX запроса: ' + textStatus);
            }
        });
    }

    $("#upload_file_form").submit(function (event) {
        event.stopPropagation();
        event.preventDefault();

        if ($("#file_to_upload").get(0).files[0]) {
            var data = new FormData();
            data.append("file", $("#file_to_upload").get(0).files[0]);
            breakworkImages.sendFile(data);
        }
        else {
            alert("Выберите файл со списком изображений.");
        }
        return false;
    });

});



