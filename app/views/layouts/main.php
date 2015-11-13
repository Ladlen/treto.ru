<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php echo $this->htmlVar('title') ?></title>
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <?php echo $cssScripts ?>
    <?php echo $jsScripts['header'] ?>
</head>
<body>
    <?php echo $content ?>
    <?php echo $jsScripts['end'] ?>
</body>
</html>
