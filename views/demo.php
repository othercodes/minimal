<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title><?php echo $demo; ?></title>
    </head>
    <body>
        <div><?php $this->language->translate('HELLOWORLD'); ?></div>
        <div>
            <button id="chicos">chicos</button>
            <button id="chicas">chicas</button>
            <button id="todos">todos</button>
        </div>
        <div id="name"></div>
        <div id="surname"></div>
    </body>
</html>
