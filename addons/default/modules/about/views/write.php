<?php if( $this->session->flashdata('success') ) : ?>
    <div class="success"><?php echo $this->session->flashdata('success') ?></div>
<?php endif ?>
    
<?php if( $this->session->flashdata('error') ) : ?>
    <div class="error"><?php echo $this->session->flashdata('error') ?></div>
<?php endif ?>
    

<div id="maincontactform">
    <?php echo form_open(current_url(), array('id' => 'testimonial-form')) ?>
    <div>
        <?php echo lang('lbl_name', 'name') ?>
        <?php echo form_input('name', set_value('name', $current_user ? $current_user->name : ''), 'class="textfield"') ?><span class="require"> *</span>
        <?php echo form_error('name') ?>

        <?php echo lang('lbl_email', 'email') ?>
        <?php echo form_input('email', set_value('email', $current_user ? $current_user->email : ''), 'class="textfield"') ?><span class="require"> *</span>
        <?php echo form_error('email') ?>

        <?php echo lang('lbl_message', 'message') ?>
        <?php echo form_textarea('message', set_value('message'), 'class="textarea"') ?> <span class="require"> *</span>
        <?php echo form_error('message') ?>

        <?php echo lang('lbl_message_en', 'message_en') ?>
        <?php echo form_textarea('message_en', set_value('message_en'), 'class="textarea"') ?> <span class="require"> *</span>
        <?php echo form_error('message_en') ?>

        <div class="clear"></div>

        <a href="#" class="button" id="buttonsend" ><span><?php echo lang('btn_send') ?></span></a>
        <span class="loading" style="display: none"><?php echo lang('lbl_ajax_process') ?></span>
    </div>
    <?php echo form_close() ?>
</div>

<script type="text/javascript">
    $(function(){
        $('#buttonsend').click(function(){
            $('.loading').show();
            $(this).hide();

            var form = $('#testimonial-form');
            $.post(form.attr('action'), form.serialize(), function(html){
                $('.maincontent-right').html(html);
            }, 'html');
            return false;
        });
    })
</script>