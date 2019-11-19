<section id="StoryDetail">
	<div class="container">
		<?php print_r($post['title']); ?>
		<div class="label text-center"><?php echo $category; ?></div>
		<h2 class="text-center"><?php echo $post['title']; ?></h2>
		<img src="<?php echo $post['banner_image']['image']; ?>" class="img-fluid" />
		<div class="body-content"><?php echo $post['body']; ?></div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function() {
		$('header').addClass('always-black');
	});
</script>


