<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Pages Plugin
 *
 * Create links and whatnot.
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages\Plugins
 */
class Plugin_Pages extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Pages',
		'br' => 'Páginas',
            'fa' => 'صفحه ها',
	);
	public $description = array(
		'en' => 'Output page data or build a list of pages in a page tree.',
		'br' => 'Exibe informações da página ou monta uma lista de páginas em formato de árvore.',
            'fa'=> 'محتویات صفحه را نشان دهید و یا ساختار درختی صفحات را نمایش دهید'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'url' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Outputs the page url.',
					'br' => 'Exibe a URL da página.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end url method
			'display' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output the data of any live page.',
					'br' => 'Exibe os dados de qualquer página pública.'
				),
				'single' => true,
				'double' => true,
				'variables' => 'title|slug|uri|parent_id|type_id|entry_id|css|js|meta_title|meta_keywords|meta_description|rss_enabled|comments_enabled|status|created_on|updated_on|restricted_to|is_home|strict_uri|page_type_slug|page_type_title|custom_fields }}{{ field }}{{ /custom_fields',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'slug' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
				),
			),// end display method
			'children' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Show the children of any page.',
					'br' => 'Mostra os filhos de qualquer página.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'title|slug|uri|parent_id|type_id|entry_id|css|js|meta_title|meta_keywords|meta_description|rss_enabled|comments_enabled|status|created_on|updated_on|restricted_to|is_home|strict_uri|page_type_slug|page_type_title|custom_fields }}{{ field }}{{ /custom_fields',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'slug' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'order-by' => array(
						'type' => 'flag',
						'flags' => 'title|slug|uri|parent_id|status|created_on|updated_on|order|page_type_slug|page_type_title',
						'default' => 'order',
						'required' => false,
					),
					'order-dir' => array(
						'type' => 'flag',
						'flags' => 'asc|desc|random',
						'default' => 'asc',
						'required' => false,
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'offset' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '0',
						'required' => false,
					),
					'include-types' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
				),
			),// end children method
			'page_tree' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Create a tree of a page\'s children specified by the ID or URI.',
					'br' => 'Cria uma árvore de páginas-filhas especificadas pelo ID ou pela URI.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'start-id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'start' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'disable-levels' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'order-by' => array(
						'type' => 'flag',
						'flags' => 'title|slug|uri|parent_id|status|created_on|updated_on|order|page_type_slug|page_type_title',
						'default' => 'order',
						'required' => false,
					),
					'order-dir' => array(
						'type' => 'flag',
						'flags' => 'asc|desc|random',
						'default' => 'asc',
						'required' => false,
					),
					'list-tag' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'ul',
						'required' => false,
					),
					'link' => array(
						'type' => 'flag',
						'flags' => 'Y|N',
						'default' => 'Y',
						'required' => false,
					),
				),
			),// end page_tree method
			'is' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Check the relationship of a page to another by passing the IDs to check. [children] can take multiple IDs separated with |',
					'br' => 'Checa o relacionamento de uma página com outra, passando os IDs a checar. [children] pode receber múltiplos IDs separados com |'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'children' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'child' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'descendent' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'parent' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
				),
			),// end is method
			'has' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Check if a page has a child with the specified ID',
					'br' => 'Checa se uma página tem um filho com o ID informado.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end has method
		);
	
		return $info;
	}

	/**
	 * Get the URL of a page
	 *
	 * Attributes:
	 *  - (int) id : The id of the page to get the URL for.
	 *
	 * @return string
	 */
	public function url()
	{
		$id   = $this->attribute('id');
		$page = $this->pyrocache->model('page_m', 'get', array($id, false));

		return site_url($page ? $page->uri : '');
	}

	/**
	 * Get a page by ID or slug
	 *
	 * Attributes:
	 * - (int) id: The id of the page.
	 * - (string) slug: The slug of the page.
	 *
	 * @return array
	 */
	public function display()
	{
		$page = new stdClass();
/*
		$page = $this->db->select('pages.*, page_types.stream_id, page_types.slug as page_type_slug, page_types.title as page_type_title')
			->where('pages.id', $this->attribute('id'))
			->or_where('pages.slug', $this->attribute('slug'))
			->where('status', 'live')
			->join('page_types', 'page_types.id = pages.type_id', 'left')
			->get('pages')
			->row();
*/
		if ($this->attribute('id'))
			$page = $this->page_m->get($this->attribute('id'));
		elseif ($this->attribute('slug'))
			$page = $this->page_m->get_by('slug', $this->attribute('slug'));

		$page->body = '';

		// Legacy support for chunks
		if ($this->db->table_exists('page_chunks'))
		{
			// Grab all the chunks that make up the body
			$page->chunks = $this->db->get_where('page_chunks', array('page_id' => $page->id))->result();
    		
			if ($page->chunks)
			{
    				foreach ($page->chunks as $chunk)
				{
					$page->body .= '<div class="page-chunk '.$chunk->slug.'">' .
					(($chunk->type == 'markdown') ? $chunk->parsed : $chunk->body) .
					'</div>' . PHP_EOL;
				}
			}
    
			// we'll unset the chunks array as Lex is grouchy about mixed data at the moment
			unset($page->chunks);
		}

		// Check for custom fields
		if (is_scalar($this->content()) and strpos($this->content(), 'custom_fields') !== false and $page)
		{
			$custom_fields = array();
			$this->load->driver('Streams');

			$stream = $this->streams_m->get_stream($page->stream_id);

			$params = array(
				'stream'		=> $stream->stream_slug,
				'namespace'		=> $stream->stream_namespace,
				'include'		=> $page->entry_id,
				'disable'		=> 'created_by'
			);

			$entries = $this->streams->entries->get_entries($params);

			foreach ($entries['entries'] as $entry)
			{
				$custom_fields[$page->stream_id][$entry['id']] = $entry;
			}
		} else {
			$custom_fields = false;
		}

		// If we have custom fields, we need to roll our
		// entry values in.
		if ($custom_fields and isset($custom_fields[$page->stream_id][$page->entry_id]))
		{
			$page->custom_fields = array($custom_fields[$page->stream_id][$page->entry_id]);
		}
/*
echo "<pre>\n";
echo 'AUTO_LANGUAGE: '.AUTO_LANGUAGE.PHP_EOL;
print_r($page);
echo "</pre>\n";
*/
		return $this->content() ? array($page) : $page->body;
	}

	/**
	 * Get a page chunk by page ID and chunk name
	 *
	 * Attributes:
	 * - (int) id : The id of the page.
	 * - (string) name : The name of the chunk.
	 * - (string) parse_tags : yes/no - whether or not to parse tags within the chunk
	 *
	 * @return string|bool
	 */
	public function chunk()
	{
		$parse_tags = str_to_bool($this->attribute('parse_tags', true));

		$chunk = $this->db
			->where('page_id', $this->attribute('id'))
			->where('slug', $this->attribute('name'))
			->get('page_chunks')
			->row_array();

		if ($chunk)
		{
			if ($this->content())
			{
				$chunk['parsed'] = $this->parse_chunk($chunk['parsed'], $parse_tags);
				$chunk['body']   = $this->parse_chunk($chunk['body'], $parse_tags);

				return $chunk;
			}
			else
			{
				return $this->parse_chunk(($chunk['type'] == 'markdown') ? $chunk['parsed'] : $chunk['body'], $parse_tags);
			}
		}
	}

	/**
	 * Parse chunk content
	 *
	 * @access private
	 * @param string the chunk content
	 * @param string parse Lex tags? - yes/no
	 * @return string
	 */
	private function parse_chunk($content, $parse_tags)
	{
		// Lex tags are parsed by default. If you want to
		// turn off parsing Lex tags, just set parse_tags to 'no'
		if (str_to_bool($parse_tags))
		{
			$parser = new Lex_Parser();
			$parser->scope_glue(':');

			return $parser->parse($content, array(), array($this->parser, 'parser_callback'));
		}
		else
		{
			return $content;
		}
	}

	/**
	 * Children list
	 *
	 * Creates a list of child pages one level under the parent page.
	 *
	 * Attributes:
	 * - (int) limit: How many pages to show.
	 * - (string) order-by: One of the column names from the `pages` table.
	 * - (string) order-dir: Either `asc` or `desc`
	 *
	 * Usage:
	 * {{ pages:children id="1" limit="5" }}
	 *  <h2>{{title}}</h2>
	 *      {{body}}
	 * {{ /pages:children }}
	 *
	 * @return array
	 */
	public function children()
	{
		$limit			= $this->attribute('limit', null);
		$offset			= $this->attribute('offset');
		$order_by 		= $this->attribute('order-by', 'order');
		$order_dir 		= $this->attribute('order-dir', 'ASC');
		$page_types 	= $this->attribute('include-types', $this->attribute('include_types'));

		// Restrict page types.
		// Page types can be provided in a pipe (|) delimited string.
		// Ex: 4|6
		if ($page_types)
		{
			$types = explode('|', $page_types);

			foreach ($types as $type)
			{
				$this->db->where('pages.type_id', $type);
			}
		}

		$pages = $this->db->select('pages.*, page_types.stream_id, page_types.slug as page_type_slug, page_types.title as page_type_title')
			->where('pages.parent_id', $this->attribute('id'))
			->where('status', 'live')
			->join('page_types', 'page_types.id = pages.type_id', 'left')
			->order_by($order_by, $order_dir)
			->limit($limit)
			->offset($offset)
			->get('pages')
			->result_array();

		// Custom fields provision.
		// Since page children can have many different page types,
		// we are going to do this in the most economical way possible:
		// Find the entries by ID and attach them to a special custom_fields
		// variable.
		if (is_scalar($this->content()) and strpos($this->content(), 'custom_fields') !== false and $pages)
		{
			$custom_fields = array();
			$this->load->driver('Streams');
		
			// Get all of the IDs by page type id.
			// Ex: array('page_type_id' => array('1', '2'))
			$entries = array();
			foreach ($pages as $page)
			{
				$entries[$page['stream_id']][] = $page['entry_id'];
			}

			// Get our entries by steram
			foreach ($entries as $stream_id => $entry_ids)
			{
				$stream = $this->streams_m->get_stream($stream_id);

				$params = array(
					'stream'		=> $stream->stream_slug,
					'namespace'		=> $stream->stream_namespace,
					'include'		=> implode('|', $entry_ids),
					'disable'		=> 'created_by'
				);

				$entries = $this->streams->entries->get_entries($params);

				// Set the entries in our custom fields array for
				// easy reference later when processing our pages.
				foreach ($entries['entries'] as $entry)
				{
					$custom_fields[$stream_id][$entry['id']] = $entry;	
				}
			}
		}
		else
		{
			$custom_fields = false;
		}

		// Legacy support for chunks
		if ($pages and $this->db->table_exists('page_chunks'))
		{
			foreach ($pages as &$page)
			{
				// Grab all the chunks that make up the body for this page
				$page['chunks'] = $this->db
					->get_where('page_chunks', array('page_id' => $page['id']))
					->result_array();

				$page['body'] = '';
				if ($page['chunks'])
				{
					foreach ($page['chunks'] as $chunk)
					{
						$page['body'] .= '<div class="page-chunk ' . $chunk['slug'] . '">' .
							(($chunk['type'] == 'markdown') ? $chunk['parsed'] : $chunk['body']) .
							'</div>' . PHP_EOL;
					}
				}
			}
		}

		// Process our pages.
		foreach ($pages as &$page)
		{
			// First, let's get a full URL. This is just
			// handy to have around.
			$page['url'] = site_url($page['uri']);
		
			// Now let's process our keywords hash.
			$keywords = Keywords::get($page['meta_keywords']);

			// In order to properly display the keywords in Lex
			// tags, we need to format them.
			$formatted_keywords = array();
			
			foreach ($keywords as $key)
			{
				$formatted_keywords[] 	= array('keyword' => $key->name);

			}
			$page['meta_keywords'] = $formatted_keywords;

			// If we have custom fields, we need to roll our
			// entry values in.
			if ($custom_fields and isset($custom_fields[$page['stream_id']][$page['entry_id']]))
			{
				$page['custom_fields'] = array($custom_fields[$page['stream_id']][$page['entry_id']]);
			}
		}

		//return '<pre>'.print_r($pages, true).'</pre>';

		return $pages;
	}

	/**
	 * Page tree function
	 *
	 * Creates a nested ul of child pages
	 *
	 * Usage:
	 * {{ pages:page_tree start-id="5" }}
	 * optional attributes:
	 *
	 * disable-levels="slug"
	 * order-by="title"
	 * order-dir="desc"
	 * list-tag="ul"
	 * link="true"
	 *
	 * @param  array
	 * @return  array
	 */
	public function page_tree()
	{
		$start          = $this->attribute('start');
		$start_id       = $this->attribute('start-id', $this->attribute('start_id'));
		$disable_levels = $this->attribute('disable-levels');
		$order_by       = $this->attribute('order-by', 'order');
		$order_dir      = $this->attribute('order-dir', 'ASC');
		$list_tag       = $this->attribute('list-tag', 'ul');
		$link           = $this->attribute('link', true);

		// If we have a start URI, let's try and
		// find that ID.
		if ($start)
		{
			$page = $this->page_m->get_by_uri($start);

			if ( ! $page) {
				return null;
			}

			$start_id = $page->id;
		}

		// If our start doesn't exist, then
		// what are we going to do? Nothing.
		if ( ! $start_id) {
			return null;
		}

		// Disable individual pages or parent pages by submitting their slug
		$this->disable = explode("|", $disable_levels);

		return '<' . $list_tag . '>' . $this->_build_tree_html(array(
			'parent_id' => $start_id,
			'order_by'  => $order_by,
			'order_dir' => $order_dir,
			'list_tag'  => $list_tag,
			'link'      => $link
		)) . '</' . $list_tag . '>';
	}

	/**
	 * Page is function
	 *
	 * Check the pages parent or descendent relation
	 *
	 * Usage:
	 * {{ pages:is child="7" parent="cookbook" }} // return 1 (true)
	 * {{ pages:is child="recipes" descendent="books" }} // return 1 (true)
	 * {{ pages:is children="7,8,literature" parent="6" }} // return 0 (false)
	 * {{ pages:is children="recipes,ingredients,9" descendent="4" }} // return 1 (true)
	 *
	 * Use Id or Slug as param, following usage data reference
	 * Id: 4 = Slug: books
	 * Id: 6 = Slug: cookbook
	 * Id: 7 = Slug: recipes
	 * Id: 8 = Slug: ingredients
	 * Id: 9 = Slug: literature
	 *
	 * @param  array Plugin attributes
	 * @return int   0 or 1
	 */
	public function is()
	{
		$children_ids = $this->attribute('children');
		$child_id     = $this->attribute('child');

		if ( ! $children_ids)
		{
			return (int) $this->_check_page_is($child_id);
		}

		$children_ids = explode('|', str_replace(',', '|', $children_ids));
		$children_ids = array_map('trim', $children_ids);

		if ($child_id)
		{
			$children_ids[] = $child_id;
		}

		foreach ($children_ids as $child_id)
		{
			if ( ! $this->_check_page_is($child_id))
			{
				return (int) false;
			}
		}

		return (int) true;
	}

	/**
	 * Page has function
	 *
	 * Check if this page has children
	 *
	 * Usage:
	 * {{ pages:has id="4" }}
	 *
	 * @param  int id   The id of the page you want to check
	 * @return bool
	 */
	public function has()
	{
		return $this->page_m->has_children($this->attribute('id'));
	}

	/**
	 * Check Page is function
	 *
	 * Works for page is function
	 *
	 * @param  mixed  The Id or Slug of the page
	 * @param  array  Plugin attributes
	 * @return int    0 or 1
	 */
	private function _check_page_is($child_id = 0)
	{
		$descendent_id = $this->attribute('descendent');
		$parent_id     = $this->attribute('parent');

		if ($child_id and $descendent_id)
		{
			if ( ! is_numeric($child_id))
			{
				$child_id = ($child = $this->page_m->get_by(array('slug' => $child_id))) ? $child->id : 0;
			}

			if ( ! is_numeric($descendent_id))
			{
				$descendent_id = ($descendent = $this->page_m->get_by(array('slug' => $descendent_id))) ? $descendent->id : 0;
			}

			if ( ! ($child_id and $descendent_id))
			{
				return false;
			}

			$descendent_ids = $this->page_m->get_descendant_ids($descendent_id);

			return in_array($child_id, $descendent_ids);
		}

		if ($child_id and $parent_id)
		{
			if ( ! is_numeric($child_id))
			{
				$parent_id = ($parent = $this->page_m->get_by(array('slug' => $parent_id))) ? $parent->id : 0;
			}

			return $parent_id ? (int) $this->page_m->count_by(array(
				(is_numeric($child_id) ? 'id' : 'slug') => $child_id,
				'parent_id' => $parent_id
			)) > 0 : false;
		}
	}
	
	/**
	 * Tree html function
	 *
	 * Creates a page tree
	 *
	 * @param  array
	 * @return  array
	 */
	private function _build_tree_html($params)
	{
		$params = array_merge(array(
			'tree'         => array(),
			'parent_id'    => 0
		), $params);

		extract($params);

		if ( ! $tree)
		{
			$this->db
				->select('id, parent_id, slug, uri, title')
				->where_not_in('slug', $this->disable);
			
			// check if they're logged in
			if ( isset($this->current_user->group) )
			{
				// admins can see them all
				if ($this->current_user->group != 'admin')
				{
					$id_list = array();
					
					$page_list = $this->db
						->select('id, restricted_to')
						->get('pages')
						->result();

					foreach ($page_list as $list_item)
					{
						// make an array of allowed user groups
						$group_array = explode(',', $list_item->restricted_to);

						// if restricted_to is 0 or empty (unrestricted) or if the current user's group is allowed
						if ( ($group_array[0] < 1) or in_array($this->current_user->group_id, $group_array) )
						{
							$id_list[] = $list_item->id;
						}
					}
					
					// if it's an empty array then evidently all pages are unrestricted
					if ( count($id_list) > 0 )
					{
						// select only the pages they have permissions for
						$this->db->where_in('id', $id_list);
					}
					
					// since they aren't an admin they can't see drafts
					$this->db->where('status', 'live');
				}
			}
			else
			{
				//they aren't logged in, show them all live, unrestricted pages
				$this->db
					->where('status', 'live')
					->where('restricted_to <', 1)
					->or_where('restricted_to', null);
			}
			
			$pages = $this->db
				->order_by($order_by, $order_dir)
				->get('pages')
				->result();

			if ($pages)
			{
				foreach ($pages as $page)
				{
					$tree[$page->parent_id][] = $page;
				}
			}
		}

		if ( ! isset($tree[$parent_id]))
		{
			return;
		}

		$html = '';

		foreach ($tree[$parent_id] as $item)
		{
			$html .= '<li';
			$html .= (current_url() == site_url($item->uri)) ? ' class="current">' : '>';
			$html .= ($link === true) ? '<a href="' . site_url($item->uri) . '">' . $item->title . '</a>' : $item->title;
			
			
			$nested_list = $this->_build_tree_html(array(
				'tree'         => $tree,
				'parent_id'    => (int) $item->id,
				'link'         => $link,
				'list_tag'     => $list_tag
			));
			
			if ($nested_list)
			{
				$html .= '<' . $list_tag . '>' . $nested_list . '</' . $list_tag . '>';
			}
			
			$html .= '</li>';
		}

		return $html;
	}


	//
	// pelajari plugin
	//
	public function pelajari()
	{
		$page = new stdClass();
		$section = $this->attribute('section', 'index');
		//echo "AM HERE<br />";
		if ($section=='index')
		{
			$page = $this->page_m->get_by('slug', 'pelajari');
			$page->children = $this->get_children($page->id);
		}

		$ret = !empty($page->children) ? $page->children : $page;
/**
echo "<pre>\n";
print_r($ret);
exit;
/**/

		return $ret;
	}

	public function prev_nextY()
	{
		$current = $this->attribute('current');

		$this_page = $this->db->where('id', $current)->get('pages')->row();

		if (empty($this_page) && !$this_page->parent_id)
		{
			return;
		}
		//$this_page = null;
		//$prev_next = $this->page_m->get_many_by(array('prev_next'=>$current, 'parent_id'=>$this_page->parent_id));

		$where = " (".$this->db->dbprefix('pages').".id < ".$current." OR ".$this->db->dbprefix('pages').".id > ".$current.") ";
		$this->db->where($where);
		$this->db->limit(2);

		$pages = $this->db->select('pages.*, page_types.stream_id, page_types.slug as page_type_slug, page_types.title as page_type_title')
			->where($where)
			->where('status', 'live')
			->where('parent_id', $this_page->parent_id)
			->join('page_types', 'page_types.id = pages.type_id', 'left')
			->order_by('order')
			->get('pages')
			->result();

/**
echo "<pre>\n";
print_r($pages);
exit;
/**/

		// Custom fields provision.
		// Since page children can have many different page types,
		// we are going to do this in the most economical way possible:
		// Find the entries by ID and attach them to a special custom_fields
		// variable.
		if ($pages)
		{
//echo "AM HERE"; exit;
			$custom_fields = array();
			$this->load->driver('Streams');
		
			// Get all of the IDs by page type id.
			// Ex: array('page_type_id' => array('1', '2'))
			$entries = $_pages = array();
			foreach ($pages as $page)
			{
echo "\$page->id: ".$page->entry_id."<br />\n";
				$_pages[] = $this->db
					->select('pages.*, page_types.id as page_type_id, page_types.stream_id, page_types.body')
					->select('page_types.save_as_files, page_types.slug as page_type_slug, page_types.title as page_type_title, page_types.js as page_type_js, page_types.css as page_type_css')
					->join('page_types', 'page_types.id = pages.type_id', 'left')
					->where('pages.id', $page->id)
					->get('pages')
					->row();

				//$entries[$page['stream_id']][] = $page['entry_id'];
				$stream = $this->streams_m->get_stream($page->stream_id);
				$entries[] = $this->streams->entries->get_entries(array(
					'stream'=>$stream->stream_slug,
					'include'=>$page->stream_id,
					'namespace'=> $stream->stream_namespace,
					'disable'=> 'created_by'
				));
			}

/**/
echo "<pre>\n";
echo "\$_pages:\n";
print_r($_pages);
echo "<hr />\n";
echo "\$stream:\n";
print_r($stream);
echo "<hr />\n";
echo "\$entries\n";
print_r($entries);
exit;
/**/

			// Get our entries by steram
			foreach ($entries as $stream_id => $entry_ids)
			{
				$stream = $this->streams_m->get_stream($stream_id);

				$params = array(
					'stream'		=> $stream->stream_slug,
					'namespace'		=> $stream->stream_namespace,
					'include'		=> implode('|', $entry_ids),
					'disable'		=> 'created_by'
				);

				$entries = $this->streams->entries->get_entries($params);

				// Set the entries in our custom fields array for
				// easy reference later when processing our pages.
				foreach ($entries['entries'] as $entry)
				{
					$custom_fields[$stream_id][$entry['id']] = $entry;	
				}
			}
		}
		else
		{
			$custom_fields = false;
		}

/**/
echo "<pre>\n";
print_r($custom_fields);
exit;
/**/

		echo '<pre>'.print_r($pages, true).'</pre>';
		exit;

		return $pages;
	}

	public function prev_nextX()
	{
		$current = $this->attribute('current');
		$this_page = $this->page_m->get($current, false);
		if ($this_page && !$this_page->parent_id)
		{
			return;
		}
		//$this_page = null;
		$prev_next = $this->page_m->get_many_by(array('prev_next'=>$current, 'parent_id'=>$this_page->parent_id));

		if ($prev_next)
		{
			//$this->load->driver('Streams');
			$custom_fields = array();
			foreach ($prev_next as $key => $page)
			{
				$data = $this->page_m->get($page->entry_id);

echo "<pre>\n";
print_r($data);
exit;
			}

			foreach ($prev_next as $key => $page)
			{

				// Check for custom fields
				$stream = $this->streams_m->get_stream($page->stream_id);

				$params = array(
					'stream'		=> $stream->stream_slug,
					'namespace'		=> $stream->stream_namespace,
					'include'		=> $page->entry_id,
					'disable'		=> 'created_by'
				);

				$entries = $this->streams_m->get_stream($page->stream_id);

echo "<pre>\n";
print_r($entries);
exit;

				// foreach ($entries['entries'] as $entry)
				// {
				// 	$custom_fields[$page->stream_id][$entry['id']] = $entry;
				// }

				// // If we have custom fields, we need to roll our
				// // entry values in.
				// if ($custom_fields and isset($custom_fields[$page->stream_id][$page->entry_id]))
				// {
				// 	$page->custom_fields = array($custom_fields[$page->stream_id][$page->entry_id]);
				// }


			}
		}
		ob_start();
		echo "<pre>\n";
		echo "\$prev_next:\n";
		print_r($prev_next);
		echo "</pre>\n";
		$content = ob_get_contents();
		ob_end_clean();
		return "<h3>Dari plugin: \$current: $current</h3>\n".$content;
	}

	public function prev_next()
	{
		$current = $this->attribute('current');
		$this_page = $this->page_m->get($current, false);
		if ($this_page && !$this_page->parent_id)
		{
			return;
		}
		//$this_page = null;
		$prev_next = $this->page_m->get_many_by(array('prev_next'=>$current, 'parent_id'=>$this_page->parent_id));

echo "<pre>\n";
print_r($prev_next);
exit;

		if (!$prev_next)
		{
			//$this->load->driver('Streams');
			$custom_fields = array();
			foreach ($prev_next as $key => $page)
			{
				$data = $this->page_m->get($page->entry_id, false);

echo "<pre>\n";
print_r($data);
exit;
			}

		}


		ob_start();
		echo "<pre>\n";
		echo "\$prev_next:\n";
		print_r($prev_next);
		echo "</pre>\n";
		$content = ob_get_contents();
		ob_end_clean();
		return "<h3>Dari plugin: \$current: $current</h3>\n".$content;
	}

	private function get_children($slug='')
	{
		$pages = $this->db->select('pages.*, page_types.stream_id, page_types.slug as page_type_slug, page_types.title as page_type_title')
			->where('pages.parent_id', $slug)
			->where('status', 'live')
			->join('page_types', 'page_types.id = pages.type_id', 'left')
			->order_by('order')
			->get('pages')
			->result_array();

		// Custom fields provision.
		// Since page children can have many different page types,
		// we are going to do this in the most economical way possible:
		// Find the entries by ID and attach them to a special custom_fields
		// variable.
		if ($pages)
		{
//echo "AM HERE"; exit;
			$custom_fields = array();
			$this->load->driver('Streams');
		
			// Get all of the IDs by page type id.
			// Ex: array('page_type_id' => array('1', '2'))
			$entries = array();
			foreach ($pages as $page)
			{
				$entries[$page['stream_id']][] = $page['entry_id'];
			}

			// Get our entries by steram
			foreach ($entries as $stream_id => $entry_ids)
			{
				$stream = $this->streams_m->get_stream($stream_id);

				$params = array(
					'stream'		=> $stream->stream_slug,
					'namespace'		=> $stream->stream_namespace,
					'include'		=> implode('|', $entry_ids),
					'disable'		=> 'created_by'
				);

				$entries = $this->streams->entries->get_entries($params);

				// Set the entries in our custom fields array for
				// easy reference later when processing our pages.
				foreach ($entries['entries'] as $entry)
				{
					$custom_fields[$stream_id][$entry['id']] = $entry;	
				}
			}
		}
		else
		{
			$custom_fields = false;
		}

		// Legacy support for chunks
		if ($pages and $this->db->table_exists('page_chunks'))
		{
			foreach ($pages as &$page)
			{
				// Grab all the chunks that make up the body for this page
				$page['chunks'] = $this->db
					->get_where('page_chunks', array('page_id' => $page['id']))
					->result_array();

				$page['body'] = '';
				if ($page['chunks'])
				{
					foreach ($page['chunks'] as $chunk)
					{
						$page['body'] .= '<div class="page-chunk ' . $chunk['slug'] . '">' .
							(($chunk['type'] == 'markdown') ? $chunk['parsed'] : $chunk['body']) .
							'</div>' . PHP_EOL;
					}
				}
			}
		}

		// Process our pages.
		foreach ($pages as $idx => &$page)
		{
			// First, let's get a full URL. This is just
			// handy to have around.
			$page['url'] = site_url($page['uri']);
		
			// Now let's process our keywords hash.
			$keywords = Keywords::get($page['meta_keywords']);

			// In order to properly display the keywords in Lex
			// tags, we need to format them.
			$formatted_keywords = array();
			
			foreach ($keywords as $key)
			{
				$formatted_keywords[] 	= array('keyword' => $key->name);

			}
			$page['meta_keywords'] = $formatted_keywords;

			// If we have custom fields, we need to roll our
			// entry values in.
			if ($custom_fields and isset($custom_fields[$page['stream_id']][$page['entry_id']]))
			{
				$page['custom_fields'] = array($custom_fields[$page['stream_id']][$page['entry_id']]);
			}
/* *
echo "<pre>";
echo "Title: " . $custom_fields[$page['stream_id']][$page['entry_id']]['title_en'] . "\n";
echo "\$custom_fields:\n";
print_r($custom_fields[$page['stream_id']][$page['entry_id']]['body']);
exit;
/* */

			$page['idx'] = $idx+1;
			$the_body = $custom_fields[$page['stream_id']][$page['entry_id']]['body'];
			if (AUTO_LANGUAGE=='en')
			{
				if ($custom_fields[$page['stream_id']][$page['entry_id']]['body_en'])
					$the_body = $custom_fields[$page['stream_id']][$page['entry_id']]['body_en'];

				if ($custom_fields[$page['stream_id']][$page['entry_id']]['title_en'])
					$page['title'] = $custom_fields[$page['stream_id']][$page['entry_id']]['title_en'];
			}
			$page['intro'] = word_limiter(strip_tags($the_body), 30);
		}

		//return '<pre>'.print_r($pages, true).'</pre>';

		return $pages;
	}
}
