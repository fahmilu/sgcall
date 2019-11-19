<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Events Plugin
 *
 * Create a list of events
 */
class Plugin_Banner extends Plugin
{

	public function __construct()
	{
        $this->load->model(array('banner_m', 'banner_categories_m'));
	}

	function display(){
        $cat_slug = $this->attribute('cat_slug');
        $class = $this->attribute('class');
        $category = $this->banner_categories_m->get_by('slug', $cat_slug);
        if($category){    	
	        $banner = $this->banner_m->order_by('position', 'asc')->where('banner.published', 'yes')->limit(1)->get_many_by('category_id', $category->id);
	        foreach ($banner as $ban) {
                $url = base_url(). UPLOAD_PATH .'banner/'.$ban->filename;
                if($ban->url){
                    $img = '<a href="'.$ban->url.'"><img data-src="'.$url.'" class="'.$class.' lazy" /></a>';
                }else{
                    $img = '<img data-src="'.$url.'" class="'.$class.' lazy" />';
                }

                $ban->url = $img;
	        }
        }else{
        	$url = '';
        }

        return $img;
    }

    function slideshow(){
        $cat_slug = $this->attribute('cat_slug');
        
        $category = $this->banner_categories_m->get_by('slug', $cat_slug);
        $banner = $this->banner_m->order_by('position', 'asc')->where('banner.published', 'yes')->get_many_by('category_id', $category->id);

        foreach ($banner as $ban) {

            $url = base_url(). UPLOAD_PATH .'banner/'.$ban->filename;
            if($ban->url){
                $img = '<a href="'.$ban->url.'" target="_blank"><img src="'.$url.'" class="img-fluid mx-auto" /></a>';
            }else{
                $img = '<img src="'.$url.'" class="img-fluid mx-auto" />';
            }

            $ban->display = $img;
        }

        // print_r($banner);

        // exit();
       
       return $banner;
   }
}

/* End of file plugin.php */
