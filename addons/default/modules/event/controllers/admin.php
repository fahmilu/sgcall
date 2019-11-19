<?php

defined('BASEPATH') or exit('No direct script access.');

final class Admin extends Admin_Controller {

	protected $section = 'list';

    protected $upload_cfg = array(
        'max_size'          => '10000',
        'remove_spaces'     => TRUE,
        'overwrite'         => FALSE,
        'encrypt_name'      => FALSE,
    );

    private $write_rules = array(
        array(
            'field' => 'title',
            'label' => 'lang:lbl_title',
            'rules' => 'strip_tags|trim|required|max_length[100]'
        ),
        array(
            'field' => 'photo',
            'label' => 'lang:lbl_photo',
            'rules' => 'trim'
        ),
        array(
            'field' => 'location',
            'label' => 'lang:lbl_location',
            'rules' => 'required'
        ),
        array(
            'field' => 'date',
            'label' => 'lang:lbl_date',
            'rules' => 'required'
        ),
        array(
            'field' => 'dateend',
            'label' => 'lang:lbl_dateend',
            'rules' => 'required'
        ),
        array(
            'field' => 'time',
            'label' => 'lang:lbl_time',
            'rules' => 'required'
        ),
        array(
            'field' => 'tags',
            'tags' => 'lang:lbl_tags',
            'rules' => 'trim'
        ),
        array(
            'field' => 'status',
            'label' => 'lang:lbl_status',
            'rules' => 'numeric|required'
        ),
        array(
            'field' => 'description',
            'label' => 'lang:lbl_description',
            'rules' => 'required|max_length[250]'
        ),
        array(
            'field' => 'link',
            'label' => 'lang:lbl_link',
            'rules' => 'required|strip_tags'
        )
    );

    public function __construct() {
        parent::__construct();

        $this->load->language('event');
        $this->load->model('event_m');
        $this->load->model('event_tags_m');
        $this->load->library('user_agent');
    }

