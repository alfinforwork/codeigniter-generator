<?php

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class " . $c . " extends RestController
{
    function __construct()
    {
        parent::__construct();
        \$this->load->model('$m');
        \$this->load->library('form_validation');";

if ($jenis_tabel <> 'reguler_table') {
    $string .= "        \n\t\$this->load->library('datatables');";
}

$string .= "
    }";

if ($jenis_tabel == 'reguler_table') {

    $string .= "\n\n    public function index_get()
    {
        \$q = urldecode(\$this->input->get('q', TRUE));
        \$start = intval(\$this->input->get('start'));
        
        if (\$q <> '') {
            \$config['base_url'] = base_url() . '$c_url/index.html?q=' . urlencode(\$q);
            \$config['first_url'] = base_url() . '$c_url/index.html?q=' . urlencode(\$q);
        } else {
            \$config['base_url'] = base_url() . '$c_url/index.html';
            \$config['first_url'] = base_url() . '$c_url/index.html';
        }

        \$config['per_page'] = 10;
        \$config['page_query_string'] = TRUE;
        \$config['total_rows'] = \$this->" . $m . "->total_rows(\$q);
        \$$c_url = \$this->" . $m . "->get_limit_data(\$config['per_page'], \$start, \$q);

        \$this->load->library('pagination');
        \$this->pagination->initialize(\$config);

        \$data = array(
            '" . $c_url . "_data' => \$$c_url,
            'q' => \$q,
            'pagination' => \$this->pagination->create_links(),
            'total_rows' => \$config['total_rows'],
            'start' => \$start,
        );
        \$this->response(\$data,200);
    }";
} else {

    $string .= "\n\n    public function index_get()
    {
        \$this->load->view('$c_url/$v_list');
    } 
    
    public function json_get() {
        header('Content-Type: application/json');
        echo \$this->" . $m . "->json();
    }";
}

$string .= "\n\n    public function read_get(\$id = null) 
    {
        \$row = \$this->" . $m . "->get_by_id(\$id);
        if (\$row) {
            \$data = array(";
foreach ($all as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => \$row->" . $row['column_name'] . ",";
}
$string .= "\n\t    );
            \$this->response([
                \$data,
            ],400);
        } else {
            \$this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('$c_url'));
        }
    }
    
    public function create_post()
    {
        \$this->_rules();

        if (\$this->form_validation->run() == FALSE) {
            \$this->response([
                'message'=>validation_errors(),
            ],400);
        } else {
            \$data = array(";
foreach ($non_pk as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => \$this->post('" . $row['column_name'] . "',TRUE),";
}
$string .= "\n\t    );

            \$cek = \$this->" . $m . "->insert(\$data);
            if(\$cek){
                \$this->response([
                    'message'=>'Data berhasil ditambahkan'
                ],200);
            }else{
                \$this->response([
                    'message'=>'Data gagal ditambahkan'
                ],400);
            }
        }
    }

    
    public function update_put(\$id = null) 
    {";

foreach ($non_pk as $row) {
    $string .= "\n\t\$data['" . $row['column_name'] . "'] = \$this->put('" . $row['column_name'] . "');";
}
$string .= "\n\n\t\$this->form_validation->set_data(\$data);

        \$this->_rules();

        if (\$this->form_validation->run() == FALSE) {
            \$this->response([
                'message'=>validation_errors(),
            ],400);
        } else {
            \$data = array(";
foreach ($non_pk as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => \$this->put('" . $row['column_name'] . "',TRUE),";
}
$string .= "\n\t    );

            // \$cek = \$this->" . $m . "->update(\$this->put('$pk', TRUE), \$data);
            \$cek = \$this->" . $m . "->update(\$id, \$data);
            if(\$cek){
                \$this->response([
                    'message'=>'Data berhasil diubah'
                ],200);
            }else{
                \$this->response([
                    'message'=>'Data gagal diubah'
                ],400);
            }
        }
    }
    
    public function delete_delete(\$id = null) 
    {
        \$row = \$this->" . $m . "->get_by_id(\$id);

        if (\$row) {
            \$this->" . $m . "->delete(\$id);
            \$this->response([
                'message'=>'Data berhasil dihapus'
            ],200);
        } else {
            \$this->response([
                'message'=>'Data tidak ditemukan'
            ],400);
        }
    }

    function _rules() 
    {";
foreach ($non_pk as $row) {
    $int = $row3['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? '|numeric' : '';
    $string .= "\n\t\$this->form_validation->set_rules('" . $row['column_name'] . "', '" .  strtolower(label($row['column_name'])) . "', 'trim|required$int');";
}
$string .= "\n\n\t//\$this->form_validation->set_rules('$pk', '$pk', 'trim');";
$string .= "\n\t\$this->form_validation->set_error_delimiters('<span class=\"text-danger\">', '</span>');
    }";

if ($export_excel == '1') {
    $string .= "\n\n    public function excel_get()
    {
        \$this->load->helper('exportexcel');
        \$namaFile = \"$table_name.xls\";
        \$judul = \"$table_name\";
        \$tablehead = 0;
        \$tablebody = 1;
        \$nourut = 1;
        //penulisan header
        header(\"Pragma: public\");
        header(\"Expires: 0\");
        header(\"Cache-Control: must-revalidate, post-check=0,pre-check=0\");
        header(\"Content-Type: application/force-download\");
        header(\"Content-Type: application/octet-stream\");
        header(\"Content-Type: application/download\");
        header(\"Content-Disposition: attachment;filename=\" . \$namaFile . \"\");
        header(\"Content-Transfer-Encoding: binary \");

        xlsBOF();

        \$kolomhead = 0;
        xlsWriteLabel(\$tablehead, \$kolomhead++, \"No\");";
    foreach ($non_pk as $row) {
        $column_name = label($row['column_name']);
        $string .= "\n\txlsWriteLabel(\$tablehead, \$kolomhead++, \"$column_name\");";
    }
    $string .= "\n\n\tforeach (\$this->" . $m . "->get_all() as \$data) {
            \$kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber(\$tablebody, \$kolombody++, \$nourut);";
    foreach ($non_pk as $row) {
        $column_name = $row['column_name'];
        $xlsWrite = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? 'xlsWriteNumber' : 'xlsWriteLabel';
        $string .= "\n\t    " . $xlsWrite . "(\$tablebody, \$kolombody++, \$data->$column_name);";
    }
    $string .= "\n\n\t    \$tablebody++;
            \$nourut++;
        }

        xlsEOF();
        exit();
    }";
}

if ($export_word == '1') {
    $string .= "\n\n    public function word_get()
    {
        header(\"Content-type: application/vnd.ms-word\");
        header(\"Content-Disposition: attachment;Filename=$table_name.doc\");

        \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
        );
        
        \$this->load->view('" . $c_url . "/" . $v_doc . "',\$data);
    }";
}

if ($export_pdf == '1') {
    $string .= "\n\n    function pdf_get()
    {
        \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
        );
        
        ini_set('memory_limit', '32M');
        \$html = \$this->load->view('" . $c_url . "/" . $v_pdf . "', \$data, true);
        \$this->load->library('pdf');
        \$pdf = \$this->pdf->load();
        \$pdf->WriteHTML(\$html);
        \$pdf->Output('" . $table_name . ".pdf', 'D'); 
    }";
}

$string .= "\n\n}\n\n/* End of file $c_file */
/* Location: ./application/controllers/$c_file */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator " . date('Y-m-d H:i:s') . " */
/* http://harviacode.com */";




$hasil_controller = createFile($string, $target . "controllers/" . $c_file);
