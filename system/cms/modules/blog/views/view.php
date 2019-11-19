<section id="StoryDetail">
	<div class="container">
		<a href="{{url:site}}cerita" class="d-block d-md-none">
			<img src="{{url:site}}{{theme:path}}/img/icons/back-btn.png" style="height: 30px; margin-bottom: 30px;" />
		</a>
		<div class="label text-center text-uppercase"><?php echo $category; ?></div>
		<h2 class="text-center"><?php echo $post['title']; ?></h2>
		<img src="<?php echo $post['banner_image']['image']; ?>" class="img-fluid" />
		<div class="body-content"><?php echo $post['body']; ?></div>
	</div>
</section>
<?php if($getother->num_rows() > 0){ ?>
<section id="OtherStories" class="stories">
	<div class="container">
		<div class="list-stories row">
			<hr />
			<h3 class="text-center col-12">REKOMENDASI CERITA LAINNYA</h3>
			<?php foreach ($getother->result() as $other): ?>
				<div class="col-md-4">
					<a href="{{ url:site }}cerita/<?php echo $other->slug; ?>" class="story">
						<div class="img lazy" data-src="<?php echo $other->banner_image; ?>"></div>
						<h4><?php echo $other->title; ?></h4>
						<p><?php echo $other->lead_text; ?></p>
						<div class="link text-main-color font-weight-bold">Baca Selengkapnya</div>						
					</a>
				</div>
			<?php endforeach ?>
			
		</div>
	</div>
</section>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('header').addClass('always-black');
		$('.body-content p').each(function(index, el) {
			if($(this).children('iframe').length > 0){
				$(this).addClass('embed-container');
			}
		});
	});
</script>


