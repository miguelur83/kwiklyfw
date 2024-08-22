<?php include("inc/head.php"); ?>
<?php
    $template_class = "inner"; 
    include("inc/header.php"); 
?>
        <?php include("inc/navigation.php"); ?>
        <div id="content">
            <div id="content_body" class="map_info">
                <p id="page_title" class="map_info">Map Info</p>
                <p class="left_column" id="instructions">
                    Hover over the states on the map to show our distributors 
                    information.         
                </p>
                <p class="left_column" id="tennessee_link_info">
                    <strong>Delirium Wine and Spirits, Inc</strong><br />
                    2901 Armory Drive Suite 105<br />
                    Nashville, TN 37204<br />
                    <a href="tel:6152550100">(615) 255-0100</a><br />
                    Stan Dibin         
                </p>
                <p class="left_column" id="georgia_link_info">
                    <strong>Big Boat Wine Co.</strong><br />
                    6215 Regency Parkway<br />
                    Suite 910<br />
                    Norcross, GA 30071<br />
                    <a href="tel:7702426244">(770) 242-6244</a><br />
                    Lisa Allen         
                </p>
                <p class="left_column" id="michigan_link_info">
                    <strong>Reali Distributors</strong> <br />
                    23501 Lakepointe Drive<br />
                    Clinton Township, MI 48036<br />
                    <a href="tel:5864639463">(586) 463-9463</a><br />      
                    Andrea Taravella<br />
                </p>
                <p class="left_column" id="florida_link_info"> 
                    <span class="right_column">
                      <strong>Classical Wine Distributors</strong><br />
                      2421 Silver Meteor Drive<br />
                      Orlando, FL 32904<br />
                      <a href="tel:4074281095">(407) 428-1095</a><br />
                      Kevin Quijano<br /><br /> 
					  
                      <strong>Global Wines LLC</strong><br />
                      1340 Stirling Rd., #6B, <br />
                      Dania Beach, FL 33004<br />
                      <a href="tel:9549218024">(954) 921-8024</a><br />
                      <a href="mailto:info@globalwinesllc.com">info@globalwinesllc.com</a><br />      
                    </span>
                    <strong>Gallery Wines</strong><br />
                    8240 NW South River Drive<br />
                    Medley, FL 33166<br />
                    <a href="tel:7862314717">(786) 231-4717</a><br />
                    Horacio Jasin
                    <br /><br />          
                    <strong>Vini D'Italia</strong><br />
                    7258 North Miami Avenue<br />
                    Miami, FL 33138<br />
                    <a href="tel:3057599880">(305) 759-9880</a><br />
                    Gianfranco Strazzacappa   
                </p>
                <p class="left_column" id="caribe_link_info">
                    <strong>Graceway Trading LTD</strong><br />
                    Leeward Highway<br />
                    Providenciales,<br />
                    Turks & Caicos Islands,<br />
                    British West Indies<br />
                    <a href="tel:6499415000">(649) 941-5000</a><br />
                    Tina Williford
                </p>
                <p class="left_column" id="puertorico_link_info">
                    <strong>Aficionado Wine and Spirits</strong><br />
                    STE. 102 39 Frances Street<br />
                    Amelia Industrial Park<br />
                    Guaynabo, PR 00926<br />
                    <a href="tel:7875644469">(787) 564-4469</a><br />
                    Richard Paredes
                </p>
                <p class="left_column" id="northcarolina_link_info">
                    <strong>Choice Specialty Wines</strong><br />
                    432 Landmark Drive Suite 1<br />
                    Wilmington, NC 28412<br />
                    <a href="tel:9107941337">(910) 794-1337</a><br />
                    Barry Weiss
                </p>
                <p class="left_column" id="dc_link_info">
                    <strong>Lanterna Distributors</strong><br />
                    2 E Wells Street, Suite 1<br />
                    Baltimore, MD 21230<br />
                    <a href="tel:8778909020">(877) 890-9020</a><br />
                    Jeff Sarfino<br />
                    <a href="mailto:info@lanternawines.com">info@lanternawines.com</a>
                </p>
            </div>
            <img id="page_image" class="map_image" src="images/mapa3.jpg" usemap="#distributors_map" alt="distributors map" /> 
            <map id="distributors_map" name="distributors_map">
                <area shape="poly" coords="255,48,247,61,250,85,275,86,275,64," href="#" alt="Michigan" title="Michigan" id="michigan_link" class="state_link" />
                <area shape="poly" coords="234,131,228,146,268,144,286,127," href="#" alt="Tennessee" title="Tennessee" id="tennessee_link" class="state_link" />
                <area shape="poly" coords="269,178,262,144,276,140,298,164,296,175," href="#" alt="Georgia" title="Georgia" id="georgia_link" class="state_link" />
                <area shape="poly" coords="251,178,296,174,314,209,307,225,291,204,281,185,270,190,252,186," href="#" alt="Florida" title="Florida" id="florida_link" class="state_link" />
                <area shape="poly" coords="354,249,357,268,381,267,374,249," href="#" alt="Caribe" title="Caribe" id="caribe_link" class="state_link" />
                <area shape="poly" coords="407,273,406,284,422,285,422,274," href="#" alt="Puerto Rico" title="Puerto Rico" id="puertorico_link" class="state_link" />
                <area shape="poly" coords="268,142,284,126,330,118,323,137,311,148,293,139,293,139,278,140" href="#" alt="North Carolina" title="North Carolina" id="northcarolina_link" class="state_link" />
                <area shape="poly" coords="325,119,329,99,323,90,307,98," href="#" alt="DC, Maryland and Delaware" title="DC, Maryland and Delaware"  id="dc_link" class="state_link"  />
            </map>
        </div>
    </div>
</body>
<?php include("inc/footer.php"); ?>