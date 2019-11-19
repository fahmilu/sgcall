<?php if (!empty($trip)) : ?>
    <ul id="testilist">
        <?php foreach ($trip as $t) : ?>
            <li>
                <div class="postbox">
                    <div class="boximg-blog"><?php echo img(array('src' => gravatar($t->email, 84, 'g', true), 'class' => 'boximg-pad', 'alt' => $t->name)) ?></div>
                    <p><?php echo $t->message ?></p>
                    <p class="testiname"><?php echo $t->website ? anchor($t->website, $t->name) : $t->name ?> <?php echo $t->company ? '' . $t->company : '' ?></p>
                </div>
                <div class="spacer"></div>
            </li>
        <?php endforeach ?>
    </ul>

    <div class="pagination">
        <?php echo $pagination['links'] ?>
    </div>
<?php else : ?>
    <div class="info"><?php echo lang('msg_no_trip') ?></div>
<?php endif; ?>
