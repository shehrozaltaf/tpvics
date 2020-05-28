<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome <?php //echo $this->ion_auth->user()->row()->first_name; ?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="index.php/auth/logout"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
  </ul>
</div>