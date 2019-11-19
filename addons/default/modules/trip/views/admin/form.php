<section class="title">
	<?php if ($this->method == 'create'): ?>
	    <h4><?php echo lang('lbl_create'); ?></h4>
	<?php else: ?>
	    <h4><?php echo lang('lbl_edit'); ?></h4>
	<?php endif; ?>
</section>

<section class="item">
<div class="content">

<div id="maincontactform" class="form_inputs">
    <?php echo form_open_multipart(uri_string(), array('id' => 'trip-form')) ?>
<fieldset>
	<ul>

      <li>
        <label for="status"><?php echo lang('lbl_status'); ?></label>
        <div class="input"><?php echo form_dropdown('status', array('0' => lang('lbl_draft'), '1' => lang('lbl_live')), $data->status) ?></div>
      </li>
        <li><label><?php echo lang('lbl_label', 'label') ?><span>*</span></label>
            <div class="input"><?php echo form_input('label', $data->label, 'class="textfield" style="width: 300px;"') ?></div>
        </li>
        <li><label><?php echo lang('lbl_title', 'title') ?> (Maximum 100 Chars)<span>*</span></label>
            <div class="input"><?php echo form_input('title', $data->title, 'class="textfield" style="width: 800px;"') ?></div>
        </li>
        <li><label><?php echo lang('lbl_date', 'date') ?><span>*</span></label>
            <div class="input"><?php echo form_input('datestart', $data->datestart, 'class="textfield" id="datestart" style="width: 100px;"') ?> - <?php echo form_input('dateend', $data->dateend, 'class="textfield" id="dateend" style="width: 100px;"') ?></div>
        </li>
        <li>
            <label><?php echo lang('lbl_photo', 'photo') ?></label>
            <div class="input">
                <?php if($data->photo){ ?>
                    <img src="<?php echo UPLOAD_PATH.'trip/'.$data->photo;?>" style="display:block;margin-bottom:10px; height: 200px;" id="imgInp" />
                    <input type="hidden" name="curimg" value="<?php echo $data->photo; ?>" />
                <?php }else{ ?>
                    <img src="#" style="display:none;margin-bottom:10px; height: 200px;" id="imgInp" />
                <?php } ?>
                <?php echo form_upload('photo', '', 'id="pic" accept="image/*"'); ?>
            </div>
        </li>

        <li>
            <label><?php echo lang('lbl_description', 'description') ?> (Maximum 250 Chars)<span>*</span></label>
            <textarea id="slidebody" name="description" maxlength="250" rows="3" cols="25" style="width:600px;height:100px;display: block;"><?php echo $data->description; ?></textarea>
        </li>
        <li><label><?php echo lang('lbl_link', 'link') ?> <span>*</span></label>
            <div class="input"><?php echo form_input('link', $data->link, 'class="textfield" style="width: 800px;"') ?></div>
        </li>
        <br />
	</ul>

        <div class="clear"></div>

	<div class="align-right buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
	</div>

<!--
        <a href="#" class="button" id="buttonsend" ><span><?php echo lang('btn_send') ?></span></a>
        <span class="loading" style="display: none"><?php echo lang('lbl_ajax_process') ?></span>
-->

    <?php echo form_close() ?>
</fieldset>

<!--
<script type="text/javascript">
    $(function(){
        $('#buttonsend').click(function(){
            $('.loading').show();
            $(this).hide();

            var form = $('#trip-form');
            $.post(form.attr('action'), form.serialize(), function(html){
                $('.maincontent-right').html(html);
            }, 'html');
            return false;
        });
    })
</script>
-->

<script>
    $(document).ready(function() {
        // $('#datestart').datepicker({ minDate: 0 , dateFormat: 'M d, yy'});
        // $('#dateend').datepicker({ minDate: 0 , dateFormat: 'M d, yy'});

    var dateFormat = "M d, yy",
      from = $( "#datestart" )
        .datepicker({
          defaultDate: "+1w",
          // changeMonth: true,
          dateFormat: 'M d, yy',
          minDate: 0 ,
          // numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#dateend" ).datepicker({
        defaultDate: "+1w",
        minDate: 0 ,
        dateFormat: 'M d, yy',
        // changeMonth: true,
        // numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
    
    if($('#datestart').val() != ''){
        // $.datepicker.parseDate( dateFormat, $('#datestar').val() );
          to.datepicker( "option", "minDate", getDate2( $('#datestart') ) );
    }    

    if($('#dateend').val() != ''){
          from.datepicker( "option", "maxDate", getDate2( $('#dateend') ) );
    }

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }

    function getDate2( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.val() );
      } catch( error ) {
        date = null;
      }
      console.log(date);
      return date;
    }

        $("#pic").change(function(){
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#imgInp').attr('src', e.target.result);
                    $('#imgInp').css('display', 'block');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
</div>
</section>