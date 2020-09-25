<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_sampah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_sampah_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'jenis_sampah/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'jenis_sampah/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'jenis_sampah/index.html';
            $config['first_url'] = base_url() . 'jenis_sampah/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Jenis_sampah_model->total_rows($q);
        $jenis_sampah = $this->Jenis_sampah_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jenis_sampah_data' => $jenis_sampah,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('jenis_sampah/jenis_sampah_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Jenis_sampah_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_jenis_sampah' => $row->id_jenis_sampah,
		'id_kategori' => $row->id_kategori,
		'nama_sampah' => $row->nama_sampah,
		'satuan' => $row->satuan,
		'keterangan' => $row->keterangan,
		'foto_sampah' => $row->foto_sampah,
		'active' => $row->active,
		'remove' => $row->remove,
		'created_at' => $row->created_at,
		'updated_at' => $row->updated_at,
	    );
            $this->load->view('jenis_sampah/jenis_sampah_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_sampah'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_sampah/create_action'),
	    'id_jenis_sampah' => set_value('id_jenis_sampah'),
	    'id_kategori' => set_value('id_kategori'),
	    'nama_sampah' => set_value('nama_sampah'),
	    'satuan' => set_value('satuan'),
	    'keterangan' => set_value('keterangan'),
	    'foto_sampah' => set_value('foto_sampah'),
	    'active' => set_value('active'),
	    'remove' => set_value('remove'),
	    'created_at' => set_value('created_at'),
	    'updated_at' => set_value('updated_at'),
	);
        $this->load->view('jenis_sampah/jenis_sampah_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		'nama_sampah' => $this->input->post('nama_sampah',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'foto_sampah' => $this->input->post('foto_sampah',TRUE),
		'active' => $this->input->post('active',TRUE),
		'remove' => $this->input->post('remove',TRUE),
		'created_at' => $this->input->post('created_at',TRUE),
		'updated_at' => $this->input->post('updated_at',TRUE),
	    );

            $this->Jenis_sampah_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('jenis_sampah'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_sampah_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jenis_sampah/update_action'),
		'id_jenis_sampah' => set_value('id_jenis_sampah', $row->id_jenis_sampah),
		'id_kategori' => set_value('id_kategori', $row->id_kategori),
		'nama_sampah' => set_value('nama_sampah', $row->nama_sampah),
		'satuan' => set_value('satuan', $row->satuan),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'foto_sampah' => set_value('foto_sampah', $row->foto_sampah),
		'active' => set_value('active', $row->active),
		'remove' => set_value('remove', $row->remove),
		'created_at' => set_value('created_at', $row->created_at),
		'updated_at' => set_value('updated_at', $row->updated_at),
	    );
            $this->load->view('jenis_sampah/jenis_sampah_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_sampah'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jenis_sampah', TRUE));
        } else {
            $data = array(
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		'nama_sampah' => $this->input->post('nama_sampah',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'foto_sampah' => $this->input->post('foto_sampah',TRUE),
		'active' => $this->input->post('active',TRUE),
		'remove' => $this->input->post('remove',TRUE),
		'created_at' => $this->input->post('created_at',TRUE),
		'updated_at' => $this->input->post('updated_at',TRUE),
	    );

            $this->Jenis_sampah_model->update($this->input->post('id_jenis_sampah', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_sampah'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_sampah_model->get_by_id($id);

        if ($row) {
            $this->Jenis_sampah_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_sampah'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_sampah'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_kategori', 'id kategori', 'trim|required');
	$this->form_validation->set_rules('nama_sampah', 'nama sampah', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('foto_sampah', 'foto sampah', 'trim|required');
	$this->form_validation->set_rules('active', 'active', 'trim|required');
	$this->form_validation->set_rules('remove', 'remove', 'trim|required');
	$this->form_validation->set_rules('created_at', 'created at', 'trim|required');
	$this->form_validation->set_rules('updated_at', 'updated at', 'trim|required');

	$this->form_validation->set_rules('id_jenis_sampah', 'id_jenis_sampah', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Jenis_sampah.php */
/* Location: ./application/controllers/Jenis_sampah.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-09-25 09:20:26 */
/* http://harviacode.com */