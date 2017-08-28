<?php
    use Codenest\Library\Config as Config ;
    use Codenest\Library\Session as Session ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=Config::get('site_name')?></title>
</head>
<body>
    <div class="container">
    <?php if (Session::hasFlash()) {?>

    <div class="alert alert-info" role="alert"> <?php Session::flash();?> </div>
    <?php }?>
    </div>
    <?=$data['content']?>
</body>
</html>