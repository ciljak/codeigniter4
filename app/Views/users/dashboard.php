<section>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h1>Hello, <?= session()->get('firstname') ?></h1>
    </div>
    <div class="col-9">
      <p>Example of after login page (dashboard) for authorized users.</p>
      <p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Nulla porttitor accumsan tincidunt. Vivamus magna justo, 
        lacinia eget consectetur sed, convallis at tellus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
        Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Praesent sapien massa, convallis a pellentesque nec, 
        egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>

        <p> Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. 
        Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec rutrum congue leo eget malesuada. Praesent sapien massa, convallis a 
        nec, egestas non nisi. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.</p>

        <p> Pellentesque in ipsum id orci porta dapibus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; 
        Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Nulla porttitor accumsan tincidunt. 
        Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, 
        ullamcorper sit amet ligula. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Pellentesque in ipsum id orci porta dapibus.</p>
    </div>
    <div class="col-3">
      <h2>Private zone</h2>
       <ul class="nav flex-column">  <!-- bootstrap styling https://getbootstrap.com/docs/5.0/components/navs-tabs/ -->
          
          <li class="menu-item hidden"><a href="<?php echo base_url('users/profile') ; ?>">Update profile</a></li>
          <li class="menu-item hidden"><a href="<?php echo base_url('users/logout') ; ?>">Logout</a></li>
      </ul>
      </br></br>
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
</section>
