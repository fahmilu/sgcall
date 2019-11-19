<section id="PromoBanner" class="banner-default">
    <div class="container">
        <h2 class="text-light">PENAWARAN<br /> MENARIK</h2>
    </div>
</section>
<section id="PromoList" class="class-promo">
	<div class="container">
		<?php if ($result->num_rows() > 0): ?>
			<div class="list-promo row">
				<?php foreach ($result->result() as $r) { ?>
					<div class="col-md-4">
						<a href="<?php echo $r->link; ?>" class="promo" target="_blank">
							<div class="img lazy" data-src="<?php echo $r->img_url; ?>"></div>
							<h4><?php echo $r->title; ?></h4>
							<p><?php echo $r->description; ?>"</p>
							<div class="bottom">
								<span>Mulai dari (/orang) :</span>
								<div>
									<div class="price float-left text-main-color"><?php echo $r->price; ?></div>
									<div class="btn-area float-right">
										<button class="main-btn-no-hover">INFO</button>
									</div>
									<div class="clearfix"></div>									
								</div>
							</div>						
						</a>
					</div>
				<?php } ?>
			</div>		
			<?php echo $pagination; ?>	
		<?php else: ?>
            <div class="text-center font-weight-bold" style="height: 200px;">PROMO TIDAK DITEMUKAN</div>
		<?php endif ?>
	</div>
</section>
