<section>
    <div class="container">
	 <div class="row">

		<div class="col-12">
			<h1 class="main_h1">  About page  - basics of Codeigniter 4 </h1>
		</div>	



		<!-- bootstrap formated part - column 12 then divided into 9 and 3 for side nav   -->
		
			<div class="col-9">
				<p>In this project we will focus on introduction abilities of CodeIgniter 4.</p>

				<p>Our pages will use all available abilities of this lightweight framework. For further reading please visit 
					main project page <a href="https://codeigniter.com/docs"> CodeIgniter project here </a>
				</p>

				<div class="gallery">
 
				<?php  
				/*****************
				 *  jQuery image gallery - https://makitweb.com/make-photo-gallery-from-image-directory-with-php/, 22.5.2021
				 */
				// Image extensions
				$image_extensions = array("png","jpg","jpeg","gif");

				// Target directory
				$dir = 'gallery/1_about_gallery';
				if (is_dir($dir)){

				if ($dh = opendir($dir)){
				$count = 1;

				// Read files
				while (($file = readdir($dh)) !== false){

					if($file != '' && $file != '.' && $file != '..'){

					// Thumbnail image path
					$thumbnail_path = "gallery/1_about_gallery/thumbs/".$file;
					/* Thumbs must be naled as their reference images */

					// Image path
					$image_path = "gallery/1_about_gallery/".$file;

					$thumbnail_ext = pathinfo($thumbnail_path, PATHINFO_EXTENSION);
					$image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

					// Check its not folder and it is image file
					if(!is_dir($image_path) && 
						in_array($thumbnail_ext,$image_extensions) && 
						in_array($image_ext,$image_extensions)){
				?>

					<!-- Image -->
					<a href="<?php echo $image_path; ?>">
					<img src="<?php echo $thumbnail_path; ?>" alt="" title=""/>
					
					</a>
					<!-- --- -->
					<?php

					// Break
					if( $count%4 == 0){
					?>
						<div class="clear"></div>
					<?php 
					}
					$count++;
					}
					}

				}
				closedir($dh);
				}
				}
				?>
				</div>


				<!-- Display last 3 article - reworked along news part -->
				<h1 class="main_h1">Latest news</h1>

					<?php if (! empty($news) && is_array($news)) : ?>

						<?php foreach ($news as $news_item): ?>
						<div class="article_header_about">
							<h3><?= esc($news_item['title']) ?></h3>
						</div>
						<div class="article_body_about">
							<table>
								<tr>
								<?php if (!empty($news_item['picture_name'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
										<td>
											<div id="article_image" class="article_image">
												<img src="<?=base_url()?>/images/<?= esc($news_item['picture_name']) ?>" alt="Article image - <?= esc($news_item['title']) ?> " width="250px" >
											</div>
										</td>
									<?php endif ?>  
									<td id="left_news_article_about"> 
										<div id="body_text" class="main">
											<?= esc($news_item['body']) ?>
										</div>
									</td>
								</tr>
							</table>
							<!-- old version <p><a href="/news/<?= esc($news_item['slug'], 'url') ?>">View article</a></p>  without base url -->
							<div id="article_hyperlink" class="article_hyperlink">
								<p><a class="news_article_hyperlink" href="<?php echo base_url('news') ; ?><?php echo "/" ; ?><?= esc($news_item['slug'], 'url') ?>">View article 
								<br /> &nbsp; &nbsp; &nbsp;
								<?php echo base_url('news'); ?><?php echo "/" ; ?><?= esc($news_item['slug'], 'url') ?> </a></p>
							</div>
						</div>   
							
							
							<hr> <br />
						<?php endforeach; ?>
					<?php endif ?>	

			</div>

			<div class="col-3">
				<?php if (session()->get('isLoggedIn')): ?> 
				<h2>Private zone</h2>
				<ul class="nav flex-column">  <!-- bootstrap styling https://getbootstrap.com/docs/5.0/components/navs-tabs/ -->
					
					<li class="menu-item hidden"><a href="<?php echo base_url('users/profile') ; ?>">Update profile</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('users/logout') ; ?>">Logout</a></li>
				</ul>
				</br></br>
				<?php endif; ?> 
				<h2>Menu options</h2>
					<ul class="nav flex-column">
					
					<!-- base_url inserts part defined in .env config file consists of main url part that can be easy chenged along hosting migration -->
					<li class="menu-item hidden"><a href="<?php echo base_url('about') ; ?>">About</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('news') ; ?>">News</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('guestbook') ; ?>">Guestbook</a></li>
					<li class="menu-item hidden"><a href="https://codeigniter4.github.io/userguide/" target="_blank">Docs</a>
					</li>
					<li class="menu-item hidden"><a href="https://forum.codeigniter.com/" target="_blank">Community</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('contactus') ; ?>">Contact us</a></li>
					
					</ul>
				</div>
	     
	  </div>
    </div>


<!-- section and further class from original CodeIgniter 4 demo styling of document  -->
</section>

<div class="further">

	<section>

		<h1>Go further -  this part has been extracted from demo page of CodeIgniter 4 - striped into a header, footer and part of a appropriate page.</h1>

        <p> In our project we focus on demonstration how to create controllers responsible for appropriate page requests. How to add route for providing 
            way to access our pages. Content of pages is created by views located in /app/Views folder. Dynamic page content and data persistency demonstrate
            use of models responsible for storing data into a database.
        </p>
        <p>
            CodeIgniter 4 is a lightweigt php based framework  utilizing pattern of MVC for project organization. For me it is a entry in real OOP web design
            with support of MVC design. For first introduction of MVC patern please look at this youtube video 
            <a href="https://www.youtube.com/watch?v=pCvZtjoRq1I&list=PLHErGRowCawU_4e_Xn6EtWypZDpaY_lVy&index=3">What Is MVC? Simple Explanation. </a>
            Another great series explaining basic concepts of work with this framework is 
            <a href="https://www.youtube.com/watch?v=h_wBwi4u2pI&list=PLYogo31AXFBNi757lPJGD98d6pFq8bDnd&index=1"> here - CodeIgniter 4 from Scratch - #1 - Introduction. </a>
        </p>

		<h2>
			<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><rect x='32' y='96' width='64' height='368' rx='16' ry='16' style='fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px'/><line x1='112' y1='224' x2='240' y2='224' style='fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/><line x1='112' y1='400' x2='240' y2='400' style='fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/><rect x='112' y='160' width='128' height='304' rx='16' ry='16' style='fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px'/><rect x='256' y='48' width='96' height='416' rx='16' ry='16' style='fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px'/><path d='M422.46,96.11l-40.4,4.25c-11.12,1.17-19.18,11.57-17.93,23.1l34.92,321.59c1.26,11.53,11.37,20,22.49,18.84l40.4-4.25c11.12-1.17,19.18-11.57,17.93-23.1L445,115C443.69,103.42,433.58,94.94,422.46,96.11Z' style='fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px'/></svg>
			Learn
		</h2>

		<p>The User Guide contains an introduction, tutorial, a number of "how to"
			guides, and then reference documentation for the components that make up
			the framework. Check the <a href="https://codeigniter4.github.io/userguide"
			target="_blank">User Guide</a> !</p>

		<h2>
			<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M431,320.6c-1-3.6,1.2-8.6,3.3-12.2a33.68,33.68,0,0,1,2.1-3.1A162,162,0,0,0,464,215c.3-92.2-77.5-167-173.7-167C206.4,48,136.4,105.1,120,180.9a160.7,160.7,0,0,0-3.7,34.2c0,92.3,74.8,169.1,171,169.1,15.3,0,35.9-4.6,47.2-7.7s22.5-7.2,25.4-8.3a26.44,26.44,0,0,1,9.3-1.7,26,26,0,0,1,10.1,2L436,388.6a13.52,13.52,0,0,0,3.9,1,8,8,0,0,0,8-8,12.85,12.85,0,0,0-.5-2.7Z' style='fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px'/><path d='M66.46,232a146.23,146.23,0,0,0,6.39,152.67c2.31,3.49,3.61,6.19,3.21,8s-11.93,61.87-11.93,61.87a8,8,0,0,0,2.71,7.68A8.17,8.17,0,0,0,72,464a7.26,7.26,0,0,0,2.91-.6l56.21-22a15.7,15.7,0,0,1,12,.2c18.94,7.38,39.88,12,60.83,12A159.21,159.21,0,0,0,284,432.11' style='fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px'/></svg>
			Discuss
		</h2>

		<p>CodeIgniter is a community-developed open source project, with several
			 venues for the community members to gather and exchange ideas. View all
			 the threads on <a href="https://forum.codeigniter.com/"
			 target="_blank">CodeIgniter's forum</a>, or <a href="https://codeigniterchat.slack.com/"
			 target="_blank">chat on Slack</a> !</p>

		<h2>
			 <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><line x1='176' y1='48' x2='336' y2='48' style='fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px'/><line x1='118' y1='304' x2='394' y2='304' style='fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px'/><path d='M208,48v93.48a64.09,64.09,0,0,1-9.88,34.18L73.21,373.49C48.4,412.78,76.63,464,123.08,464H388.92c46.45,0,74.68-51.22,49.87-90.51L313.87,175.66A64.09,64.09,0,0,1,304,141.48V48' style='fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px'/></svg>
			 Contribute
		</h2>

		<p>CodeIgniter is a community driven project and accepts contributions
			 of code and documentation from the community. Why not
			 <a href="https://codeigniter.com/en/contribute" target="_blank">
			 join us</a> ?</p>

	</section>

</div>