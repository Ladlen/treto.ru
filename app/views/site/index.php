<form enctype="multipart/form-data" method="post" id="upload_file_form">
    <input type="file" name="file_to_upload" id="file_to_upload"/>
    <input type="submit" value="ОТПРАВИТЬ" />
</form>

<?php (new ImagesController($this->config))->actionInitHtml() ?>

