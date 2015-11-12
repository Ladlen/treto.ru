<script type="text/javascript">
    $(function() {
        var imageHeight = 200;  // px

        var width = $("#content").width();
        var height = $("#content").height();

        var data = {"width": width, "height": height};
        $.ajax({type: "POST",
            dataType: "json",
            url: "/images/retrieve",
            data: data,
            success: function(data)
            {
                if(data.success)
                {
                    $("#list .row[data-id=" + id + "] div." + name).text(value);
                }
                else
                {
                    var msg = 'Ошибка запроса:\n' + data.messages.join('\n');
                    alert(msg);
                }
            }
        });
    });
</script>