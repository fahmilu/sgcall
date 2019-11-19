<section class="title">
    <h4><?php echo lang('event'); ?></h4>
</section>
<style type="text/css">
    .tag{
        display: inline-block;
        padding: 5px;
        background: #ccc;
        margin-right: 3px;
        margin-bottom: 5px;
        color: #000;
        white-space: nowrap;
    }
</style>

<section class="item">
<div class="content">

    <?php echo form_open('admin/event/actions'); ?>

    <?php if (!empty($event)): ?>

        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th width="200"><?php echo lang('lbl_title'); ?></th>
                    <th width="140"><?php echo lang('lbl_photo'); ?></th>
                    <th width="300"><?php echo lang('lbl_description'); ?></th>
                    <!-- <th width="300"><?php echo lang('lbl_link'); ?></th> -->
                    <th width="300">Event Detail</th>
                    <th width="300">Tags</th>
                    <th width="100"><?php echo lang('lbl_status'); ?></th>
                    <th width="140"><?php echo lang('lbl_created_on'); ?></th>
                    <th width="140"></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($event as $t): ?>
                    <?php
                        if($t->dateend){
                            if($t->dateend != $t->date){
                                $eventdate = date('M d, Y', $t->date).' - '.date('M d, Y', $t->dateend);
                            }else{
                                $eventdate = date('M d, Y', $t->date);
                            }
                        }else{
                            $eventdate = date('M d, Y', $t->date);
                        }
                    ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $t->id); ?></td>
                        <td><strong><strong><a href="<?php echo $t->link; ?>" target="_blank"><?php echo $t->title; ?></a></strong></strong></td>
                        <td><?php echo ($t->photo) ? '<img src="'.UPLOAD_PATH.'event/'.$t->photo.'" style="width: 200px;" />' : '' ; ?></td>
                        <td><?php echo $t->description; ?></td>
                        <!-- <td><<a href="<?php echo $t->link; ?>">See The Link</a></td> -->
                        <td><?php echo $t->location; ?><br /><?php echo $eventdate.' '.$t->time; ?></td>
                        <td>
                            <?php $tags = explode(',', $t->tags);
                                foreach ($tags as $tag) {
                                    echo '<div class="tag">'.ucwords($tag).'</div>';
                                }
                            ?>
                        </td>
                        <td><?php echo ($t->status == 1) ? 'Live' : 'Draft' ; ?></td>
                        <td><?php echo date('M d, Y', $t->created_on) ?></td>
                        <td class="align-center buttons buttons-small">
                            <?php echo anchor('admin/event/edit/' . $t->id, lang('global:edit'), 'class="btn blue"'); ?>
                            <?php echo anchor('admin/event/delete/' . $t->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="table_action_buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
        </div>

    <?php else: ?>
        <div class="blank-slate">
            <div class="no_data">
                <?php echo lang('msg_no_event'); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php echo form_close(); ?>

</div>
</section>