    /**
     * Show active event 
     */
    public function index() {
        $this->db->start_cache();
        // $this->event_m->where('status', true);
        $this->db->stop_cache();

        $total = $this->event_m->count_by(array());
        $pagination = create_pagination('admin/event/index', $total);

        $event = $this->event_m
            ->order_by('created_on', 'DESC')
            ->limit($pagination['limit'],  $pagination['offset'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('event'))
            ->set('event', $event)
            ->set('pagination', $pagination)
            ->build('admin/index');
    }

    public function create() {
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
        // hero image processing
        $hero_filename = '';
        if (!empty($_FILES['photo']['name'])){
            // Setup upload config
            $config = $this->upload_cfg;
            $config['upload_path'] = UPLOAD_PATH . 'event/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            // $config['max_size']  = '100';
            $this->upload->initialize($config);

            // check directory exists
            $this->check_dir($config['upload_path']);

            if ($this->upload->do_upload('photo')){
                $file = $this->upload->data();
                $hero_filename = $file['file_name'];
            }else{
                $messages['error'] = $this->upload->display_errors();
            }
        }else{
            $this->form_validation->set_rules('photo', 'Photo', 'required');
        }

        if ($this->form_validation->run() && $hero_filename != '') {
            $data = array(
            	'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'tags' => strtolower($this->input->post('tags')),
            	'link' => $this->input->post('link'),
                'location' => $this->input->post('location'),
                'date' => strtotime($this->input->post('date')),
                'dateend' => strtotime($this->input->post('dateend')),
                'time' => $this->input->post('time'),
                'month' => date('m', strtotime($this->input->post('date'))),
                'year' => date('Y', strtotime($this->input->post('date'))),
            	'status' => $this->input->post('status'),
                'created_on' => now(),
            );

            // print_r($data);
            // exit();
            if ($hero_filename)
                $data['photo'] = $hero_filename;
            elseif ($this->input->post('curimg'))
                $data['photo'] = $this->input->post('curimg');

            $created = $this->event_m->insert($data);
            $insert_tag = $this->event_tags_m->insertTag(strtolower($this->input->post('tags')));
            if ($created) {
            	if ($this->input->post('status') == 'live')
	                $this->session->set_flashdata('success', lang('msg_event_created'));
	            else
	                $this->session->set_flashdata('success', lang('msg_event_created_pending'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_event_uncreated'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/event') : redirect('admin/event/edit/' . $created);
        }

        $data = new StdClass();
		foreach($this->write_rules as $field)
		{
			//if (isset($_POST[$field['field']]))
			$data->$field['field'] = set_value($field['field']);
		}

        $tags = $this->event_tags_m->get_all();

        $tags_array = '[';

        foreach ($tags as $tag) {
            $tags_array .= "'".ucwords($tag->tag)."', ";
        }
        $tags_array .= ']';

        // echo $tags_array;
        // exit();
        // print_r($tags_array);

        // exit();

		$this->template
			->title(lang('lbl_write'))
            ->set('data', $data)
            ->set('tags', $tags_array)
			->set('messages', $messages)
			->build('admin/form');
    }

    function create_tags(){
        return $this->event_m->createTag();
    }

    public function edit($id) {
        empty($id) AND redirect('admin/event');
        
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
		$data = $this->event_m->get($id);

        $hero_filename = '';

        if (!empty($_FILES['photo']['name'])){
            // Setup upload config
            $config = $this->upload_cfg;
            $config['upload_path'] = UPLOAD_PATH . 'event/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            // $config['max_size']  = '100';
            $this->upload->initialize($config);

            // check directory exists
            $this->check_dir($config['upload_path']);

            if ($this->upload->do_upload('photo')){
                $file = $this->upload->data();
                $hero_filename = $file['file_name'];
                unlink( UPLOAD_PATH . 'event/'.$this->input->post('curimg'));
            }else{
                $messages['error'] = $this->upload->display_errors();
            }
        }else{
            $hero_filename = $this->input->post('curimg');
        }


        if ($this->form_validation->run() && $hero_filename != '') {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'tags' => strtolower($this->input->post('tags')),
                'link' => $this->input->post('link'),
                'location' => $this->input->post('location'),
                'date' => strtotime($this->input->post('date')),
                'dateend' => strtotime($this->input->post('dateend')),
                'time' => $this->input->post('time'),
                'month' => date('m', strtotime($this->input->post('date'))),
                'year' => date('Y', strtotime($this->input->post('date'))),
                'status' => $this->input->post('status'),
            );

            if ($hero_filename)
                $data['photo'] = $hero_filename;
            elseif ($this->input->post('curimg'))
                $data['photo'] = $this->input->post('curimg');

            $created = $this->event_m->update($id, $data);

            $insert_tag = $this->event_tags_m->insertTag(strtolower($this->input->post('tags')));

            if ($created) {
                $this->session->set_flashdata('success', lang('msg_event_created'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_event_uncreated'));
            }
            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/event') : redirect('admin/event/edit/' . $id);
        }

		foreach($this->write_rules as $field)
		{
			if (isset($_POST[$field['field']]))
				$data->$field['field'] = set_value($field['field']);
		}

        // print_r($data);

        // foreach ($data as $dt) {
            // print_r($dt);
            if($data->date){
                $data->date = date('M d, Y', $data->date);
            }

            if($data->dateend){
                $data->dateend = date('M d, Y', $data->dateend);
            }

            $tags = $this->event_tags_m->get_all();

            $tags_array = '[';

            foreach ($tags as $tag) {
                $tags_array .= "'".ucwords($tag->tag)."', ";
            }
            $tags_array .= ']';
        // }

		$this->template
			->title(lang('lbl_write'))
            ->set('data', $data)
            ->set('tags', $tags_array)
			->set('messages', $messages)
			->build('admin/form');
    }


    /**
     * Show pending event 
     */
    public function pending() {
        $this->db->start_cache();
        $this->event_m->where('status', false);
        $this->db->stop_cache();

        $total = $this->event_m->count_by(array());
        $pagination = create_pagination('admin/event/pending', $total);

        $event = $this->event_m->where('status', false)
            ->order_by('created_on', 'DESC')
            ->limit($pagination['limit'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('lbl_pending'))
            ->set('event', $event)
            ->set('pagination', $pagination)
            ->build('admin/pending');
    }

    /**
     * Approve pending event
     * @param int $id 
     */
    public function approve($id = '') {
        empty($id) AND redirect('admin/event');
        $approved = $this->event_m->update($id, array('status' => true));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_event_approved'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Un-approve approved event
     * @param int $id 
     */
    public function unapprove($id = '') {
        empty($id) AND redirect('admin/event');
        $approved = $this->event_m->update($id, array('status' => false));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_event_unapproved'));
        }
        redirect($this->agent->referrer());
    }

    public function delete($id = '') {
        empty($id) AND redirect('admin/event');

        $data = $this->event_m->get($id);
        if(is_file(UPLOAD_PATH . 'event/'.$data->photo)){
            unlink(UPLOAD_PATH . 'event/'.$data->photo);
        }
        
        $deleted = $this->event_m->delete($id);
        if ($deleted) {
            $this->session->set_flashdata('success', lang('msg_event_deleted'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Preview event message to modal
     * @param int $id 
     */
    public function preview($id = '') {
        $this->template->set('event', $this->event_m->get($id))
            ->set_layout('modal', 'admin')
            ->build('admin/preview');
    }

    /**
     * Multiple delete, approve and un-approve event
     */
    public function actions() {
        $button = $_POST['btnAction'];
        $action_to = $_POST['action_to'];
        switch ($button) {

            case 'delete' :
                // multiple delete if not empty
                if (!empty($_POST['action_to'])) {
                    $deleted[] = array();
                    foreach ($_POST['action_to'] as $id) {
                        $deleted[] = $this->event_m->delete($id);
                    }
                }

                if (!empty($deleted) AND !in_array(false, $deleted)) {
                    $this->session->set_flashdata('success', lang('msg_event_deleted'));
                }
                break;

            case 'approve' :
                if (!empty($action_to)) {
                    $approved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->event_m->update($id, array('status' => true));
                    }
                }

                if (!empty($approved) AND !in_array(false, $approved)) {
                    $this->session->set_flashdata('success', lang('msg_event_approved'));
                }
                break;

            case 'unapprove' :
                if (!empty($action_to)) {
                    $unapproved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->event_m->update($id, array('status' => false));
                    }
                }

                if (!empty($unapproved) AND !in_array(false, $unapproved)) {
                    $this->session->set_flashdata('success', lang('msg_event_unapproved'));
                }
                break;
        }

        // redirect to previous page
        redirect($this->agent->referrer());
    }

    function check_dir($dir)
    {
        // check directory
        $fileOK = array();
        $fdir = explode('/', $dir);
        $ddir = '';
        for($i=0; $i<count($fdir); $i++)
        {
            $ddir .= $fdir[$i] . '/';
            if (!is_dir($ddir))
            {
                if (!@mkdir($ddir, 0777)) {
                    $fileOK[] = 'not_ok';
                }
                else
                {
                    $fileOK[] = 'ok';
                }
            }
            else
            {
                $fileOK[] = 'ok';
            }
        }
        return $fileOK;

    }

    public function tags()
    {
        $tags = $this->event_tags_m->get_all();
        $this->template->title(lang('event_tag_index_title'))
            ->set('active_section', lang('event_tag_index_title'))
            ->set('tags', $tags)
            ->build('admin/tags/index');
    }


    public function delete_tag($id = '') {
        empty($id) AND redirect('admin/event/tags');
        $tag = $this->db->where('id', $id)->get('event_tags')->row();
        
        $deleted = $this->event_tags_m->delete($id);

        if ($deleted) {    
            // echo $tag->tag;
            // exit(); 
            $event = $this->db->like('tags', $tag->tag, 'BOTH')->get('event');

            // print_r($event->result());

            // exit();
            
            foreach ($event->result() as $e) {
                $tags = explode(',', $e->tags);

                foreach (array_keys($tags, $tag->tag) as $key) {
                    unset($tags[$key]);
                }

                $this->db->where('id', $e->id);
                $this->db->update('event', array('tags' => implode(',', $tags)));
            }

            $this->session->set_flashdata('success', 'Tag is deleted');
        }
        redirect($this->agent->referrer());
    }
}

/* EOF admin.php */