<!DOCTYPE html >
<html class="app view-browse">

<?php require_once ( 'head.php' ); ?>

<body>
    <div id="app-nav" class="">
        <nav>
            <div class="items"><a href="home.php"><i class="mdi-navigation-arrow-back"></i><span class="title">Browse Vendors</a>
                </span>
            </div>
        </nav>
    </div>
    <div class="white" id="app">
<?php require_once ( 'loading.php' ); ?>
        <div class="pages">

            <div class="wrapper">



                <h4>Browse</h4>
                <p>Please select the state, county, and industry you'd like to browse. <br /> <br /></p>

                <form method="post" id="browse-vendors" name="newsearchform" action="search.php">

                    <select name="state" id="stateid" onchange="javascript:getCounties();">
                        <option value="">Select State</option>
                        <option value="Al">Alabama</option>
                        <option value="Ak">Alaska</option>
                        <option value="As">American Samoa</option>
                        <option value="Az">Arizona</option>
                        <option value="Ar">Arkansas</option>
                        <option value="Ca">California</option>
                        <option value="Co">Colorado</option>
                        <option value="Ct">Connecticut</option>
                        <option value="De">Delaware</option>
                        <option value="Dc">District of Columbia</option>
                        <option value="Fl">Florida</option>
                        <option value="Ga">Georgia</option>
                        <option value="Gu">Guam</option>
                        <option value="Hi">Hawaii</option>
                        <option value="Id">Idaho</option>
                        <option value="Il">Illinois</option>
                        <option value="In">Indiana</option>
                        <option value="Ia">Iowa</option>
                        <option value="Ks">Kansas</option>
                        <option value="Ky">Kentucky</option>
                        <option value="La">Louisiana</option>
                        <option value="Me">Maine</option>
                        <option value="Md">Maryland</option>
                        <option value="Ma">Massachusetts</option>
                        <option value="Mi">Michigan</option>
                        <option value="Mn">Minnesota</option>
                        <option value="Ms">Mississippi</option>
                        <option value="Mo">Missouri</option>
                        <option value="Mt">Montana</option>
                        <option value="Ne">Nebraska</option>
                        <option value="Nv">Nevada</option>
                        <option value="Nh">New Hampshire</option>
                        <option value="Nj">New Jersey</option>
                        <option value="Nm">New Mexico</option>
                        <option value="Ny">New York</option>
                        <option value="Nc">North Carolina</option>
                        <option value="Nd">North Dakota</option>
                        <option value="Mp">Northern Marianas Islands</option>
                        <option value="Oh">Ohio</option>
                        <option value="Ok">Oklahoma</option>
                        <option value="Or">Oregon</option>
                        <option value="Pa">Pennsylvania</option>
                        <option value="Pr">Puerto Rico</option>
                        <option value="Ri">Rhode Island</option>
                        <option value="Sc">South Carolina</option>
                        <option value="Sd">South Dakota</option>
                        <option value="Tn">Tennessee</option>
                        <option value="Tx">Texas</option>
                        <option value="Ut">Utah</option>
                        <option value="Vt">Vermont</option>
                        <option value="Va">Virginia</option>
                        <option value="Vi">Virgin Islands</option>
                        <option value="Wa">Washington</option>
                        <option value="Wv">West Virginia</option>
                        <option value="Wi">Wisconsin</option>
                        <option value="Wy">Wyoming</option>

                    </select>

                    <select name="state" id="divcounty" onchange="">
                        <option value="">Please Select County</option>

                    </select>

                    <select name="state" id="industry">
                        <option value="">Select Industry</option>
                        <option value="18">Accountant/CPA/Bookkeeping</option>
                        <option value="23">Architects &amp; Architectural Review</option>
                        <option value="25">Attorney</option>
                        <option value="118">Audio/Video/Entertainment Systems</option>
                        <option value="122">Background &amp; Investigation Services</option>
                        <option value="27">Banking Services</option>
                        <option value="21">Bookkeeping (Non-CPA)</option>
                        <option value="43">Ceiling and Wall Systems</option>
                        <option value="126">Chimney Sweeping/Cleaning</option>
                        <option value="33">Collections &amp; Delinquencies Services</option>
                        <option value="35">Concierge Services (Doorman, Valet, Concierge)</option>
                        <option value="71">Design &amp; Furnishings - Interiors</option>
                        <option value="86">Design &amp; Furnishings - Outdoor Living</option>
                        <option value="96">Disaster Recovery Service (Water, Fire, Wind)</option>
                        <option value="38">Dock, Marina, Seawalls</option>
                        <option value="2">Electrical and Lighting</option>
                        <option value="45">Elevator (Service &amp; Repairs)</option>
                        <option value="46">Energy Management Systems</option>
                        <option value="47">Engineering (Civil,Structural,Architecture,Safety)</option>
                        <option value="48">Environmental: Rubbish &amp; Recycling Services, Equip</option>
                        <option value="50">Fencing &amp; Gates</option>
                        <option value="51">Fire Safety Engineering &amp; Equipment</option>
                        <option value="52">Flooring - Tile, Wood, Stone, Laminate, Carpet</option>
                        <option value="54">Fountain, Water Feature Service &amp; Repair</option>
                        <option value="56">General Contractors</option>
                        <option value="57">Generator &amp; Co-Generation Systems</option>
                        <option value="61">Handyman</option>
                        <option value="79">Holiday or Event Lighting Installations</option>
                        <option value="65">Hurricane &amp; Security Shutters, Awnings</option>
                        <option value="64">HVAC - Heating, Ventilation, Air Conditioning</option>
                        <option value="1">Irrigation Systems</option>
                        <option value="73">Janitorial Service</option>
                        <option value="74">Lake, Pond &amp; Wetlands Management</option>
                        <option value="75">Landscape Architect</option>
                        <option value="77">Landscape Maintenance</option>
                        <option value="22">Landscape: Tree &amp; Arborist Services</option>
                        <option value="20">Laundry, Appliances &amp; Service Equipment </option>
                        <option value="85">Metal Finishing &amp; Restoration</option>
                        <option value="84">Mold and Other Contamination Remediation</option>
                        <option value="87">Painting/Wallpaper/Staining/Waterproofing</option>
                        <option value="11">Parking &amp; Traffic Services</option>
                        <option value="12">Payroll Services</option>
                        <option value="89">Pest &amp; Animal Control</option>
                        <option value="101">Plumbing &amp; Boiler Systems</option>
                        <option value="92">Pool Cleaning &amp; Maintenance</option>
                        <option value="93">Pool Installation, Repair &amp; Restoration</option>
                        <option value="94">Pressure-Power-Steam Cleaning</option>
                        <option value="119">Railing Systems, Including ADA</option>
                        <option value="97">Recreation (Spa, Gym, Playground Systems)</option>
                        <option value="99">Reserve Studies, Appraisals</option>
                        <option value="100">Roadway/Driveway/Walkway - Asphalt/Concrete/Pavers</option>
                        <option value="102">Roofing</option>
                        <option value="124">Roofing Consultants</option>
                        <option value="104">Security Systems: Products &amp; Services</option>
                        <option value="105">Signage, Locksmith, &amp; Mailbox Systems</option>
                        <option value="4">Sports Courts and Fields (Tennis, Bocce, Handball)</option>
                        <option value="6">Street Sweeping &amp; Snow Removal</option>
                        <option value="8">Structural Concrete, Steel, Shear, Curtainwall</option>
                        <option value="107">Telephone Systems/Telecommunications</option>
                        <option value="41">Utility Audits, Cost Eng, Cable Negotiation</option>
                        <option value="112">Utility Feeds (Repair &amp; Replacement)</option>
                        <option value="72">Website, Internet, Computer, Network Services</option>
                        <option value="32">Window Cleaning</option>
                        <option value="116">Window Tint, Safety &amp; Security Films</option>
                        <option value="115">Windows &amp; Doors</option>
                    </select>

                    <input type="submit" value="Browse" class="button large block">

                </form>






            </div>



            <div class="overlay">
                <div class="overlay-click"></div>
                <div class="popup panel browse-incomplete-fields no-borders">
					<p class="item">You have not completed all fields. Please select a state, county, and industry.</p>
					<div class="popup-buttons item"><a class="cancel close-overlay">Close</a></div>
				</div>
            </div>

        </div>

        <script type="text/javascript" src="/assets/js/app.js"></script>
        <script type="text/javascript" src="/assets/js/app/main.js"></script>
</body>

</html>