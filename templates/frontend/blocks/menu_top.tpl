


<div id="top_menu_button" class="menu_button" onclick="ShowTopMenu()">
	<span></span>
	<span></span>
	<span></span>
</div>
<ul id="top_menu" class="menu_top">
	<li>
		<form action="{SITE_URL}/article/search_question" method="POST" id="seachForm">
			  Search: <input type="text" name="search" placeholder="Search on this site...">
	  					 <input type="submit" value="Search">
		</form>
	</li>
	<li class="{SEL_PAGE_HOME}{SEL_PAGE_ABOUT}{SEL_PAGE_WHO-WE-ARE}">
		<a href="{SITE_URL}">Home</a>
	</li> 
	<!-- BEGIN top_menu_not_logged -->
	<li class="{SEL_USER_LOGIN}">
		<a href="{SITE_URL}/user/login">Log In</a>
	</li>
	<li class="{SEL_USER_REGISTER}">
		<a href="{SITE_URL}/user/register">Register</a>
	</li>
	<!-- END top_menu_not_logged -->
	<!-- BEGIN top_menu_logged -->
	<li >
		<a href="{SITE_URL}/user/account">{USER_USERNAME}</a>
	</li>
	<li >
		<a href="{SITE_URL}/article/add_question">Add question</a>
	</li>
	<li>
		<a href="{SITE_URL}/user/logout">Log Out</a>
	</li>
	<!-- END top_menu_logged -->
</ul>
