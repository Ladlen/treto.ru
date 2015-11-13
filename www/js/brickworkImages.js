$(function () {
    var imageHeight = 200;  // px
    var imageDistance = 2;  // px - расстояние по краям изображений

    var contentWidth = $("#content").width();
    var contentHeight = $("#content").height();

    /**
     * Вычисление ширины прямоугольника при масштабировании по высоте.
     *
     * @param float imageHeight оригинальная высота
     * @param float imageWidth оригинальная ширина
     * @param float newHeight новая высота
     * @return float вычисленная ширина
     */
    function widthByHeight(imageWidth, imageHeight, newHeight) {
        var newWidth = (newHeight / imageHeight) * imageWidth;
        return newWidth;
    }

    /**
     * Вычисление высоты прямоугольника при масштабировании по ширине.
     *
     * @param float imageHeight оригинальная высота
     * @param float imageWidth оригинальная ширина
     * @param float newWidth новая ширина
     * @return float вычисленная высота
     */
    function heightByWidth(imageWidth, imageHeight, newWidth) {
        var newHeight = (newWidth / imageWidth) * imageHeight;
        return newHeight;
    }

    function calculateLine(images) {
        var currentWidth = 0;
        for (var info in images) {
            var newWidth = widthByHeight(info.width, info.height, imageHeight);
            currentWidth += newWidth + imageDistance * 2;
            if (currentWidth > contentWidth) {
                // проверим общую потерю тела изображений
                // 1-й вариант: выступающее изображение вписывается в текущую строку


                // 2-й вариант: выступающее изображение переносится на текущую строку
            }
        }
    }

    /**
     * Вписать изображения images в ширину width, одновременно вычислив общие потери площади при обрезке.
     *
     * @param array images список данных изображений
     * @param int width ширина к которой надо привести
     */
    function adjustToLine(images, width) {

        var result = {"newImagesParameters" : [], "totalAreaWaste" : 0};

        var totalImagesWidth = 0;   // ширина изображений в необрезанном виде

        $.map(images, function(val) {
            totalImagesWidth += widthByHeight(info.width, info.height, imageHeight);
        });

        var ratio = totalImagesWidth / width;

        if (ratio > 1) {
            // обрезка справа/слева
            result.totalAreaWaste = 0;
            $.map(images, function(info) {
                var newWidth = widthByHeight(info.width, info.height, imageHeight) / ratio;
                var newHeight = heightByWidth(info.width, info.height, newWidth);
                result.newImagesParameters.push({
                    "width" : newWidth,
                    "height" : imageHeight,
                    "left" : -(),
                    "top" : -(newHeight / 2)
                });
                result.totalAreaWaste += newWidth * (newHeight - imageHeight);
            });
        } else if (ratio < 1) {
            // обрезка сверху/снизу
            result.totalAreaWaste = 0;
            $.map(images, function(info) {
                var newWidth = widthByHeight(info.width, info.height, imageHeight) / ratio;
                var newHeight = heightByWidth(info.width, info.height, newWidth);
                result.newImagesParameters.push({
                    "path": info.path,
                    "width": newWidth,
                    "height": imageHeight,
                    "left": 0,
                    "top": -(newHeight / 2)
                });
                result.totalAreaWaste += newWidth * (newHeight - imageHeight);
            });
        } else {
            // ничего не обрезаем
            $.map(images, function(info) {
                var width = widthByHeight(info.width, info.height, imageHeight);
                result.newImagesParameters.push(
                    {
                        "path": info.path,
                        "width": width,
                        "height": imageHeight,
                        "left": left,
                        "top": top
                    }
                );
            }
            result.totalAreaWaste = 0;
        }

        return result;
    }

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/images/retrieve",
        success: function (data) {
            if (data.success) {

            }
            else {
                var msg = 'Ошибка запроса:\n' + data.messages.join('\n');
                alert(msg);
            }
        }
    });
});