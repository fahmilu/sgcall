<?php $themes = $this->bcalib->getThemes(); ?>
<section id="Gallery" class="with-banner">
    <div class="banner"></div>
    <div class="container">
        <div class="content-gallery">
            <div class="row resp">
                <?php foreach ($result->result() as $item) { ?>
                    <div class="col-6 col-md-4 list">
                        <a href="<?php echo site_url(UPLOAD_PATH. 'gallery/'. $item->image); ?>" class="image-link">
                            <div class="img">
                                <div class="lazy" data-src="<?php echo site_url(UPLOAD_PATH. 'gallery/'. $item->image); ?>"></div>
                            </div>
                            <div class="text-content">
                                <div class="name"><?php echo $item->name; ?></div>
                                <div class="img-title">"<?php echo $item->img_title; ?>"</div>
                                <div class="theme text-main-color">Tema : <?php echo $themes[$item->img_theme]; ?></div>  
                            </div>              
                        </a>
                    </div>
                <?php } ?>                
            </div>
        </div>
        <div class="btn-area text-center">
            <?php echo $pagination; ?>
        </div>
        
    </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
    $('.lazy').lazy({
        effect: "fadeIn",
        effectTime: 1000,
        threshold: 0
    });

    $('.image-link').magnificPopup({type:'image'});
  });
</script>