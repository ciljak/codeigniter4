<section>
<div class="row">
    <div class="col-9">
        <h1 class="main_h1">Project milestones</h1>
        <ul>
            <li>CodeIgniter 4 - basic concepts - v 0.1</li>
            <li>CodeIgniter 4 - basic concepts - v 0.2</li>
            <li>CodeIgniter 4 - basic concepts - v 0.3 - news section</li>
            <li>CodeIgniter 4 - basic concepts - v 0.4 - files and images</li>
            <li>CodeIgniter 4 - basic concepts - v 0.5 - guestbook work in progress</li>
            <li>CodeIgniter 4 - basic concepts - v 0.5.2 - guestbook rewoked</li>
            <li>CodeIgniter 4 - basic concepts - v 0.6 - contact us</li>
            <li>CodeIgniter 4 - basic concepts - v 0.7 - login and section for users</li>
            <li>CodeIgniter 4 - basic concepts - v 0.8 - bootstrap forms and backend</li>
            <li>CodeIgniter 4 - basic concepts - v 0.9 - pagination</li>
            <li>CodeIgniter 4 - basic concepts - v 0.9.1 - user roles and ids</li>
        </ul>
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

				<h2>About project</h2>	

					<ul class="nav flex-column">
					   <li class="menu-item hidden"><a href="<?php echo base_url('project_milestones') ; ?>">Project milestones</a></li>
				    </ul>
    </div>
 </div>
</section>