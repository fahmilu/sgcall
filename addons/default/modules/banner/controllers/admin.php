<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	protected $section = 'banner';

	public $id = 0;

	public $_path 		= '';
	private $_type 		= NULL;
	private $_ext 		= NULL;
	private $_filename	= NULL;

	/**
	 * Validation rules for creating a new gallery
	 *
	 * @var array
	 * @access private
	 */
	private $validation_rules = array(
		array(
			'field' => 'userfile',
			'label' => 'lang:banner_upload_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'title',
			'label' => 'lang:banner_title_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'body',
			'label' => 'lang:banner_caption_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'curfile',
			'label' => 'curfile',
			'rules' => 'trim'
		),
		array(
			'field' => 'url',
			'label' => 'lang:banner_url_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'url_name',
			'label' => 'lang:banner_url_name',
			'rules' => 'trim'
		),
		array(
			'field' => 'credit',
			'label' => 'lang:banner_credit_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'description',
			'label' => 'lang:banner_description_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'category_id',
			'label' => 'lang:banner_category_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'published',
			'label'	=> 'lang:banner_published_label',
			'rules'	=> 'trim|required'
		)
	);

	// upload config
	public $upload_cfg = array();

	// thumbnail size for admin
	public $thumb_width = 150;
	public $thumb_height = 150;

	// preview size
	public $max_width = 910;
	public $max_height = 410;

	private $_file_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:files.name_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field' => 'mediatitle',
			'label' => 'lang:galeria.title_label',
			'rules' => 'trim|max_length[100]'
		),
		array(
			'field' => 'mediadescription',
			'label' => 'lang:galeria.description_label',
			'rules' => 'trim'
		),
	);


	/**
	 * Constructor method
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model(array('banner_m', 'banner_categories_m'));
		$this->load->library('form_validation');
		$this->lang->load('banner');
		$this->load->helper(array('html'));

		$this->upload_cfg['upload_path']		= UPLOAD_PATH . 'banner';
		$this->upload_cfg['allowed_types'] 		= 'jpg|gif|png|jpeg';
		$this->upload_cfg['max_size'] 			= '30000';
		$this->upload_cfg['remove_spaces'] 		= TRUE;
		$this->upload_cfg['overwrite']     		= FALSE;

		if ($this->settings->banner_height)
			$this->max_height = $this->settings->banner_height;

		if ($this->settings->banner_width)
			$this->max_width = $this->settings->banner_width;

		$this->_path = $this->upload_cfg['upload_path'].'/';
		$this->check_dir($this->_path);

		$no_category[''] = lang('banner_category_option');

		$categories = $this->banner_categories_m->category_options();

		$this->template->category_options = $no_category + $categories;
		$this->template->category_options_without_no = $categories;

		$this->template->publish_options = array(
			'yes' => lang('banner_published_yes'),
			'no' => lang('banner_published_no')
		);	
	}

	public function index($id=0)
	{
		if(isset($_SERVER['HTTP_REFERER'])){
			if(!preg_match("/banner/",$_SERVER['HTTP_REFERER'])){
				$this->session->unset_userdata('category');
			}
		}

		if ($this->session->userdata('category')) {
			$slides = $this->banner_m->get_all_by_category($this->session->userdata('category'));
			
		} else {
			$slides = $this->banner_m->get_all();
		}

		// $slides = $this->banner_m->get_all($id);
		// print_r($slides); die();
		$this->template
			->title($this->module_details['name'])
			->append_css('module::files.css')
			->append_css('module::jquery.fileupload-ui.css')
			->append_js('module::jquery.cooki.js')
			->append_js('module::jquery.fileupload.js')
			->append_js('module::jquery.fileupload-ui.js')
			->append_metadata( $this->load->view('fragments/wysiwyg', array(), TRUE) )
			->append_js('module::functions.js')
			->append_js('module::jquery.Jcrop.min.js')
			//->append_js('module::jcrop_init.js')
			->append_js('module::jquery.form.js')
			->set('max_width', $this->max_width)
			->set('max_height', $this->max_height)
			->set('slides', $slides)
			->build('admin/index');
	}

	/**
	 * Upload
	 *
	 * Upload a slide
	 *
	 */
	public function upload()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);

		$data = (object)array();

		//$this->_check_ext();

		if ($this->form_validation->run())
		{
			// Setup upload config
			$this->load->library('upload', $this->upload_cfg);

			// check directory exists
			$this->check_dir($this->upload_cfg['upload_path']);

			// File upload error
			if (!$this->upload->do_upload('top_image'))
			{
				$status		= 'error';
				$message	= $this->upload->display_errors();

				if ($this->input->is_ajax_request())
				{
					$data = array();
					$data['messages'][$status] = $message;
					$message = $this->load->view('admin/partials/notices', $data, TRUE);

					return $this->template->build_json(array(
						'status'	=> $status,
						'message'	=> $message
					));
				}

				$data->messages[$status] = $message;
			}

			// File upload success
			else
			{
				$file = $this->upload->data();
				$data = array(
					'category_id'		=> (int) $this->input->post('category_id'),
					'filename'		    => $file['file_name'],
					'published' => $this->input->post('published'),
                    'title'	            => $this->input->post('title'),
					'body'			    => $this->input->post('body'),
					'url'		    	=> $this->input->post('url'),
					'url_name'			=> $this->input->post('url_name'),
					'credit'		    => $this->input->post('credit'),
					'description'	    => $this->input->post('description'),
					'uploaded_by'	    => $this->current_user->id,
					'uploaded_on'	    => now(),
					'position'		    => 999
				);

				if ($file['is_image'])
				{
					$this->load->library('image_lib');
					$filename = $file['file_name'];
					$thumbfile = substr($filename, 0, -4) . '_thumb' . substr($filename, -4); //substr($filename, 0, -4) . '_thumb' . substr($filename, -4);
					/*---------------------------------------------------------------------------------
					// create thumb - admin
					*/
					$image_cfg['source_image'] = $file['full_path'];
					$image_cfg['maintain_ratio'] = TRUE;
					$image_cfg['width'] = ($file['image_width'] < $this->thumb_width ? $file['image_width'] : $this->thumb_width);
					$image_cfg['height'] = ($file['image_height'] < $this->thumb_height ? $file['image_height'] : $this->thumb_height);
					$image_cfg['create_thumb'] = FALSE;
					$image_cfg['new_image'] = $file['file_path'] . $thumbfile;
					$image_cfg['master_dim'] = 'width';
					$this->image_lib->initialize($image_cfg);
					ini_set('memory_limit', '-1');
					$img_ok = $this->image_lib->resize();
					unset($image_cfg);
					$this->image_lib->clear();
				}

				// Insert success
				if ($id = $this->banner_m->insertimg($data))
				{
					$status		= 'success';
					$message	= lang('banner_upload_img_success');
				}
				// Insert error
				else
				{
					$this->unlinkfile($file['file_name']);
					$status		= 'error';
					$message	= sprintf(lang('banner_dbstore_img_error'), $file['file_name']);
				}

				if ($this->input->is_ajax_request())
				{
					$data = array();
					$data['messages'][$status] = $message;
					$message = $this->load->view('admin/partials/notices', $data, TRUE);

					return $this->template->build_json(array(
						'status'	=> $status,
						'message'	=> $message,
						'file'		=> array(
							'name'	=> $file['file_name'],
							'type'	=> $file['file_type'],
							'size'	=> $file['file_size'],
							'thumb'	=> UPLOAD_PATH . 'banner/' . $thumbfile
						)
					));
				}
				else
				{
					$this->session->set_flashdata($status, $message);
					($this->input->post('btnAction') == 'save_exit') ? redirect('admin/banner') : redirect('admin/banner/edit/'.$id);
				}

				if ($status === 'success')
				{
					$this->session->set_flashdata($status, $message);
					($this->input->post('btnAction') == 'save_exit') ? redirect('admin/banner') : redirect('admin/banner/edit/'.$id);
				}
				else
				{
					if ($this->input->is_ajax_request())
					{
						$data = array();
						$data['messages'][$status] = $message;
						$message = $this->load->view('admin/partials/notices', $data, TRUE);

						return $this->template->build_json(array(
							'status'	=> 'error',
							'message'	=> $message
						));
					}
				}
			}
		}
		elseif (validation_errors())
		{
			// if request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$data = array();
				$status = 'error';
				$data['messages'][$status] = validation_errors();
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> 'error',
					'message'	=> $message
				));
			}
			else
			{
				$this->session->set_flashdata('error', validation_errors());
				redirect("admin/banner/upload");
			}
		}

			// Go through all the known fields and get the post values
			$slide = new stdClass;
			foreach ($this->validation_rules as $key => $field)
			{
				$slide->$field['field'] = set_value($field['field']);
			}


		if ($this->input->is_ajax_request())
		{
			// todo: debug errors here
			$status		= 'error';
			$message	= 'unknown';

			$data = array();
			$data['messages'][$status] = $message;
			$message = $this->load->view('admin/partials/notices', $data, TRUE);

			return $this->template->build_json(array(
				'status'	=> $status,
				'message'	=> $message
			));
		}

		$this->template
			->title()
			->set('slide', $slide)
            ->append_js('module::jscolor.js')
			->build('admin/upload', $data);
	}

	function edit($id=NULL)
	{
		if (!$id OR !$slide=$this->banner_m->get($id))
		{
			$this->session->set_flashdata('error', lang('banner_edit_no_id_error'));
			redirect('admin/banner');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);

		if ($this->form_validation->run())
		{
			// Setup upload config
			$this->load->library('upload', $this->upload_cfg);

			// check directory exists
			$this->check_dir($this->upload_cfg['upload_path']);

			$data = array(
				'category_id'		    => (int) $this->input->post('category_id'),
				'filename'		    => $this->input->post('curfile'),
				'title'			    => $this->input->post('title'),
				'published' => $this->input->post('published'),
				'body'			    => $this->input->post('body'),
				'url'			    => $this->input->post('url'),
                'url_name'		    => $this->input->post('url_name'),
				'credit'		    => $this->input->post('credit'),
				'description'	    => $this->input->post('description'),
				'updated_by'	    => $this->current_user->id,
				'updated_on'	    => now(),
			);

			if (!empty($_FILES['top_image']['name']) && !empty($_FILES['top_image']['tmp_name']))
			{
				// user uploaded new file
				// File upload error
				if ( ! $this->upload->do_upload('top_image'))
				{
					$status		= 'error';
					$message	= $this->upload->display_errors();
					$messages[$status] = $message;
				}
				else
				{
					$file = $this->upload->data();

					if ($file['is_image'])
					{
						$this->load->library('image_lib');
						$filename = $file['file_name'];
						$thumbfile = substr($filename, 0, -4) . '_thumb' . substr($filename, -4); //substr($filename, 0, -4) . '_thumb' . substr($filename, -4);
						$medfile = substr($filename, 0, -4) . '_full' . substr($filename, -4); //substr($filename, 0, -4) . '_full' . substr($filename, -4);
						/*---------------------------------------------------------------------------------
						// create thumb - admin
						*/
						$image_cfg['source_image'] = $file['full_path'];
						$image_cfg['maintain_ratio'] = TRUE;
						$image_cfg['width'] = ($file['image_width'] < $this->thumb_width ? $file['image_width'] : $this->thumb_width);
						$image_cfg['height'] = ($file['image_height'] < $this->thumb_height ? $file['image_height'] : $this->thumb_height);
						$image_cfg['create_thumb'] = FALSE;
						$image_cfg['master_dim'] = 'width';
						$image_cfg['new_image'] = $file['file_path'] . $thumbfile;
						$this->image_lib->initialize($image_cfg);
						$img_ok = $this->image_lib->resize();
						unset($image_cfg);
						$this->image_lib->clear();

						$data['filename'] = $file['file_name'];
						if ($filename <> $this->input->post('curfile'))
							$this->unlinkfile($this->input->post('curfile'));
					}
				}
			}

			// Insert success
			if ($this->banner_m->update($id, $data))
			{
				$status		= 'success';
				$message	= lang('banner_upload_img_success');
			}
			// Insert error
			else
			{
				$this->unlinkfile($file['file_name']);
				$this->unlinkfile($file['main_bg']);
				$status		= 'error';
				$message	= sprintf(lang('banner_dbstore_img_error'), $file['file_name']);
			}

			$this->session->set_flashdata($status, $message);
			($this->input->post('btnAction') == 'save_exit') ? redirect('admin/banner') : redirect('admin/banner/edit/'.$id);//redirect('admin/banner');

		}

		$this->template
			->title()
			->set('slide', $slide)
            ->append_js('module::jscolor.js')
			->build('admin/upload');
	}

	/**
	 * Get the images just uploaded.
	 *
	 * View file: views/admin/files/contents.php
	 *
	 * @param int ID of the product
	 * @return void
	 *
	 */
	public function getuploaded($id=0)
	{
		$data->files = $this->banner_m->get_all($id);
		$this->load->view('admin/files/contents', $data);
	}

	/**
	 * Create a thumbnail
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param string $mode The mode of image manipulation, either "resize" or "crop"
	 * @param string $source The image to use for creating the thumbnail
	 * @param string $destination The location of the new file
	 * @param array $options Optional array that may contain data such as the new width, height, etc
	 * @return bool
	 */
	public function resize($mode, $source, $destination, $options = array())
	{
		// Time to resize the image
		$image_conf['image_library'] 	= 'gd2';
		$image_conf['source_image']  	= $source;

		// Save a new image somewhere else?
		if ( !empty($destination) )
		{
			$image_conf['new_image']	= $destination;
		}

		$image_conf['thumb_marker']		= '_thumb';
		$image_conf['create_thumb']  	= TRUE;
		$image_conf['quality']			= '100';

		// Optional parameters set?
		if ( !empty($options) )
		{
			// Loop through each option and add it to the $image_conf array
			foreach ( $options as $key => $option )
			{
				$image_conf[$key] = $option;
			}
		}

		$this->image_lib->initialize($image_conf);

		if ( $mode == 'resize' )
		{
			return $this->image_lib->resize();
		}
		else if ( $mode == 'crop' )
		{
			return $this->image_lib->crop();
		}

		return FALSE;
	}

	public function delete($id=0)
	{
		$imgid = $this->input->post('imgid');

		if (!$imgid)
		{
			$status = 'error';
			$message = lang('banner_delete_no_id_error');
			$data = array();
			$data['messages'][$status] = $message;
			$message = $this->load->view('admin/partials/notices', $data, TRUE);

			return $this->template->build_json(array(
				'status'	=> $status,
				'message'	=> $message
			));
		}

		$slide = $this->banner_m->get($imgid);

		if ($this->banner_m->delete($imgid))
		{
			$delfile = $this->unlinkfile($slide->filename);
			$status = $delfile[0];
			$message = $delfile[1];
		}
		else
		{
			$status = 'error';
			$message = lang('banner_delete_error');
		}

		if ($this->input->is_ajax_request())
		{
			$data = array();
			$data['messages'][$status] = $message;
			$message = $this->load->view('admin/partials/notices', $data, TRUE);

			return $this->template->build_json(array(
				'status'	=> $status,
				'message'	=> $message
			));
		}

		$this->session->set_flashdata($status, $message);
		redirect('admin/banner');
	}

	public function unlinkfile($filename)
	{
			$fullfile = substr($filename, 0, -4) . '_full' . substr($filename, -4);
			$thumbfile = substr($filename, 0, -4) . '_thumb' . substr($filename, -4);

			$stat = array();
					// delete the files
					if (file_exists($this->_path .'/' . $fullfile))
					{
						if (!@unlink($this->_path .'/' . $fullfile))
						{
							$stat[] = 'error';
							$msg[] = sprintf(lang('banner_delete_img_error'), $fullfile);
						}
					}

					if (file_exists($this->_path . '/' . $thumbfile))
					{
						if (!@unlink($this->_path . '/' . $thumbfile))
						{
							$stat[] = 'error';
							$msg[] = sprintf(lang('banner_delete_img_error'), $thumbfile);
						}
					}

					if (file_exists($this->_path . '/' . $filename))
					{
						if (!@unlink($this->_path . '/' . $filename))
						{
							$stat[] = 'error';
							$msg[] = sprintf(lang('banner_delete_img_error'), $filename);
						}
					}

					if (in_array('error', $stat))
					{
						$status = 'error';
						$message = implode('<br />', $msg);
					}
					else
					{
						$status = 'success';
						$message = sprintf(lang('banner_delete_img_success'), $filename);
					}

		return (array($status, $message));
	}


	/**
	 *
	 * Re-order image positions
	 *
	 */
	public function imgorder()
	{
		$ids = explode(',', $this->input->post('order'));
		$i = 1;
		foreach ($ids as $id)
		{
			$this->banner_m->updateimg($id, array(
				'position' => $i
			));
			++$i;
		}
	}

	/**
	 * Check attachment dir, and create accordingly
	 *
	 * @param string Directory to check
	 * @return array
	 */
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

	// ------------------------------------------------------------------------

	/**
	 * Validate upload file name and extension and remove special characters.
	 */
	function _check_ext()
	{
		if ( ! empty($_FILES['userfile']['name']))
		{
			$ext		= pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$allowed	= array('jpg', 'gif', 'png');

			foreach ($allowed as $ext_arr)
			{
				if (in_array(strtolower($ext), $ext_arr))
				{
					$this->_type		= $type;
					$this->_ext			= implode('|', $ext_arr);
					$this->_filename	= trim(url_title($_FILES['userfile']['name'], 'dash', TRUE), '-');

					break;
				}
			}

			if ( ! $this->_ext)
			{
				$this->form_validation->set_message('_check_ext', lang('banner_invalid_extension'));
				return FALSE;
			}
		}
		elseif ($this->method === 'upload')
		{
			#if ($this->input->post('ctd_id'))
			#	return TRUE;
//echo "returning false! ".lang('banner_upload_error')."<br />";
			$this->form_validation->set_message('_check_ext', lang('banner_upload_error'));
			return FALSE;
		}

		return TRUE;
	}

    function filterbycategory(){
    	if($this->input->post('category') != 0){
    		$this->session->set_userdata('category', $this->input->post('category'));
    	}else{
    		$this->session->unset_userdata('category');
    	}

    	redirect('admin/banner','refresh');
    }

}
// end of class