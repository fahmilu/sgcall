(function($) {
    $(function() {
        do_sortable();
        /**
         * Shortcut click event
         */
        $('#shortcuts ul li a, a[rel=ajax], a.button').live('click', function(e) {
            e.preventDefault();
            var load_url = $(this).attr('href');
            remove_notification();
            load_content(load_url);
        });
        /**
         * Form submit events
         */
        $('form#faq, form#categories').live('submit', function(e) {
            e.preventDefault();
           var post_url = $(this).attr('action');
           var form_id = $(this).attr('id');
           var form_data = new FormData($(this)[0]);
           do_submit(post_url, form_data, form_id);
        });
        
        /**
         * Sortable
         */
        function do_sortable()
        {
            $('.faq-list tbody').sortable({
                start: function(event, ui) {
                    $('tr').removeClass('alt');
                },
                stop: function(event, ui) {
                    order = new Array();
                    $('td.action-to input').each(function(index) {
                        var faq_id = $(this).val();
                        order[index] = faq_id;
                    });
                    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                    $.post(SITE_URL + 'admin/faq/update_order', { csrfName : csrfHash,  order : order }, function(data, response, xhr) {
                    
                    });
                }
            });
        }
        
        /**
         * Form submit handler
         */
        function do_submit(post_url, form_data, form_id)
        {
            var url = SITE_URL + 'admin/faq';
            if(form_id == 'categories')
            {
                url = SITE_URL + 'admin/faq/categories';
            }
            $.ajax({
                url: post_url,
                type: "POST",
                data: form_data,
                success: function(return_data){
                    var obj = $.parseJSON(return_data);
                    if(obj.status == 'success')
                    {
                        load_content(url,obj.status,obj.message);
                        //create_notification(obj.status, obj.message);
                    } else {
                        create_notification(obj.status, obj.message);
                    }
                },
                contentType: false,
                processData: false
            });
            // $.post(post_url, form_data, function(data, response, xhr) {
            //      var obj = $.parseJSON(data);
            //      if(obj.status == 'success')
            //      {
            //         load_content(url,obj.status,obj.message);
				// 	//create_notification(obj.status, obj.message);
            //      }
				//  else
				// 	create_notification(obj.status, obj.message);
            // });
        }
        
        /**
         * add notification
         */
        function create_notification(type, message)
        {
            var notice = '<div class="alert '+ type +'">'+message+'</div>';
            remove_notification();
            $('#content-body').prepend(notice);
            $('.alert').fadeIn('normal');
        }
        
        /**
         * Remove notifications
         */
        function remove_notification()
        {
            $('.alert').fadeOut('normal', function() {
               $(this).remove(); 
            });
        }
        
        /**
         * Content switcher
         */
        function load_content(load_url,type,message)
        {
            $('#content-body').fadeOut('normal', function() {
               $(this).load(load_url, function(data, response, xhr) {
                    
					//handle answer ckeditor
					if(typeof CKEDITOR != 'undefined')
					{
						var editor = CKEDITOR.instances['answer'];
						if (editor)
						{
							// editor.destroy(true);
						}
					}
					init_ckeditor();
                    do_sortable();
					$(this).find('.table_action_buttons button').attr('disabled','disabled');
					if( typeof type != 'undefined' && typeof message != 'undefined' )
						create_notification(type,message);
						
                    $(this).fadeIn('normal');
               });
            });
        }
        
        function init_ckeditor()
        {
            $('textarea.wysiwyg-simple').ckeditor({
                toolbar: [
                    ['Maximize'],
                    ['pyroimages', 'pyrofiles'],
                    ['Cut','Copy','Paste','PasteFromWord'],
                    ['Undo','Redo','-','Find','Replace'],
                    ['Link','Unlink'],
                    ['Table','HorizontalRule','SpecialChar'],
                    ['Bold','Italic','StrikeThrough'],
                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],
                    ['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],
                    ['ShowBlocks', 'RemoveFormat', 'Source']
                ],
				width: '99%',
				height: 100,
				dialog_backgroundCoverColor: '#000',
                enterMode: 1,
                shiftEnterMode: 2,
				contextmenu: { options: 'Context Menu Options' }
			});
        }
    });
})(jQuery);