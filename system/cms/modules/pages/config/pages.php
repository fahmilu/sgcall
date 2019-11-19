<?php defined('BASEPATH') OR exit('No direct script access allowed');

// define all custom fields that a new installation should have
$config['pages:default_fields']	= array(
	array(
		'name'          => 'lang:pages:body_label',
		'slug'          => 'body',
		'namespace'     => 'pages',
		'type'          => 'wysiwyg',
		'extra'			=> array('editor_type' => 'advanced', 'allow_tags' => 'y'),
		'assign'        => 'def_page_fields'
	),
	array(
		'name'          => 'lang:pages:body_label',
		'slug'          => 'body_en',
		'namespace'     => 'pages',
		'type'          => 'wysiwyg',
		'extra'			=> array('editor_type' => 'advanced', 'allow_tags' => 'y'),
		'assign'        => 'def_page_fields'
	),
	array(
		'name'          => 'Title',
		'slug'          => 'title_en',
		'namespace'     => 'pages',
		'type'          => 'text',
		'assign'        => 'def_page_fields'
	),
	array(
		'name'          => 'lang:pages:meta_title_label',
		'slug'          => 'meta_title_en',
		'namespace'     => 'pages',
		'type'          => 'text',
		'assign'        => 'def_page_fields'
	),
	array(
		'name'          => 'lang:pages:meta_keywords_label',
		'slug'          => 'meta_keywords_en',
		'namespace'     => 'pages',
		'type'          => 'text',
		'assign'        => 'def_page_fields'
	),
	array(
		'name'          => 'lang:pages:meta_desc_label',
		'slug'          => 'meta_description_en',
		'namespace'     => 'pages',
		'type'          => 'textarea',
		'assign'        => 'def_page_fields'
	),
);
/*
$config['pages:default_fields2'] = array(
	array(
		'name'          => 'lang:pages:body_label',
		'slug'          => 'body_en',
		'namespace'     => 'pages',
		'type'          => 'wysiwyg',
		'extra'			=> array('editor_type' => 'advanced', 'allow_tags' => 'y'),
		'assign'        => 'def_page_fields'
	)
);
*/

// and now the content for the pages
$config['pages:default_page_content'] = array(
		/* The home page data. */
		'home' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>Selamat datang di website kami. Website ini masih dalam pengembangan. Silakan bookmark kami dan kunjungi kami kembali di lain waktu.</p>',
			'body_en' => '<p>Welcome to our homepage. We have not quite finished setting up our website yet, but please add us to your bookmarks and come back soon.</p>',
			'title_en' => 'Home',
			'created_by' => 1
		),
		/* The contact page data. */
		'contact' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>Untuk menghubungi kami, silakan isi formulir di bawah ini.</p>
				{{ contact:form name="text|required" email="text|required|valid_email" subject="dropdown|Support|Sales|Feedback|Other" message="textarea" attachment="file|zip" }}
					<div><label for="name">Nama:</label>{{ name }}</div>
					<div><label for="email">Email:</label>{{ email }}</div>
					<div><label for="subject">Tentang:</label>{{ subject }}</div>
					<div><label for="message">Pesan:</label>{{ message }}</div>
					<div><label for="attachment">Lampirkan file zip:</label>{{ attachment }}</div>
				{{ /contact:form }}',
			'body_en' => '<p>To contact us please fill out the form below.</p>
				{{ contact:form name="text|required" email="text|required|valid_email" subject="dropdown|Support|Sales|Feedback|Other" message="textarea" attachment="file|zip" }}
					<div><label for="name">Name:</label>{{ name }}</div>
					<div><label for="email">Email:</label>{{ email }}</div>
					<div><label for="subject">Subject:</label>{{ subject }}</div>
					<div><label for="message">Message:</label>{{ message }}</div>
					<div><label for="attachment">Attach  a zip file:</label>{{ attachment }}</div>
				{{ /contact:form }}',
			'title_en' => 'Hubungi Kami',
			'created_by' => 1
		),
		/* The search page data. */
		'search' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => "{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Kata kunci...\" />\n	{{ /search:form }}",
			'body_en' => "{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Search terms...\" />\n	{{ /search:form }}",
			'title_en' => 'Penelusuran',
			'created_by' => 1
		),
		/* The search results page data. */
		'search-results' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => "{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Kata kunci...\" />\n	{{ /search:form }}\n\n{{ search:results }}\n\n	{{ total }} hasil pencarian \"{{ query }}\".\n\n	<hr />\n\n	{{ entries }}\n\n		<article>\n			<h4>{{ singular }}: <a href=\"{{ url }}\">{{ title }}</a></h4>\n			<p>{{ description }}</p>\n		</article>\n\n	{{ /entries }}\n\n        {{ pagination }}\n\n{{ /search:results }}",
			'body_en' => "{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Search terms...\" />\n	{{ /search:form }}\n\n{{ search:results }}\n\n	{{ total }} results for \"{{ query }}\".\n\n	<hr />\n\n	{{ entries }}\n\n		<article>\n			<h4>{{ singular }}: <a href=\"{{ url }}\">{{ title }}</a></h4>\n			<p>{{ description }}</p>\n		</article>\n\n	{{ /entries }}\n\n        {{ pagination }}\n\n{{ /search:results }}",
			'title_en' => 'Hasil Penelusuran',
			'created_by' => 1
		),
		'fourohfour' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>Mohon maaf, kami tidak dapat menemukan halaman yang anda tuju. Silakan klik <a title="Beranda" href="{{ pages:url id=\'1\' }}">di sini</a> untuk kembali ke halaman .</p>',
			'body_en' => '<p>We cannot find the page you are looking for, please click <a title="Home" href="{{ pages:url id=\'1\' }}">here</a> to go to the homepage.</p>',
			'title_en' => 'Page not found',
			'created_by' => 1
		)
);