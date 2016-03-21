<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" class="app view-home">

    <?php require_once ( 'head.php' ); ?>
    
	<body>
	<div id="app-nav">
		<nav>
			<div class="items"><a><i class="mdi-navigation-menu hide"></i><span class="title">My Vendor Center</span></a><a class="right temp-dots" href=""><i class="mdi-navigation-more-vert"></i></a></div>

		</nav>
	</div>
		<div class="white" id="app">
<?php require_once ( 'loading.php' ); ?>
			<div class="wrapper">
				<div class="">

					<div class="panel">
						<a class="button transparent half" href="mailto:?subject=You should try MyVendorCenter!&body=Because it's awesome!">Invite Vendor</a>
						<a class="button transparent half action-sign-out">Sign Out</a>
					</div>
					<div class="panel ">
						
						<form class="search-w-button" action="search.php">
							<input class="searchbar" name="companyname" type="text" placeholder="Search vendors..."><input class="search-button" type="submit" value="Go">
						</form>
						<a class="button transparent inline bottom-of-panel" href="browse.php"> or browse by industry</a>
					</div>

					<div class="panel">
						<h2 class="icon-people">My Vendor Lists</h2>
						<div class="vendor-lists">
							<a href="list.php#tab/1" class="item">My Vendors <span>0</span></a>
							<a href="list.php#tab/2" class="item">Corporate Preferred <span>0</span></a>
							<a href="list.php#tab/3" class="item">Co-workers' <span>0</span></a>
						</div>
					</div>

					<div class="panel">
						<a class="button transparent half" onclick="updateLocalVendorDB('lists.json');updatePage();">Refresh Lists</a>
						<a class="button transparent half" href="mailto:support@myvendorcenter.com?subject=Help, my thing broke&body=My reasons for my incompentence are below: 
						">Email Support</a>
					</div>


				</div>
			</div>

			<div class="overlay">
				<div class="overlay-click"></div>
				<div class="popup panel temp-dots no-borders">
					<p class="item">This doesn't do anything. Don't click it.</p>
					<div class="popup-buttons item"><a class="cancel close-overlay">Okay Xander</a><a class="">No</a></div>
				</div>
                <div class="popup panel action-sign-out no-borders">
					<p class="item">Are you sure you want to sign out?</p>
					<div class="popup-buttons item"><a class="cancel close-overlay" href="index.php">Yes</a><a class="close-overlay">No</a></div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/assets/js/app.js"></script>
		<script type="text/javascript" src="/assets/js/app/main.js"></script>
	</body>
</html>