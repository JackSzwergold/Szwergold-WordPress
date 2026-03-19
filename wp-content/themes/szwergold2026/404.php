<?php
	get_header();
?>
<!-- Content Core BEGIN -->
<div class="container m-0 p-0">
	<div class="row m-0 p-0">
		<div class="col col-12 col-lg-9 m-0 p-0 mb-3">

			<header class="p-0 m-0">
				<div class="p-0 m-0 mx-3">
					<div class="container m-0 p-0 pb-2 mb-2 border-bottom border-dark">	
						<div class="h1 p-0 m-0 fw-bold">404: Not Found</div>
					</div>
				</div>
			</header>

			<main class="p-0 m-0">
				<div class="p-0 m-0 mx-3">

					<p>I'm sorry. You've come to the wrong page by accident or there is a misconfigured link on the site.</p>

					<p>Check the address bar for an typo. If there isn't one, please come in <a href="/" class="text-dark">the front door</a>.</p>

					<p>Or you can try using the search function:</p> 

					<!-- Search Stuff BEGIN -->
					<form action="/" method="get" class="col col-12 col-lg-6 mb-3">
						<div class="input-group">
							<div class="input-group-append">
								<button class="input-group-text user-select-none btn btn-dark btn-md rounded-end-0" type="submit" title="Search">
									<em class="fa fa-search text-white"></em>
								</button>
							</div>
							<input type="text" class="form-control border-dark" name="s" id="s" value="">
						</div>
						<input type="submit" class="d-none" value="" id="search">
					</form>
					<!-- Search Stuff END -->

				</div>
			</main>

		</div>
		<div class="col col-12 col-lg-3 ms-auto m-0 p-0">
			<?php
				get_sidebar();
			?>
		</div>
	</div>
</div>
<!-- Content Core END -->
<?php
	get_footer();
?>