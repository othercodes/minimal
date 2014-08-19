<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <script src="<?php Url::setUrl('js/jquery.js'); ?>"></script>
        <title><?php echo $demo; ?></title>
        <script>
            $(document).ready(function(){
                $.ajax({
                    method: "GET",
                    url: "demo/api/unay",
                    success:function(result){
                    $("#log").html(result);
                }});
            });
        </script>
    </head>
    <body>
        <div><?php $this->language->translate('HELLOWORLD'); ?></div>
    </body>
</html>
