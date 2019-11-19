<section id="StoriesBanner" class="banner-default">
	<div class="container">
		<!-- <div class="label text-light text-uppercase">cerita</div> -->
		<h2 class="text-light">TENTANG PASSION<br /> DAN EKSPLORASI</h2>
	</div>
</section>
<section id="StoriesList" class="stories">
	<div class="container">
		{{ if posts }}
			<div class="list-stories row">
				{{ posts }}
					<div class="col-md-4">
						<a href="{{ url:site }}cerita/{{ slug }}" class="story">
							<div class="img lazy" data-src="{{ banner_image:image }}"></div>
							<h4>{{ title }}</h4>
							<p>{{ lead_text }}</p>
							<div class="link text-main-color font-weight-bold">Baca Selengkapnya</div>						
						</a>
					</div>
				{{ /posts }}
			</div>
			{{ pagination }}
		{{ else }}
			<div class="text-center text-main-color">TIDAK ADA CERITA YANG DITEMUKAN</div>
		{{ endif }}	
	</div>
</section>