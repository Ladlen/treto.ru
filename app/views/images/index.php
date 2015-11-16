<script type="text/javascript">

    var breakworkImages =
    {
        "imageHeight" : <?php echo $this->config['brickworkImages']['dimensions']['height'] ?>,  // px
        "imageDistance" : <?php echo $this->config['brickworkImages']['dimensions']['margin'] ?>,  // px - расстояние по краям изображений
        "bundleCount" :  <?php echo $this->config['brickworkImages']['bundleCount'] ?>
    }

    breakworkImages.aFunc = function () {alert("+++++++++++++++++++");};


    breakworkImages.aFunc();

    /*$(function () {
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
    });*/
</script>

<div id="content"></div>