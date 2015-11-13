<!--<form enctype="multipart/form-data" action="<?php echo '/images/addFile' ?>" method="post">
    <input type="file" id="add_file" name="add_file"/>
    <input type="submit" value="ОТПРАВИТЬ"/>
</form>-->

<input type="file" id="uploaded_file"/>
<a href="#" id="upload_file">ОТПРАВИТЬ</a>

<?php (new ImagesController($this->config))->actionIndex() ?>

