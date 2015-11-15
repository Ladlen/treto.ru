<!--<form enctype="multipart/form-data" action="<?php echo '/images/addFile' ?>" method="post">
    <input type="file" id="add_file" name="add_file"/>
    <input type="submit" value="ОТПРАВИТЬ"/>
</form>-->

<form enctype="multipart/form-data" method="post" id="upload_file_form">
    <!--<input type="file" id="uploaded_file"/>
    <a href="#" id="upload_file">ОТПРАВИТЬ</a>-->
    <input type="file" name="file_to_upload" id="file_to_upload"/>
    <input type="submit" value="ОТПРАВИТЬ" />
</form>

<?php (new ImagesController($this->config))->actionIndex() ?>

