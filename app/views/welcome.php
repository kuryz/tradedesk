<!DOCTYPE html>
<html>
    <head>
        <title>Fj Frame</title>
        <link rel="stylesheet" type="text/css" href="<?=SITE_URL?>font/lato.css">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato Thin';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 95px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content"><?=(isset($this->user->data()->first_name)) ? ucwords($this->user->data()->first_name) : ''?>
                <div class="title" id="title"><?=$data->code->name?> 4 </div>
            </div>
        </div>
    </body>
</html>
