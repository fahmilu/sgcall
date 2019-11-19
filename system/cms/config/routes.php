<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']                = 'pages';
$route['404_override']                      = 'pages';

$route['admin/help/([a-zA-Z0-9_-]+)']       = 'admin/help/$1';
$route['admin/([a-zA-Z0-9_-]+)/(:any)']	    = '$1/admin/$2';
$route['admin/(login|logout|remove_installer_directory)']			    = 'admin/$1';
$route['admin/([a-zA-Z0-9_-]+)']            = '$1/admin/index';

$route['api/ajax/(:any)']          			= 'api/ajax/$1';
$route['api/([a-zA-Z0-9_-]+)/(:any)']	    = '$1/api/$2';
$route['api/([a-zA-Z0-9_-]+)']              = '$1/api/index';

$route['register']                          = 'users/register';
$route['login']                          	= 'users/login';
$route['logout']                          	= 'users/logout';
$route['profile']                          	= 'members/view';
$route['user/(:any)']	                    = 'users/view/$1';
$route['my-profile']	                    = 'users/index';
$route['edit-profile']	                    = 'users/edit';

$route['sitemap.xml']                       = 'sitemap/xml';


$route['product/changecolor'] = 'product/changecolor';
$route['product/detail/(:any)'] = 'product/detail/$1';
$route['produk/detail/(:any)'] = 'product/detail/$1';
$route['product/(:any)'] = 'product/category/$1';
$route['produk/(:any)'] = 'product/category/$1';

$route['galeri'] = 'registration/gallery';
$route['galeri/(:any)'] = 'registration/gallery/$1';

$route['cerita'] = 'blog';

$route['cerita/page(/:num)?']  = 'blog/index$1';
$route['cerita/(:any)']   = 'blog/view/$1';

// $route['produk(:any)?'] = 'product$1';


// $route['machine'] = 'product/category/1';
// $route['mesin'] = 'product/category/1';
// $route['capsule'] = 'product/category/2';
// $route['kapsul'] = 'product/category/2';
// $route['accessories'] = 'product/category/3';
// $route['aksesoris'] = 'product/category/3';


/* End of file routes.php */
