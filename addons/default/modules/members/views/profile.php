<section>
    <div class="container">
        <?php echo 'Hi ' . $user->name; ?>
        <br />
        <br />
        <br />
        <?php foreach ($quest->result() as $q) { ?>
            <?php if ($q->status == 0 or $q->status == 2): ?>
                <?php echo form_open_multipart('members/submit', array('class'=>'quest_form', "type" => $q->type), array('user_id'=>$user->id, 'quest_id'=> $q->id, 'type'=> $q->type, 'point'=> $q->point)); ?>
                <?php echo $q->rest_quest.'/'.$q->max_quest; ?><br />
                <strong><?php echo $q->title; ?></strong>
                <p><?php echo $q->description; ?></p>
                <?php if ($q->type == 1): ?>
                    <input type="file" name="image" accept="image/*" required />
                <?php else: ?>
                    <input type="text" name="url" required />
                <?php endif ?>
                <input type="submit" name="submit" value="submit" />
                <br />    
                <?php echo form_close(); ?>      
                <hr/>     
            <?php endif ?>
        <?php } ?>        
    </div>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form.quest_form').each(function() {
            if($(this).attr('type') == 1){
                $.validator.addMethod('filesize', function (value, element, arg) {
                    // var minsize=1000; // min 1kb
                    // console.log(element.files[0].size);
                    if(element.files[0].size <= arg){
                        return true;
                    }else{
                        return false;
                    }
                });

                $(this).validate({
                    rules: {
                        image:{
                            required:true,
                            accept:"image/gif,image/jpeg,image/png",
                            filesize: 150000   //max size 200 kb
                        }
                    },messages: {
                        image:{
                            filesize:" file size must be less than 150 KB.",
                            accept:"Please upload .jpg or .png or .gif file of notice.",
                            required:"Please upload file."
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            }else{
                $(this).validate({
                    rules: {
                        url: {
                            required: true,
                            url: true
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });                
            }

        });       
    });
</script>