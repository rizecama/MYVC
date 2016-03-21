<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" class="app view-vendor">

    <?php require_once ( 'head.php' ); ?>
    
	<body>
	<div id="app-nav">
		<nav>
			<div class="items"><a href="list.php"><i class="mdi-navigation-arrow-back"></i><span class="title">Vendor Details</span></a><a class="right vendor-list-help" href=""><i class="mdi-action-help"></i></a></a><a class="right save-vendor" href=""><i class="mdi-action-grade"></i></a></div>
		</nav>
	</div>
		<div class="white" id="app">
<?php require_once ( 'loading.php' ); ?>
			<div class="no-wrapper">
				<div class="">

					<div class="panel vendor-lists">
						<h2 class="no-arrow">Green Group Studio</h2>
						<div class="item">
							<p class="bottom-line"><img class="logo" src="http://www.greengroupstudio.com/web-design-company.png" /></p>	
							<p>8461 Lake Worth Road<br>
							Lake Worth, FL 33467</p>
							<p><b>Contact person:</b> Clara Mateus</p>
							<p><b>Company Phone:</b> <a href="tel:561-439-5345">561-439-5345</a><br>
							<b>Alternate Phone:</b> <br>
							<b>Cell Phone: </b><a href="tel:954-649-2536">954-649-2536</a></p>
							<p><b>Email:</b> <a href="mailto:cmateus@greengroupstudio.com">cmateus@greengroupstudio.com</a></p>
							<p><b>Website:</b> <a href="http://greengroupstudio.com/" target="_blank">greengroupstudio.com</a></p>

							
							<p class="bottom-line"><span class="status verified">Verified</span> / <span class="status partial">Compliant & Noncompliant</span></p>

							<h1>Industries Served</h1>
							<ul class="bottom-line">
								<li>Audio/Video/Entertainment Systems</li>
								<li>Design & Furnishings - Interiors</li>
								<li>Design & Furnishings - Outdoor Living</li>
								<li>Pool Installation, Repair & Restoration</li>
								<li>Security Systems: Products & Services</li>
								<li>Website, Internet, Computer, Network Services</li>
							</ul>

							<h1>Vendor Rating</h1>
							<p><img src="https://myvendorcenter.com/components/com_camassistant/assets/images/rating/vendorrating/45.png"></p>
							<p>4.5 out of 5</p>
						</div>
					</div>


				</div>
			</div>




			<div class="overlay">
				<div class="overlay-click"></div>
				<div class="popup panel save-vendor no-borders">
					<p class="item">Would you like to mark this vendor as a Preferred Vendor?</p>
					<div class="popup-buttons item"><a class="cancel close-overlay">Yes</a><a class="close-overlay">No</a></div>
				</div>
				<div class="popup panel vendor-list-help no-borders">
					<p class="item"><span style="color:green;font-weight:bold;">Compliant</span> - Stuff
                    <br>
                    <span style="color:red;font-weight:bold;">Noncompliant</span> - Things
                    <br>
                    <span style="color:orange;font-weight:bold;">Compiant and Noncompliant</span> - Stuff and things
                    <br>
                    <span style="font-weight:bold;">Not Available</span> - No clue
                    <br>
                    <br>
                    <span style="font-weight:bold;">Verified</span> - All good
                    <br>
                    <span style="font-weight:bold;">Unverified</span> - No good </p>
                <div class="popup-buttons item"><a class="cancel close-overlay">Close</a>
                </div>
				</div>
			</div>

		</div>

		<script type="text/javascript" src="/assets/js/app.js"></script>
		<script type="text/javascript" src="/assets/js/app/main.js"></script>	</body>
</html>