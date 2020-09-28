<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>

    <style type="text/css">
        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        #container>h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #body {
            margin: 0 15px 0 15px;
            padding: 5% 20%;
            text-align: center;
        }

        p.footer {
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }

        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }

        .row {
            display: flex;
            flex-direction: row;
        }

        a {
            border-radius: 20px;
            background-color: blue;
            color: whitesmoke;
            padding: 10px 20px;
            text-decoration: none;
        }

        a:hover {
            background-color: #003399;
            animation-duration: 4s;

        }
    </style>
</head>

<body>

    <div id="container">
        <h1>Welcome to CodeIgniter Generator!</h1>

        <div id="body">
            <h1 style="margin-bottom: 50px;">Pilih Fitur</h1>
            <div class="row">
                <div style="flex: 1;">
                    <a href="harviacode?type=1" target="_blank">Fullstack</a>
                </div>
                <div style="flex: 1;">
                    <a href="harviacode?type=2" target="_blank">Rest API</a>
                </div>
            </div>
        </div>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>

</body>

</html>