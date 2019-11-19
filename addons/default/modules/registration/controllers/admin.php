<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a address module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'entry';
	protected $max_width = 1440;
	protected $max_height = 700;
	/* thumb */
	protected $thumb_width = 400;
	protected $thumb_height = 400;

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('registration_m');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		// $this->load->helper('filename_helper');
		$this->lang->load('registration');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'name',
				'rules' => 'trim'
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => ''
			),
			array(
				'field' => 'subject',
				'label' => 'Subject',
				'rules' => ''
			),
			array(
				'field' => 'message',
				'label' => 'Message',
				'rules' => ''
			),
		);


		// We'll set the partials and metadata here since they're used everywhere
		$this->template
		->append_js('module::admin.js')
		->append_css('module::admin.css')
		->append_js('module::datatables.min.js')
		->append_css('module::datatables.min.css');
	}

	/**
	 * List all items
	 */
	public function index()
	{

		$items = $this->registration_m
			->order_by('created_at','desc')
			->get_all();
			
		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->build('admin/entry/items');
	}

	public function approved()
	{

		$items = $this->registration_m
			->where('status', 1)
			->order_by('created_at','desc')
			->get_all();
			
		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->set('active_section', 'approved')
			->build('admin/entry/items');
	}
	
	public function pending()
	{

		$items = $this->registration_m
			->where('status', 0)
			->order_by('created_at','desc')
			->get_all();
			
		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->set('active_section', 'pending')
			->build('admin/entry/items');
	}

	public function delete($id = 0)
	{

		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			$ids = $_POST['action_to'];
			foreach ($ids as $key => $value) {
				$this->registration_m->delete($value);
			}
		}
		elseif (is_numeric($id))
		{
			$this->registration_m->delete($id);
		}

		$this->session->set_flashdata('error', lang('alert-delete'));
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function approve($id = 0)
	{

		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			$ids = $_POST['action_to'];

			foreach ($ids as $key => $value) {
				$this->registration_m->approve($value);
			}
		}
		elseif (is_numeric($id))
		{
			$this->registration_m->approve($id);
		}

		$this->session->set_flashdata('success', lang('alert-updated'));
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function download()
	{

		$items = $this->registration_m
			->order_by('created_at','desc')
			->get_all();
			
		// $this->input->is_ajax_request() and $this->template->set_layout(false);
		$data['items'] = $items;
		$this->load->view('admin/excel', $data, FALSE);
	}

	public function action()
	{
		if($this->input->post('btnAction') == 'delete')
		{
			$this->delete();
		}elseif($this->input->post('btnAction') == 'approve'){
			$this->approve();
		}
	}

}
