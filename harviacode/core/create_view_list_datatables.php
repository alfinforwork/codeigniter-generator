<?php

$string = "<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel=\"stylesheet\" href=\"<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>\"/>
        <link rel=\"stylesheet\" href=\"<?php echo base_url('assets/datatables/datatables.min.css') ?>\"/>
        <style>
            .dataTables_wrapper {
                min-height: 500px
            }
            
            .dataTables_processing {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 100%;
                margin-left: -50%;
                margin-top: -25px;
                padding-top: 20px;
                text-align: center;
                font-size: 1.2em;
                color:grey;
            }
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <div class=\"row\" style=\"margin-bottom: 10px\">
            <div class=\"col-md-4\">
                <h2 style=\"margin-top:0px\">" . ucfirst($table_name) . " List</h2>
            </div>
            <div class=\"col-md-4 text-center\">
                <div style=\"margin-top: 4px\"  id=\"message\">
                    <?php echo \$this->session->userdata('message') <> '' ? \$this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class=\"col-md-4 text-right\">
                <?php echo anchor(site_url('" . $c_url . "/create'), 'Create', 'class=\"btn btn-primary\"'); ?>";
if ($export_excel == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/excel'), 'Excel', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_word == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/word'), 'Word', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_pdf == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/pdf'), 'PDF', 'class=\"btn btn-primary\"'); ?>";
}
$string .= "\n\t    </div>
        </div>
        <table class=\"table table-bordered table-striped\" id=\"mytable\">
            <thead>
                <tr>
                    <th width=\"80px\">No</th>";
foreach ($non_pk as $row) {
    $string .= "\n\t\t    <th>" . label($row['column_name']) . "</th>";
}
$string .= "\n\t\t    <th width=\"200px\">Action</th>
                </tr>
            </thead>
            <tbody id='datatable'>
            </tbody>
            ";

$column_non_pk = array();
foreach ($non_pk as $row) {
    $column_non_pk[] .= "{\"data\": \"" . $row['column_name'] . "\"}";
}
$col_non_pk = implode(',', $column_non_pk);

$string .= "\n\t    
        </table>
        <div class=\"row\">
            <div class=\"col-md-6\">";
if ($export_excel == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/excel'), 'Excel', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_word == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/word'), 'Word', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_pdf == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('" . $c_url . "/pdf'), 'PDF', 'class=\"btn btn-primary\"'); ?>";
}
$string .= "\n\t    </div>
        </div>
        <script src=\"<?php echo base_url('assets/js/jquery.min.js') ?>\"></script>
        <script src=\"<?php echo base_url('assets/datatables/datatables.min.js') ?>\"></script>
        <script type=\"text/javascript\">
            $(document).ready(function() {

                $.ajax({
                    'url':'<?= site_url('$c_url/json') ?>',
                    dataType:'JSON',
                    success:function(res){
                        if (res.length != 0) {
                            var html = '';
                            html += '<tr>';
                            var number = 1;
                            res.map(function(data){
                                html += `<td>\${number++}</td>`;";
foreach ($non_pk as $row) {
    $string .= "html += `<td>\${data.$row[column_name]}</td>`;";
}
$string .= "
                                html += `<td>
                                    <div class='button-group'>
                                        <a href='<?= site_url('$c_url/read/\${data.$pk}') ?>'>read</a> | 
                                        <a href='<?= site_url('$c_url/update/\${data.$pk}') ?>'>update</a> | 
                                        <a href='<?= site_url('$c_url/delete/\${data.$pk}') ?>'>delete</a>
                                    </div>
                                </td>`;
                            })
                            html += '</tr>';
                            $('#datatable').html(html);
                        }
                    }
                });

                $(\"#mytable\").DataTable();
            });
        </script>
    </body>
</html>";


$hasil_view_list = createFile($string, $target . "views/" . $c_url . "/" . $v_list_file);
