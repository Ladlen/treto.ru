<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php echo $this->htmlVar('title') ?></title>
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <?php
        foreach (self::$css as $path)
        {
            echo "<link rel='stylesheet' type='text/css' href='$path'/>\n";
        }
        foreach (self::$scripts as $path)
        {
            echo "<script type='text/javascript' src='$path'></script>\n";
        }
    ?>
</head>
<body>
    <?php echo $content ?>
</body>
</html>
