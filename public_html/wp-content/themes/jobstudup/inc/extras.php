<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 *
 * @package WorkScout
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function workscout_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'workscout_body_classes' );

add_filter('job_filter_tag_cloud','set_tag_cloud_sizes');
function set_tag_cloud_sizes($args) {
    $args['smallest'] = 14;
    $args['largest'] = 14;
    $args['unit'] = 'px';
    return $args; 
}
/**
 * Customize the PageNavi HTML before it is output
 */
add_filter( 'wp_pagenavi', 'workscout_pagination', 10, 2 );
function workscout_pagination($html) {
    $out = '';
    //wrap a's and span's in li's
    $out = str_replace("<a","<li><a",$html);
    $out = str_replace("</a>","</a></li>",$out);
    $out = str_replace("<span","<li><span",$out);
    $out = str_replace("</span>","</span></li>",$out);
    $out = str_replace("<div class='wp-pagenavi'>","",$out);
    $out = str_replace("</div>","",$out);
    return '<div class="pagination"><ul>'.$out.'</ul></div>';
}

function workscout_custom_archive_title( $title ) {
    if (function_exists('is_shop')) :
        if(is_shop()){
            return preg_replace( '#^[\w\d\s]+:\s*#', '', strip_tags( $title ) );
        }
    else 
        return $title;
    endif;

}
add_filter( 'get_the_archive_title', 'workscout_custom_archive_title' );

/**
 * Customize the excerpt off all posts to replace the [...]
 */
function workscout_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'workscout_excerpt_more');


/**
 * @param  $length
 * @return length of excerpt
 */
function workscout_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'workscout_excerpt_length', 999 );

/**
 *  Returns column class from skeleton
 *  @param  $width
 *  @return string
 */

if (!function_exists('workscout_number_to_width')) :
function workscout_number_to_width($width) {
    switch ($width) {
        case '1':
        return "one";
        break;
        case '2':
        return "two";
        break;
        case '3':
        return "three";
        break;
        case '4':
        return "four";
        break;
        case '5':
        return "five";
        break;
        case '6':
        return "six";
        break;
        case '7':
        return "seven";
        break;
        case '8':
        return "eight";
        break;
        case '9':
        return "nine";
        break;
        case '10':
        return "ten";
        break;
        case '11':
        return "eleven";
        break;
        case '12':
        return "twelve";
        break;
        case '13':
        return "thirteen";
        break;
        case '14':
        return "fourteen";
        break;
        case '15':
        return "fifteen";
        break;
        case '16':
        return "sixteen";
        break;
        case '1/3':
        return "one-third";
        break;        
        case '2/3':
        return "two-thirds";
        break;
        default:
        return "thirteen";
        break;
    }
}
endif;

function workscout_line_icons_list(){
    $icons = array('icon-A-Z','icon-Aa','icon-Add-Bag','icon-Add-Basket','icon-Add-Cart','icon-Add-File','icon-Add-SpaceAfterParagraph','icon-Add-SpaceBeforeParagraph','icon-Add-User','icon-Add-UserStar','icon-Add-Window','icon-Add','icon-Address-Book','icon-Address-Book2','icon-Administrator','icon-Aerobics-2','icon-Aerobics-3','icon-Aerobics','icon-Affiliate','icon-Aim','icon-Air-Balloon','icon-Airbrush','icon-Airship','icon-Alarm-Clock','icon-Alarm-Clock2','icon-Alarm','icon-Alien-2','icon-Alien','icon-Aligator','icon-Align-Center','icon-Align-JustifyAll','icon-Align-JustifyCenter','icon-Align-JustifyLeft','icon-Align-JustifyRight','icon-Align-Left','icon-Align-Right','icon-Alpha','icon-Ambulance','icon-AMX','icon-Anchor-2','icon-Anchor','icon-Android-Store','icon-Android','icon-Angel-Smiley','icon-Angel','icon-Angry','icon-Apple-Bite','icon-Apple-Store','icon-Apple','icon-Approved-Window','icon-Aquarius-2','icon-Aquarius','icon-Archery-2','icon-Archery','icon-Argentina','icon-Aries-2','icon-Aries','icon-Army-Key','icon-Arrow-Around','icon-Arrow-Back3','icon-Arrow-Back','icon-Arrow-Back2','icon-Arrow-Barrier','icon-Arrow-Circle','icon-Arrow-Cross','icon-Arrow-Down','icon-Arrow-Down2','icon-Arrow-Down3','icon-Arrow-DowninCircle','icon-Arrow-Fork','icon-Arrow-Forward','icon-Arrow-Forward2','icon-Arrow-From','icon-Arrow-Inside','icon-Arrow-Inside45','icon-Arrow-InsideGap','icon-Arrow-InsideGap45','icon-Arrow-Into','icon-Arrow-Join','icon-Arrow-Junction','icon-Arrow-Left','icon-Arrow-Left2','icon-Arrow-LeftinCircle','icon-Arrow-Loop','icon-Arrow-Merge','icon-Arrow-Mix','icon-Arrow-Next','icon-Arrow-OutLeft','icon-Arrow-OutRight','icon-Arrow-Outside','icon-Arrow-Outside45','icon-Arrow-OutsideGap','icon-Arrow-OutsideGap45','icon-Arrow-Over','icon-Arrow-Refresh','icon-Arrow-Refresh2','icon-Arrow-Right','icon-Arrow-Right2','icon-Arrow-RightinCircle','icon-Arrow-Shuffle','icon-Arrow-Squiggly','icon-Arrow-Through','icon-Arrow-To','icon-Arrow-TurnLeft','icon-Arrow-TurnRight','icon-Arrow-Up','icon-Arrow-Up2','icon-Arrow-Up3','icon-Arrow-UpinCircle','icon-Arrow-XLeft','icon-Arrow-XRight','icon-Ask','icon-Assistant','icon-Astronaut','icon-At-Sign','icon-ATM','icon-Atom','icon-Audio','icon-Auto-Flash','icon-Autumn','icon-Baby-Clothes','icon-Baby-Clothes2','icon-Baby-Cry','icon-Baby','icon-Back2','icon-Back-Media','icon-Back-Music','icon-Back','icon-Background','icon-Bacteria','icon-Bag-Coins','icon-Bag-Items','icon-Bag-Quantity','icon-Bag','icon-Bakelite','icon-Ballet-Shoes','icon-Balloon','icon-Banana','icon-Band-Aid','icon-Bank','icon-Bar-Chart','icon-Bar-Chart2','icon-Bar-Chart3','icon-Bar-Chart4','icon-Bar-Chart5','icon-Bar-Code','icon-Barricade-2','icon-Barricade','icon-Baseball','icon-Basket-Ball','icon-Basket-Coins','icon-Basket-Items','icon-Basket-Quantity','icon-Bat-2','icon-Bat','icon-Bathrobe','icon-Batman-Mask','icon-Battery-0','icon-Battery-25','icon-Battery-50','icon-Battery-75','icon-Battery-100','icon-Battery-Charge','icon-Bear','icon-Beard-2','icon-Beard-3','icon-Beard','icon-Bebo','icon-Bee','icon-Beer-Glass','icon-Beer','icon-Bell-2','icon-Bell','icon-Belt-2','icon-Belt-3','icon-Belt','icon-Berlin-Tower','icon-Beta','icon-Betvibes','icon-Bicycle-2','icon-Bicycle-3','icon-Bicycle','icon-Big-Bang','icon-Big-Data','icon-Bike-Helmet','icon-Bikini','icon-Bilk-Bottle2','icon-Billing','icon-Bing','icon-Binocular','icon-Bio-Hazard','icon-Biotech','icon-Bird-DeliveringLetter','icon-Bird','icon-Birthday-Cake','icon-Bisexual','icon-Bishop','icon-Bitcoin','icon-Black-Cat','icon-Blackboard','icon-Blinklist','icon-Block-Cloud','icon-Block-Window','icon-Blogger','icon-Blood','icon-Blouse','icon-Blueprint','icon-Board','icon-Bodybuilding','icon-Bold-Text','icon-Bone','icon-Bones','icon-Book','icon-Bookmark','icon-Books-2','icon-Books','icon-Boom','icon-Boot-2','icon-Boot','icon-Bottom-ToTop','icon-Bow-2','icon-Bow-3','icon-Bow-4','icon-Bow-5','icon-Bow-6','icon-Bow','icon-Bowling-2','icon-Bowling','icon-Box2','icon-Box-Close','icon-Box-Full','icon-Box-Open','icon-Box-withFolders','icon-Box','icon-Boy','icon-Bra','icon-Brain-2','icon-Brain-3','icon-Brain','icon-Brazil','icon-Bread-2','icon-Bread','icon-Bridge','icon-Brightkite','icon-Broke-Link2','icon-Broken-Link','icon-Broom','icon-Brush','icon-Bucket','icon-Bug','icon-Building','icon-Bulleted-List','icon-Bus-2','icon-Bus','icon-Business-Man','icon-Business-ManWoman','icon-Business-Mens','icon-Business-Woman','icon-Butterfly','icon-Button','icon-Cable-Car','icon-Cake','icon-Calculator-2','icon-Calculator-3','icon-Calculator','icon-Calendar-2','icon-Calendar-3','icon-Calendar-4','icon-Calendar-Clock','icon-Calendar','icon-Camel','icon-Camera-2','icon-Camera-3','icon-Camera-4','icon-Camera-5','icon-Camera-Back','icon-Camera','icon-Can-2','icon-Can','icon-Canada','icon-Cancer-2','icon-Cancer-3','icon-Cancer','icon-Candle','icon-Candy-Cane','icon-Candy','icon-Cannon','icon-Cap-2','icon-Cap-3','icon-Cap-Smiley','icon-Cap','icon-Capricorn-2','icon-Capricorn','icon-Car-2','icon-Car-3','icon-Car-Coins','icon-Car-Items','icon-Car-Wheel','icon-Car','icon-Cardigan','icon-Cardiovascular','icon-Cart-Quantity','icon-Casette-Tape','icon-Cash-Register','icon-Cash-register2','icon-Castle','icon-Cat','icon-Cathedral','icon-Cauldron','icon-CD-2','icon-CD-Cover','icon-CD','icon-Cello','icon-Celsius','icon-Chacked-Flag','icon-Chair','icon-Charger','icon-Check-2','icon-Check','icon-Checked-User','icon-Checkmate','icon-Checkout-Bag','icon-Checkout-Basket','icon-Checkout','icon-Cheese','icon-Cheetah','icon-Chef-Hat','icon-Chef-Hat2','icon-Chef','icon-Chemical-2','icon-Chemical-3','icon-Chemical-4','icon-Chemical-5','icon-Chemical','icon-Chess-Board','icon-Chess','icon-Chicken','icon-Chile','icon-Chimney','icon-China','icon-Chinese-Temple','icon-Chip','icon-Chopsticks-2','icon-Chopsticks','icon-Christmas-Ball','icon-Christmas-Bell','icon-Christmas-Candle','icon-Christmas-Hat','icon-Christmas-Sleigh','icon-Christmas-Snowman','icon-Christmas-Sock','icon-Christmas-Tree','icon-Christmas','icon-Chrome','icon-Chrysler-Building','icon-Cinema','icon-Circular-Point','icon-City-Hall','icon-Clamp','icon-Clapperboard-Close','icon-Clapperboard-Open','icon-Claps','icon-Clef','icon-Clinic','icon-Clock-2','icon-Clock-3','icon-Clock-4','icon-Clock-Back','icon-Clock-Forward','icon-Clock','icon-Close-Window','icon-Close','icon-Clothing-Store','icon-Cloud--','icon-Cloud-','icon-Cloud-Camera','icon-Cloud-Computer','icon-Cloud-Email','icon-Cloud-Hail','icon-Cloud-Laptop','icon-Cloud-Lock','icon-Cloud-Moon','icon-Cloud-Music','icon-Cloud-Picture','icon-Cloud-Rain','icon-Cloud-Remove','icon-Cloud-Secure','icon-Cloud-Settings','icon-Cloud-Smartphone','icon-Cloud-Snow','icon-Cloud-Sun','icon-Cloud-Tablet','icon-Cloud-Video','icon-Cloud-Weather','icon-Cloud','icon-Clouds-Weather','icon-Clouds','icon-Clown','icon-CMYK','icon-Coat','icon-Cocktail','icon-Coconut','icon-Code-Window','icon-Coding','icon-Coffee-2','icon-Coffee-Bean','icon-Coffee-Machine','icon-Coffee-toGo','icon-Coffee','icon-Coffin','icon-Coin','icon-Coins-2','icon-Coins-3','icon-Coins','icon-Colombia','icon-Colosseum','icon-Column-2','icon-Column-3','icon-Column','icon-Comb-2','icon-Comb','icon-Communication-Tower','icon-Communication-Tower2','icon-Compass-2','icon-Compass-3','icon-Compass-4','icon-Compass-Rose','icon-Compass','icon-Computer-2','icon-Computer-3','icon-Computer-Secure','icon-Computer','icon-Conference','icon-Confused','icon-Conservation','icon-Consulting','icon-Contrast','icon-Control-2','icon-Control','icon-Cookie-Man','icon-Cookies','icon-Cool-Guy','icon-Cool','icon-Copyright','icon-Costume','icon-Couple-Sign','icon-Cow','icon-CPU','icon-Crane','icon-Cranium','icon-Credit-Card','icon-Credit-Card2','icon-Credit-Card3','icon-Cricket','icon-Criminal','icon-Croissant','icon-Crop-2','icon-Crop-3','icon-Crown-2','icon-Crown','icon-Crying','icon-Cube-Molecule','icon-Cube-Molecule2','icon-Cupcake','icon-Cursor-Click','icon-Cursor-Click2','icon-Cursor-Move','icon-Cursor-Move2','icon-Cursor-Select','icon-Cursor','icon-D-Eyeglasses','icon-D-Eyeglasses2','icon-Dam','icon-Danemark','icon-Danger-2','icon-Danger','icon-Dashboard','icon-Data-Backup','icon-Data-Block','icon-Data-Center','icon-Data-Clock','icon-Data-Cloud','icon-Data-Compress','icon-Data-Copy','icon-Data-Download','icon-Data-Financial','icon-Data-Key','icon-Data-Lock','icon-Data-Network','icon-Data-Password','icon-Data-Power','icon-Data-Refresh','icon-Data-Save','icon-Data-Search','icon-Data-Security','icon-Data-Settings','icon-Data-Sharing','icon-Data-Shield','icon-Data-Signal','icon-Data-Storage','icon-Data-Stream','icon-Data-Transfer','icon-Data-Unlock','icon-Data-Upload','icon-Data-Yes','icon-Data','icon-David-Star','icon-Daylight','icon-Death','icon-Debian','icon-Dec','icon-Decrase-Inedit','icon-Deer-2','icon-Deer','icon-Delete-File','icon-Delete-Window','icon-Delicious','icon-Depression','icon-Deviantart','icon-Device-SyncwithCloud','icon-Diamond','icon-Dice-2','icon-Dice','icon-Digg','icon-Digital-Drawing','icon-Diigo','icon-Dinosaur','icon-Diploma-2','icon-Diploma','icon-Direction-East','icon-Direction-North','icon-Direction-South','icon-Direction-West','icon-Director','icon-Disk','icon-Dj','icon-DNA-2','icon-DNA-Helix','icon-DNA','icon-Doctor','icon-Dog','icon-Dollar-Sign','icon-Dollar-Sign2','icon-Dollar','icon-Dolphin','icon-Domino','icon-Door-Hanger','icon-Door','icon-Doplr','icon-Double-Circle','icon-Double-Tap','icon-Doughnut','icon-Dove','icon-Down-2','icon-Down-3','icon-Down-4','icon-Down','icon-Download-2','icon-Download-fromCloud','icon-Download-Window','icon-Download','icon-Downward','icon-Drag-Down','icon-Drag-Left','icon-Drag-Right','icon-Drag-Up','icon-Drag','icon-Dress','icon-Drill-2','icon-Drill','icon-Drop','icon-Dropbox','icon-Drum','icon-Dry','icon-Duck','icon-Dumbbell','icon-Duplicate-Layer','icon-Duplicate-Window','icon-DVD','icon-Eagle','icon-Ear','icon-Earphones-2','icon-Earphones','icon-Eci-Icon','icon-Edit-Map','icon-Edit','icon-Eggs','icon-Egypt','icon-Eifel-Tower','icon-eject-2','icon-Eject','icon-El-Castillo','icon-Elbow','icon-Electric-Guitar','icon-Electricity','icon-Elephant','icon-Email','icon-Embassy','icon-Empire-StateBuilding','icon-Empty-Box','icon-End2','icon-End-2','icon-End','icon-Endways','icon-Engineering','icon-Envelope-2','icon-Envelope','icon-Environmental-2','icon-Environmental-3','icon-Environmental','icon-Equalizer','icon-Eraser-2','icon-Eraser-3','icon-Eraser','icon-Error-404Window','icon-Euro-Sign','icon-Euro-Sign2','icon-Euro','icon-Evernote','icon-Evil','icon-Explode','icon-Eye-2','icon-Eye-Blind','icon-Eye-Invisible','icon-Eye-Scan','icon-Eye-Visible','icon-Eye','icon-Eyebrow-2','icon-Eyebrow-3','icon-Eyebrow','icon-Eyeglasses-Smiley','icon-Eyeglasses-Smiley2','icon-Face-Style','icon-Face-Style2','icon-Face-Style3','icon-Face-Style4','icon-Face-Style5','icon-Face-Style6','icon-Facebook-2','icon-Facebook','icon-Factory-2','icon-Factory','icon-Fahrenheit','icon-Family-Sign','icon-Fan','icon-Farmer','icon-Fashion','icon-Favorite-Window','icon-Fax','icon-Feather','icon-Feedburner','icon-Female-2','icon-Female-Sign','icon-Female','icon-File-Block','icon-File-Bookmark','icon-File-Chart','icon-File-Clipboard','icon-File-ClipboardFileText','icon-File-ClipboardTextImage','icon-File-Cloud','icon-File-Copy','icon-File-Copy2','icon-File-CSV','icon-File-Download','icon-File-Edit','icon-File-Excel','icon-File-Favorite','icon-File-Fire','icon-File-Graph','icon-File-Hide','icon-File-Horizontal','icon-File-HorizontalText','icon-File-HTML','icon-File-JPG','icon-File-Link','icon-File-Loading','icon-File-Lock','icon-File-Love','icon-File-Music','icon-File-Network','icon-File-Pictures','icon-File-Pie','icon-File-Presentation','icon-File-Refresh','icon-File-Search','icon-File-Settings','icon-File-Share','icon-File-TextImage','icon-File-Trash','icon-File-TXT','icon-File-Upload','icon-File-Video','icon-File-Word','icon-File-Zip','icon-File','icon-Files','icon-Film-Board','icon-Film-Cartridge','icon-Film-Strip','icon-Film-Video','icon-Film','icon-Filter-2','icon-Filter','icon-Financial','icon-Find-User','icon-Finger-DragFourSides','icon-Finger-DragTwoSides','icon-Finger-Print','icon-Finger','icon-Fingerprint-2','icon-Fingerprint','icon-Fire-Flame','icon-Fire-Flame2','icon-Fire-Hydrant','icon-Fire-Staion','icon-Firefox','icon-Firewall','icon-First-Aid','icon-First','icon-Fish-Food','icon-Fish','icon-Fit-To','icon-Fit-To2','icon-Five-Fingers','icon-Five-FingersDrag','icon-Five-FingersDrag2','icon-Five-FingersTouch','icon-Flag-2','icon-Flag-3','icon-Flag-4','icon-Flag-5','icon-Flag-6','icon-Flag','icon-Flamingo','icon-Flash-2','icon-Flash-Video','icon-Flash','icon-Flashlight','icon-Flask-2','icon-Flask','icon-Flick','icon-Flickr','icon-Flowerpot','icon-Fluorescent','icon-Fog-Day','icon-Fog-Night','icon-Folder-Add','icon-Folder-Archive','icon-Folder-Binder','icon-Folder-Binder2','icon-Folder-Block','icon-Folder-Bookmark','icon-Folder-Close','icon-Folder-Cloud','icon-Folder-Delete','icon-Folder-Download','icon-Folder-Edit','icon-Folder-Favorite','icon-Folder-Fire','icon-Folder-Hide','icon-Folder-Link','icon-Folder-Loading','icon-Folder-Lock','icon-Folder-Love','icon-Folder-Music','icon-Folder-Network','icon-Folder-Open','icon-Folder-Open2','icon-Folder-Organizing','icon-Folder-Pictures','icon-Folder-Refresh','icon-Folder-Remove-','icon-Folder-Search','icon-Folder-Settings','icon-Folder-Share','icon-Folder-Trash','icon-Folder-Upload','icon-Folder-Video','icon-Folder-WithDocument','icon-Folder-Zip','icon-Folder','icon-Folders','icon-Font-Color','icon-Font-Name','icon-Font-Size','icon-Font-Style','icon-Font-StyleSubscript','icon-Font-StyleSuperscript','icon-Font-Window','icon-Foot-2','icon-Foot','icon-Football-2','icon-Football','icon-Footprint-2','icon-Footprint-3','icon-Footprint','icon-Forest','icon-Fork','icon-Formspring','icon-Formula','icon-Forsquare','icon-Forward','icon-Fountain-Pen','icon-Four-Fingers','icon-Four-FingersDrag','icon-Four-FingersDrag2','icon-Four-FingersTouch','icon-Fox','icon-Frankenstein','icon-French-Fries','icon-Friendfeed','icon-Friendster','icon-Frog','icon-Fruits','icon-Fuel','icon-Full-Bag','icon-Full-Basket','icon-Full-Cart','icon-Full-Moon','icon-Full-Screen','icon-Full-Screen2','icon-Full-View','icon-Full-View2','icon-Full-ViewWindow','icon-Function','icon-Funky','icon-Funny-Bicycle','icon-Furl','icon-Gamepad-2','icon-Gamepad','icon-Gas-Pump','icon-Gaugage-2','icon-Gaugage','icon-Gay','icon-Gear-2','icon-Gear','icon-Gears-2','icon-Gears','icon-Geek-2','icon-Geek','icon-Gemini-2','icon-Gemini','icon-Genius','icon-Gentleman','icon-Geo--','icon-Geo-','icon-Geo-Close','icon-Geo-Love','icon-Geo-Number','icon-Geo-Star','icon-Geo','icon-Geo2--','icon-Geo2-','icon-Geo2-Close','icon-Geo2-Love','icon-Geo2-Number','icon-Geo2-Star','icon-Geo2','icon-Geo3--','icon-Geo3-','icon-Geo3-Close','icon-Geo3-Love','icon-Geo3-Number','icon-Geo3-Star','icon-Geo3','icon-Gey','icon-Gift-Box','icon-Giraffe','icon-Girl','icon-Glass-Water','icon-Glasses-2','icon-Glasses-3','icon-Glasses','icon-Global-Position','icon-Globe-2','icon-Globe','icon-Gloves','icon-Go-Bottom','icon-Go-Top','icon-Goggles','icon-Golf-2','icon-Golf','icon-Google-Buzz','icon-Google-Drive','icon-Google-Play','icon-Google-Plus','icon-Google','icon-Gopro','icon-Gorilla','icon-Gowalla','icon-Grave','icon-Graveyard','icon-Greece','icon-Green-Energy','icon-Green-House','icon-Guitar','icon-Gun-2','icon-Gun-3','icon-Gun','icon-Gymnastics','icon-Hair-2','icon-Hair-3','icon-Hair-4','icon-Hair','icon-Half-Moon','icon-Halloween-HalfMoon','icon-Halloween-Moon','icon-Hamburger','icon-Hammer','icon-Hand-Touch','icon-Hand-Touch2','icon-Hand-TouchSmartphone','icon-Hand','icon-Hands','icon-Handshake','icon-Hanger','icon-Happy','icon-Hat-2','icon-Hat','icon-Haunted-House','icon-HD-Video','icon-HD','icon-HDD','icon-Headphone','icon-Headphones','icon-Headset','icon-Heart-2','icon-Heart','icon-Heels-2','icon-Heels','icon-Height-Window','icon-Helicopter-2','icon-Helicopter','icon-Helix-2','icon-Hello','icon-Helmet-2','icon-Helmet-3','icon-Helmet','icon-Hipo','icon-Hipster-Glasses','icon-Hipster-Glasses2','icon-Hipster-Glasses3','icon-Hipster-Headphones','icon-Hipster-Men','icon-Hipster-Men2','icon-Hipster-Men3','icon-Hipster-Sunglasses','icon-Hipster-Sunglasses2','icon-Hipster-Sunglasses3','icon-Hokey','icon-Holly','icon-Home-2','icon-Home-3','icon-Home-4','icon-Home-5','icon-Home-Window','icon-Home','icon-Homosexual','icon-Honey','icon-Hong-Kong','icon-Hoodie','icon-Horror','icon-Horse','icon-Hospital-2','icon-Hospital','icon-Host','icon-Hot-Dog','icon-Hotel','icon-Hour','icon-Hub','icon-Humor','icon-Hurt','icon-Ice-Cream','icon-ICQ','icon-ID-2','icon-ID-3','icon-ID-Card','icon-Idea-2','icon-Idea-3','icon-Idea-4','icon-Idea-5','icon-Idea','icon-Identification-Badge','icon-ImDB','icon-Inbox-Empty','icon-Inbox-Forward','icon-Inbox-Full','icon-Inbox-Into','icon-Inbox-Out','icon-Inbox-Reply','icon-Inbox','icon-Increase-Inedit','icon-Indent-FirstLine','icon-Indent-LeftMargin','icon-Indent-RightMargin','icon-India','icon-Info-Window','icon-Information','icon-Inifity','icon-Instagram','icon-Internet-2','icon-Internet-Explorer','icon-Internet-Smiley','icon-Internet','icon-iOS-Apple','icon-Israel','icon-Italic-Text','icon-Jacket-2','icon-Jacket','icon-Jamaica','icon-Japan','icon-Japanese-Gate','icon-Jeans','icon-Jeep-2','icon-Jeep','icon-Jet','icon-Joystick','icon-Juice','icon-Jump-Rope','icon-Kangoroo','icon-Kenya','icon-Key-2','icon-Key-3','icon-Key-Lock','icon-Key','icon-Keyboard','icon-Keyboard3','icon-Keypad','icon-King-2','icon-King','icon-Kiss','icon-Knee','icon-Knife-2','icon-Knife','icon-Knight','icon-Koala','icon-Korea','icon-Lamp','icon-Landscape-2','icon-Landscape','icon-Lantern','icon-Laptop-2','icon-Laptop-3','icon-Laptop-Phone','icon-Laptop-Secure','icon-Laptop-Tablet','icon-Laptop','icon-Laser','icon-Last-FM','icon-Last','icon-Laughing','icon-Layer-1635','icon-Layer-1646','icon-Layer-Backward','icon-Layer-Forward','icon-Leafs-2','icon-Leafs','icon-Leaning-Tower','icon-Left--Right','icon-Left--Right3','icon-Left-2','icon-Left-3','icon-Left-4','icon-Left-ToRight','icon-Left','icon-Leg-2','icon-Leg','icon-Lego','icon-Lemon','icon-Len-2','icon-Len-3','icon-Len','icon-Leo-2','icon-Leo','icon-Leopard','icon-Lesbian','icon-Lesbians','icon-Letter-Close','icon-Letter-Open','icon-Letter-Sent','icon-Libra-2','icon-Libra','icon-Library-2','icon-Library','icon-Life-Jacket','icon-Life-Safer','icon-Light-Bulb','icon-Light-Bulb2','icon-Light-BulbLeaf','icon-Lighthouse','icon-Like-2','icon-Like','icon-Line-Chart','icon-Line-Chart2','icon-Line-Chart3','icon-Line-Chart4','icon-Line-Spacing','icon-Line-SpacingText','icon-Link-2','icon-Link','icon-Linkedin-2','icon-Linkedin','icon-Linux','icon-Lion','icon-Livejournal','icon-Loading-2','icon-Loading-3','icon-Loading-Window','icon-Loading','icon-Location-2','icon-Location','icon-Lock-2','icon-Lock-3','icon-Lock-User','icon-Lock-Window','icon-Lock','icon-Lollipop-2','icon-Lollipop-3','icon-Lollipop','icon-Loop','icon-Loud','icon-Loudspeaker','icon-Love-2','icon-Love-User','icon-Love-Window','icon-Love','icon-Lowercase-Text','icon-Luggafe-Front','icon-Luggage-2','icon-Macro','icon-Magic-Wand','icon-Magnet','icon-Magnifi-Glass-','icon-Magnifi-Glass','icon-Magnifi-Glass2','icon-Mail-2','icon-Mail-3','icon-Mail-Add','icon-Mail-Attachement','icon-Mail-Block','icon-Mail-Delete','icon-Mail-Favorite','icon-Mail-Forward','icon-Mail-Gallery','icon-Mail-Inbox','icon-Mail-Link','icon-Mail-Lock','icon-Mail-Love','icon-Mail-Money','icon-Mail-Open','icon-Mail-Outbox','icon-Mail-Password','icon-Mail-Photo','icon-Mail-Read','icon-Mail-Removex','icon-Mail-Reply','icon-Mail-ReplyAll','icon-Mail-Search','icon-Mail-Send','icon-Mail-Settings','icon-Mail-Unread','icon-Mail-Video','icon-Mail-withAtSign','icon-Mail-WithCursors','icon-Mail','icon-Mailbox-Empty','icon-Mailbox-Full','icon-Male-2','icon-Male-Sign','icon-Male','icon-MaleFemale','icon-Man-Sign','icon-Management','icon-Mans-Underwear','icon-Mans-Underwear2','icon-Map-Marker','icon-Map-Marker2','icon-Map-Marker3','icon-Map','icon-Map2','icon-Marker-2','icon-Marker-3','icon-Marker','icon-Martini-Glass','icon-Mask','icon-Master-Card','icon-Maximize-Window','icon-Maximize','icon-Medal-2','icon-Medal-3','icon-Medal','icon-Medical-Sign','icon-Medicine-2','icon-Medicine-3','icon-Medicine','icon-Megaphone','icon-Memory-Card','icon-Memory-Card2','icon-Memory-Card3','icon-Men','icon-Menorah','icon-Mens','icon-Metacafe','icon-Mexico','icon-Mic','icon-Microphone-2','icon-Microphone-3','icon-Microphone-4','icon-Microphone-5','icon-Microphone-6','icon-Microphone-7','icon-Microphone','icon-Microscope','icon-Milk-Bottle','icon-Mine','icon-Minimize-Maximize-Close-Window','icon-Minimize-Window','icon-Minimize','icon-Mirror','icon-Mixer','icon-Mixx','icon-Money-2','icon-Money-Bag','icon-Money-Smiley','icon-Money','icon-Monitor-2','icon-Monitor-3','icon-Monitor-4','icon-Monitor-5','icon-Monitor-Analytics','icon-Monitor-Laptop','icon-Monitor-phone','icon-Monitor-Tablet','icon-Monitor-Vertical','icon-Monitor','icon-Monitoring','icon-Monkey','icon-Monster','icon-Morocco','icon-Motorcycle','icon-Mouse-2','icon-Mouse-3','icon-Mouse-4','icon-Mouse-Pointer','icon-Mouse','icon-Moustache-Smiley','icon-Movie-Ticket','icon-Movie','icon-Mp3-File','icon-Museum','icon-Mushroom','icon-Music-Note','icon-Music-Note2','icon-Music-Note3','icon-Music-Note4','icon-Music-Player','icon-Mustache-2','icon-Mustache-3','icon-Mustache-4','icon-Mustache-5','icon-Mustache-6','icon-Mustache-7','icon-Mustache-8','icon-Mustache','icon-Mute','icon-Myspace','icon-Navigat-Start','icon-Navigate-End','icon-Navigation-LeftWindow','icon-Navigation-RightWindow','icon-Nepal','icon-Netscape','icon-Network-Window','icon-Network','icon-Neutron','icon-New-Mail','icon-New-Tab','icon-Newspaper-2','icon-Newspaper','icon-Newsvine','icon-Next2','icon-Next-3','icon-Next-Music','icon-Next','icon-No-Battery','icon-No-Drop','icon-No-Flash','icon-No-Smoking','icon-Noose','icon-Normal-Text','icon-Note','icon-Notepad-2','icon-Notepad','icon-Nuclear','icon-Numbering-List','icon-Nurse','icon-Office-Lamp','icon-Office','icon-Oil','icon-Old-Camera','icon-Old-Cassette','icon-Old-Clock','icon-Old-Radio','icon-Old-Sticky','icon-Old-Sticky2','icon-Old-Telephone','icon-Old-TV','icon-On-Air','icon-On-Off-2','icon-On-Off-3','icon-On-off','icon-One-Finger','icon-One-FingerTouch','icon-One-Window','icon-Open-Banana','icon-Open-Book','icon-Opera-House','icon-Opera','icon-Optimization','icon-Orientation-2','icon-Orientation-3','icon-Orientation','icon-Orkut','icon-Ornament','icon-Over-Time','icon-Over-Time2','icon-Owl','icon-Pac-Man','icon-Paint-Brush','icon-Paint-Bucket','icon-Paintbrush','icon-Palette','icon-Palm-Tree','icon-Panda','icon-Panorama','icon-Pantheon','icon-Pantone','icon-Pants','icon-Paper-Plane','icon-Paper','icon-Parasailing','icon-Parrot','icon-Password-2shopping','icon-Password-Field','icon-Password-shopping','icon-Password','icon-pause-2','icon-Pause','icon-Paw','icon-Pawn','icon-Paypal','icon-Pen-2','icon-Pen-3','icon-Pen-4','icon-Pen-5','icon-Pen-6','icon-Pen','icon-Pencil-Ruler','icon-Pencil','icon-Penguin','icon-Pentagon','icon-People-onCloud','icon-Pepper-withFire','icon-Pepper','icon-Petrol','icon-Petronas-Tower','icon-Philipines','icon-Phone-2','icon-Phone-3','icon-Phone-3G','icon-Phone-4G','icon-Phone-Simcard','icon-Phone-SMS','icon-Phone-Wifi','icon-Phone','icon-Photo-2','icon-Photo-3','icon-Photo-Album','icon-Photo-Album2','icon-Photo-Album3','icon-Photo','icon-Photos','icon-Physics','icon-Pi','icon-Piano','icon-Picasa','icon-Pie-Chart','icon-Pie-Chart2','icon-Pie-Chart3','icon-Pilates-2','icon-Pilates-3','icon-Pilates','icon-Pilot','icon-Pinch','icon-Ping-Pong','icon-Pinterest','icon-Pipe','icon-Pipette','icon-Piramids','icon-Pisces-2','icon-Pisces','icon-Pizza-Slice','icon-Pizza','icon-Plane-2','icon-Plane','icon-Plant','icon-Plasmid','icon-Plaster','icon-Plastic-CupPhone','icon-Plastic-CupPhone2','icon-Plate','icon-Plates','icon-Plaxo','icon-Play-Music','icon-Plug-In','icon-Plug-In2','icon-Plurk','icon-Pointer','icon-Poland','icon-Police-Man','icon-Police-Station','icon-Police-Woman','icon-Police','icon-Polo-Shirt','icon-Portrait','icon-Portugal','icon-Post-Mail','icon-Post-Mail2','icon-Post-Office','icon-Post-Sign','icon-Post-Sign2ways','icon-Posterous','icon-Pound-Sign','icon-Pound-Sign2','icon-Pound','icon-Power-2','icon-Power-3','icon-Power-Cable','icon-Power-Station','icon-Power','icon-Prater','icon-Present','icon-Presents','icon-Press','icon-Preview','icon-Previous','icon-Pricing','icon-Printer','icon-Professor','icon-Profile','icon-Project','icon-Projector-2','icon-Projector','icon-Pulse','icon-Pumpkin','icon-Punk','icon-Punker','icon-Puzzle','icon-QIK','icon-QR-Code','icon-Queen-2','icon-Queen','icon-Quill-2','icon-Quill-3','icon-Quill','icon-Quotes-2','icon-Quotes','icon-Radio','icon-Radioactive','icon-Rafting','icon-Rain-Drop','icon-Rainbow-2','icon-Rainbow','icon-Ram','icon-Razzor-Blade','icon-Receipt-2','icon-Receipt-3','icon-Receipt-4','icon-Receipt','icon-Record2','icon-Record-3','icon-Record-Music','icon-Record','icon-Recycling-2','icon-Recycling','icon-Reddit','icon-Redhat','icon-Redirect','icon-Redo','icon-Reel','icon-Refinery','icon-Refresh-Window','icon-Refresh','icon-Reload-2','icon-Reload-3','icon-Reload','icon-Remote-Controll','icon-Remote-Controll2','icon-Remove-Bag','icon-Remove-Basket','icon-Remove-Cart','icon-Remove-File','icon-Remove-User','icon-Remove-Window','icon-Remove','icon-Rename','icon-Repair','icon-Repeat-2','icon-Repeat-3','icon-Repeat-4','icon-Repeat-5','icon-Repeat-6','icon-Repeat-7','icon-Repeat','icon-Reset','icon-Resize','icon-Restore-Window','icon-Retouching','icon-Retro-Camera','icon-Retro','icon-Retweet','icon-Reverbnation','icon-Rewind','icon-RGB','icon-Ribbon-2','icon-Ribbon-3','icon-Ribbon','icon-Right-2','icon-Right-3','icon-Right-4','icon-Right-ToLeft','icon-Right','icon-Road-2','icon-Road-3','icon-Road','icon-Robot-2','icon-Robot','icon-Rock-andRoll','icon-Rocket','icon-Roller','icon-Roof','icon-Rook','icon-Rotate-Gesture','icon-Rotate-Gesture2','icon-Rotate-Gesture3','icon-Rotation-390','icon-Rotation','icon-Router-2','icon-Router','icon-RSS','icon-Ruler-2','icon-Ruler','icon-Running-Shoes','icon-Running','icon-Safari','icon-Safe-Box','icon-Safe-Box2','icon-Safety-PinClose','icon-Safety-PinOpen','icon-Sagittarus-2','icon-Sagittarus','icon-Sailing-Ship','icon-Sand-watch','icon-Sand-watch2','icon-Santa-Claus','icon-Santa-Claus2','icon-Santa-onSled','icon-Satelite-2','icon-Satelite','icon-Save-Window','icon-Save','icon-Saw','icon-Saxophone','icon-Scale','icon-Scarf','icon-Scissor','icon-Scooter-Front','icon-Scooter','icon-Scorpio-2','icon-Scorpio','icon-Scotland','icon-Screwdriver','icon-Scroll-Fast','icon-Scroll','icon-Scroller-2','icon-Scroller','icon-Sea-Dog','icon-Search-onCloud','icon-Search-People','icon-secound','icon-secound2','icon-Security-Block','icon-Security-Bug','icon-Security-Camera','icon-Security-Check','icon-Security-Settings','icon-Security-Smiley','icon-Securiy-Remove','icon-Seed','icon-Selfie','icon-Serbia','icon-Server-2','icon-Server','icon-Servers','icon-Settings-Window','icon-Sewing-Machine','icon-Sexual','icon-Share-onCloud','icon-Share-Window','icon-Share','icon-Sharethis','icon-Shark','icon-Sheep','icon-Sheriff-Badge','icon-Shield','icon-Ship-2','icon-Ship','icon-Shirt','icon-Shoes-2','icon-Shoes-3','icon-Shoes','icon-Shop-2','icon-Shop-3','icon-Shop-4','icon-Shop','icon-Shopping-Bag','icon-Shopping-Basket','icon-Shopping-Cart','icon-Short-Pants','icon-Shoutwire','icon-Shovel','icon-Shuffle-2','icon-Shuffle-3','icon-Shuffle-4','icon-Shuffle','icon-Shutter','icon-Sidebar-Window','icon-Signal','icon-Singapore','icon-Skate-Shoes','icon-Skateboard-2','icon-Skateboard','icon-Skeleton','icon-Ski','icon-Skirt','icon-Skrill','icon-Skull','icon-Skydiving','icon-Skype','icon-Sled-withGifts','icon-Sled','icon-Sleeping','icon-Sleet','icon-Slippers','icon-Smart','icon-Smartphone-2','icon-Smartphone-3','icon-Smartphone-4','icon-Smartphone-Secure','icon-Smartphone','icon-Smile','icon-Smoking-Area','icon-Smoking-Pipe','icon-Snake','icon-Snorkel','icon-Snow-2','icon-Snow-Dome','icon-Snow-Storm','icon-Snow','icon-Snowflake-2','icon-Snowflake-3','icon-Snowflake-4','icon-Snowflake','icon-Snowman','icon-Soccer-Ball','icon-Soccer-Shoes','icon-Socks','icon-Solar','icon-Sound-Wave','icon-Sound','icon-Soundcloud','icon-Soup','icon-South-Africa','icon-Space-Needle','icon-Spain','icon-Spam-Mail','icon-Speach-Bubble','icon-Speach-Bubble2','icon-Speach-Bubble3','icon-Speach-Bubble4','icon-Speach-Bubble5','icon-Speach-Bubble6','icon-Speach-Bubble7','icon-Speach-Bubble8','icon-Speach-Bubble9','icon-Speach-Bubble10','icon-Speach-Bubble11','icon-Speach-Bubble12','icon-Speach-Bubble13','icon-Speach-BubbleAsking','icon-Speach-BubbleComic','icon-Speach-BubbleComic2','icon-Speach-BubbleComic3','icon-Speach-BubbleComic4','icon-Speach-BubbleDialog','icon-Speach-Bubbles','icon-Speak-2','icon-Speak','icon-Speaker-2','icon-Speaker','icon-Spell-Check','icon-Spell-CheckABC','icon-Spermium','icon-Spider','icon-Spiderweb','icon-Split-FourSquareWindow','icon-Split-Horizontal','icon-Split-Horizontal2Window','icon-Split-Vertical','icon-Split-Vertical2','icon-Split-Window','icon-Spoder','icon-Spoon','icon-Sport-Mode','icon-Sports-Clothings1','icon-Sports-Clothings2','icon-Sports-Shirt','icon-Spot','icon-Spray','icon-Spread','icon-Spring','icon-Spurl','icon-Spy','icon-Squirrel','icon-SSL','icon-St-BasilsCathedral','icon-St-PaulsCathedral','icon-Stamp-2','icon-Stamp','icon-Stapler','icon-Star-Track','icon-Star','icon-Starfish','icon-Start2','icon-Start-3','icon-Start-ways','icon-Start','icon-Statistic','icon-Stethoscope','icon-stop--2','icon-Stop-Music','icon-Stop','icon-Stopwatch-2','icon-Stopwatch','icon-Storm','icon-Street-View','icon-Street-View2','icon-Strikethrough-Text','icon-Stroller','icon-Structure','icon-Student-Female','icon-Student-Hat','icon-Student-Hat2','icon-Student-Male','icon-Student-MaleFemale','icon-Students','icon-Studio-Flash','icon-Studio-Lightbox','icon-Stumbleupon','icon-Suit','icon-Suitcase','icon-Sum-2','icon-Sum','icon-Summer','icon-Sun-CloudyRain','icon-Sun','icon-Sunglasses-2','icon-Sunglasses-3','icon-Sunglasses-Smiley','icon-Sunglasses-Smiley2','icon-Sunglasses-W','icon-Sunglasses-W2','icon-Sunglasses-W3','icon-Sunglasses','icon-Sunrise','icon-Sunset','icon-Superman','icon-Support','icon-Surprise','icon-Sushi','icon-Sweden','icon-Swimming-Short','icon-Swimming','icon-Swimmwear','icon-Switch','icon-Switzerland','icon-Sync-Cloud','icon-Sync','icon-Synchronize-2','icon-Synchronize','icon-T-Shirt','icon-Tablet-2','icon-Tablet-3','icon-Tablet-Orientation','icon-Tablet-Phone','icon-Tablet-Secure','icon-Tablet-Vertical','icon-Tablet','icon-Tactic','icon-Tag-2','icon-Tag-3','icon-Tag-4','icon-Tag-5','icon-Tag','icon-Taj-Mahal','icon-Talk-Man','icon-Tap','icon-Target-Market','icon-Target','icon-Taurus-2','icon-Taurus','icon-Taxi-2','icon-Taxi-Sign','icon-Taxi','icon-Teacher','icon-Teapot','icon-Technorati','icon-Teddy-Bear','icon-Tee-Mug','icon-Telephone-2','icon-Telephone','icon-Telescope','icon-Temperature-2','icon-Temperature-3','icon-Temperature','icon-Temple','icon-Tennis-Ball','icon-Tennis','icon-Tent','icon-Test-Tube','icon-Test-Tube2','icon-Testimonal','icon-Text-Box','icon-Text-Effect','icon-Text-HighlightColor','icon-Text-Paragraph','icon-Thailand','icon-The-WhiteHouse','icon-This-SideUp','icon-Thread','icon-Three-ArrowFork','icon-Three-Fingers','icon-Three-FingersDrag','icon-Three-FingersDrag2','icon-Three-FingersTouch','icon-Thumb','icon-Thumbs-DownSmiley','icon-Thumbs-UpSmiley','icon-Thunder','icon-Thunderstorm','icon-Ticket','icon-Tie-2','icon-Tie-3','icon-Tie-4','icon-Tie','icon-Tiger','icon-Time-Backup','icon-Time-Bomb','icon-Time-Clock','icon-Time-Fire','icon-Time-Machine','icon-Time-Window','icon-Timer-2','icon-Timer','icon-To-Bottom','icon-To-Bottom2','icon-To-Left','icon-To-Right','icon-To-Top','icon-To-Top2','icon-Token-','icon-Tomato','icon-Tongue','icon-Tooth-2','icon-Tooth','icon-Top-ToBottom','icon-Touch-Window','icon-Tourch','icon-Tower-2','icon-Tower-Bridge','icon-Tower','icon-Trace','icon-Tractor','icon-traffic-Light','icon-Traffic-Light2','icon-Train-2','icon-Train','icon-Tram','icon-Transform-2','icon-Transform-3','icon-Transform-4','icon-Transform','icon-Trash-withMen','icon-Tree-2','icon-Tree-3','icon-Tree-4','icon-Tree-5','icon-Tree','icon-Trekking','icon-Triangle-ArrowDown','icon-Triangle-ArrowLeft','icon-Triangle-ArrowRight','icon-Triangle-ArrowUp','icon-Tripod-2','icon-Tripod-andVideo','icon-Tripod-withCamera','icon-Tripod-withGopro','icon-Trophy-2','icon-Trophy','icon-Truck','icon-Trumpet','icon-Tumblr','icon-Turkey','icon-Turn-Down','icon-Turn-Down2','icon-Turn-DownFromLeft','icon-Turn-DownFromRight','icon-Turn-Left','icon-Turn-Left3','icon-Turn-Right','icon-Turn-Right3','icon-Turn-Up','icon-Turn-Up2','icon-Turtle','icon-Tuxedo','icon-TV','icon-Twister','icon-Twitter-2','icon-Twitter','icon-Two-Fingers','icon-Two-FingersDrag','icon-Two-FingersDrag2','icon-Two-FingersScroll','icon-Two-FingersTouch','icon-Two-Windows','icon-Type-Pass','icon-Ukraine','icon-Umbrela','icon-Umbrella-2','icon-Umbrella-3','icon-Under-LineText','icon-Undo','icon-United-Kingdom','icon-United-States','icon-University-2','icon-University','icon-Unlike-2','icon-Unlike','icon-Unlock-2','icon-Unlock-3','icon-Unlock','icon-Up--Down','icon-Up--Down3','icon-Up-2','icon-Up-3','icon-Up-4','icon-Up','icon-Upgrade','icon-Upload-2','icon-Upload-toCloud','icon-Upload-Window','icon-Upload','icon-Uppercase-Text','icon-Upward','icon-URL-Window','icon-Usb-2','icon-Usb-Cable','icon-Usb','icon-User','icon-Ustream','icon-Vase','icon-Vector-2','icon-Vector-3','icon-Vector-4','icon-Vector-5','icon-Vector','icon-Venn-Diagram','icon-Vest-2','icon-Vest','icon-Viddler','icon-Video-2','icon-Video-3','icon-Video-4','icon-Video-5','icon-Video-6','icon-Video-GameController','icon-Video-Len','icon-Video-Len2','icon-Video-Photographer','icon-Video-Tripod','icon-Video','icon-Vietnam','icon-View-Height','icon-View-Width','icon-Vimeo','icon-Virgo-2','icon-Virgo','icon-Virus-2','icon-Virus-3','icon-Virus','icon-Visa','icon-Voice','icon-Voicemail','icon-Volleyball','icon-Volume-Down','icon-Volume-Up','icon-VPN','icon-Wacom-Tablet','icon-Waiter','icon-Walkie-Talkie','icon-Wallet-2','icon-Wallet-3','icon-Wallet','icon-Warehouse','icon-Warning-Window','icon-Watch-2','icon-Watch-3','icon-Watch','icon-Wave-2','icon-Wave','icon-Webcam','icon-weight-Lift','icon-Wheelbarrow','icon-Wheelchair','icon-Width-Window','icon-Wifi-2','icon-Wifi-Keyboard','icon-Wifi','icon-Wind-Turbine','icon-Windmill','icon-Window-2','icon-Window','icon-Windows-2','icon-Windows-Microsoft','icon-Windows','icon-Windsock','icon-Windy','icon-Wine-Bottle','icon-Wine-Glass','icon-Wink','icon-Winter-2','icon-Winter','icon-Wireless','icon-Witch-Hat','icon-Witch','icon-Wizard','icon-Wolf','icon-Woman-Sign','icon-WomanMan','icon-Womans-Underwear','icon-Womans-Underwear2','icon-Women','icon-Wonder-Woman','icon-Wordpress','icon-Worker-Clothes','icon-Worker','icon-Wrap-Text','icon-Wreath','icon-Wrench','icon-X-Box','icon-X-ray','icon-Xanga','icon-Xing','icon-Yacht','icon-Yahoo-Buzz','icon-Yahoo','icon-Yelp','icon-Yes','icon-Ying-Yang','icon-Youtube','icon-Z-A','icon-Zebra','icon-Zombie','icon-Zoom-Gesture','icon-Zootool');
    
    
    return $icons;
}

/**
 * FontAwesome icons array
 */
function workscout_icons_list(){
    $icon = array(''=>'empty','500px'=>'500px','address-book'=>'address-book','address-book-o'=>'address-book-o','address-card'=>'address-card','address-card-o'=>'address-card-o','adjust'=>'adjust','adn'=>'adn','align-center'=>'align-center','align-justify'=>'align-justify','align-left'=>'align-left','align-right'=>'align-right','amazon'=>'amazon','ambulance'=>'ambulance','american-sign-language-interpreting'=>'american-sign-language-interpreting','anchor'=>'anchor','android'=>'android','angellist'=>'angellist','angle-double-down'=>'angle-double-down','angle-double-left'=>'angle-double-left','angle-double-right'=>'angle-double-right','angle-double-up'=>'angle-double-up','angle-down'=>'angle-down','angle-left'=>'angle-left','angle-right'=>'angle-right','angle-up'=>'angle-up','apple'=>'apple','archive'=>'archive','area-chart'=>'area-chart','arrow-circle-down'=>'arrow-circle-down','arrow-circle-left'=>'arrow-circle-left','arrow-circle-o-down'=>'arrow-circle-o-down','arrow-circle-o-left'=>'arrow-circle-o-left','arrow-circle-o-right'=>'arrow-circle-o-right','arrow-circle-o-up'=>'arrow-circle-o-up','arrow-circle-right'=>'arrow-circle-right','arrow-circle-up'=>'arrow-circle-up','arrow-down'=>'arrow-down','arrow-left'=>'arrow-left','arrow-right'=>'arrow-right','arrow-up'=>'arrow-up','arrows'=>'arrows','arrows-alt'=>'arrows-alt','arrows-h'=>'arrows-h','arrows-v'=>'arrows-v','asl-interpreting'=>'asl-interpreting','assistive-listening-systems'=>'assistive-listening-systems','asterisk'=>'asterisk','at'=>'at','audio-description'=>'audio-description','automobile'=>'automobile','backward'=>'backward','balance-scale'=>'balance-scale','ban'=>'ban','bandcamp'=>'bandcamp','bank'=>'bank','bar-chart'=>'bar-chart','bar-chart-o'=>'bar-chart-o','barcode'=>'barcode','bars'=>'bars','bath'=>'bath','bathtub'=>'bathtub','battery'=>'battery','battery-0'=>'battery-0','battery-1'=>'battery-1','battery-2'=>'battery-2','battery-3'=>'battery-3','battery-4'=>'battery-4','battery-empty'=>'battery-empty','battery-full'=>'battery-full','battery-half'=>'battery-half','battery-quarter'=>'battery-quarter','battery-three-quarters'=>'battery-three-quarters','bed'=>'bed','beer'=>'beer','behance'=>'behance','behance-square'=>'behance-square','bell'=>'bell','bell-o'=>'bell-o','bell-slash'=>'bell-slash','bell-slash-o'=>'bell-slash-o','bicycle'=>'bicycle','binoculars'=>'binoculars','birthday-cake'=>'birthday-cake','bitbucket'=>'bitbucket','bitbucket-square'=>'bitbucket-square','bitcoin'=>'bitcoin','black-tie'=>'black-tie','blind'=>'blind','bluetooth'=>'bluetooth','bluetooth-b'=>'bluetooth-b','bold'=>'bold','bolt'=>'bolt','bomb'=>'bomb','book'=>'book','bookmark'=>'bookmark','bookmark-o'=>'bookmark-o','braille'=>'braille','briefcase'=>'briefcase','btc'=>'btc','bug'=>'bug','building'=>'building','building-o'=>'building-o','bullhorn'=>'bullhorn','bullseye'=>'bullseye','bus'=>'bus','buysellads'=>'buysellads','cab'=>'cab','calculator'=>'calculator','calendar'=>'calendar','calendar-check-o'=>'calendar-check-o','calendar-minus-o'=>'calendar-minus-o','calendar-o'=>'calendar-o','calendar-plus-o'=>'calendar-plus-o','calendar-times-o'=>'calendar-times-o','camera'=>'camera','camera-retro'=>'camera-retro','car'=>'car','caret-down'=>'caret-down','caret-left'=>'caret-left','caret-right'=>'caret-right','caret-square-o-down'=>'caret-square-o-down','caret-square-o-left'=>'caret-square-o-left','caret-square-o-right'=>'caret-square-o-right','caret-square-o-up'=>'caret-square-o-up','caret-up'=>'caret-up','cart-arrow-down'=>'cart-arrow-down','cart-plus'=>'cart-plus','cc'=>'cc','cc-amex'=>'cc-amex','cc-diners-club'=>'cc-diners-club','cc-discover'=>'cc-discover','cc-jcb'=>'cc-jcb','cc-mastercard'=>'cc-mastercard','cc-paypal'=>'cc-paypal','cc-stripe'=>'cc-stripe','cc-visa'=>'cc-visa','certificate'=>'certificate','chain'=>'chain','chain-broken'=>'chain-broken','check'=>'check','check-circle'=>'check-circle','check-circle-o'=>'check-circle-o','check-square'=>'check-square','check-square-o'=>'check-square-o','chevron-circle-down'=>'chevron-circle-down','chevron-circle-left'=>'chevron-circle-left','chevron-circle-right'=>'chevron-circle-right','chevron-circle-up'=>'chevron-circle-up','chevron-down'=>'chevron-down','chevron-left'=>'chevron-left','chevron-right'=>'chevron-right','chevron-up'=>'chevron-up','child'=>'child','chrome'=>'chrome','circle'=>'circle','circle-o'=>'circle-o','circle-o-notch'=>'circle-o-notch','circle-thin'=>'circle-thin','clipboard'=>'clipboard','clock-o'=>'clock-o','clone'=>'clone','close'=>'close','cloud'=>'cloud','cloud-download'=>'cloud-download','cloud-upload'=>'cloud-upload','cny'=>'cny','code'=>'code','code-fork'=>'code-fork','codepen'=>'codepen','codiepie'=>'codiepie','coffee'=>'coffee','cog'=>'cog','cogs'=>'cogs','columns'=>'columns','comment'=>'comment','comment-o'=>'comment-o','commenting'=>'commenting','commenting-o'=>'commenting-o','comments'=>'comments','comments-o'=>'comments-o','compass'=>'compass','compress'=>'compress','connectdevelop'=>'connectdevelop','contao'=>'contao','copy'=>'copy','copyright'=>'copyright','creative-commons'=>'creative-commons','credit-card'=>'credit-card','credit-card-alt'=>'credit-card-alt','crop'=>'crop','crosshairs'=>'crosshairs','css3'=>'css3','cube'=>'cube','cubes'=>'cubes','cut'=>'cut','cutlery'=>'cutlery','dashboard'=>'dashboard','dashcube'=>'dashcube','database'=>'database','deaf'=>'deaf','deafness'=>'deafness','dedent'=>'dedent','delicious'=>'delicious','desktop'=>'desktop','deviantart'=>'deviantart','diamond'=>'diamond','digg'=>'digg','dollar'=>'dollar','dot-circle-o'=>'dot-circle-o','download'=>'download','dribbble'=>'dribbble','drivers-license'=>'drivers-license','drivers-license-o'=>'drivers-license-o','dropbox'=>'dropbox','drupal'=>'drupal','edge'=>'edge','edit'=>'edit','eercast'=>'eercast','eject'=>'eject','ellipsis-h'=>'ellipsis-h','ellipsis-v'=>'ellipsis-v','empire'=>'empire','envelope'=>'envelope','envelope-o'=>'envelope-o','envelope-open'=>'envelope-open','envelope-open-o'=>'envelope-open-o','envelope-square'=>'envelope-square','envira'=>'envira','eraser'=>'eraser','etsy'=>'etsy','eur'=>'eur','euro'=>'euro','exchange'=>'exchange','exclamation'=>'exclamation','exclamation-circle'=>'exclamation-circle','exclamation-triangle'=>'exclamation-triangle','expand'=>'expand','expeditedssl'=>'expeditedssl','external-link'=>'external-link','external-link-square'=>'external-link-square','eye'=>'eye','eye-slash'=>'eye-slash','eyedropper'=>'eyedropper','fa'=>'fa','facebook'=>'facebook','facebook-f'=>'facebook-f','facebook-official'=>'facebook-official','facebook-square'=>'facebook-square','fast-backward'=>'fast-backward','fast-forward'=>'fast-forward','fax'=>'fax','feed'=>'feed','female'=>'female','fighter-jet'=>'fighter-jet','file'=>'file','file-archive-o'=>'file-archive-o','file-audio-o'=>'file-audio-o','file-code-o'=>'file-code-o','file-excel-o'=>'file-excel-o','file-image-o'=>'file-image-o','file-movie-o'=>'file-movie-o','file-o'=>'file-o','file-pdf-o'=>'file-pdf-o','file-photo-o'=>'file-photo-o','file-picture-o'=>'file-picture-o','file-powerpoint-o'=>'file-powerpoint-o','file-sound-o'=>'file-sound-o','file-text'=>'file-text','file-text-o'=>'file-text-o','file-video-o'=>'file-video-o','file-word-o'=>'file-word-o','file-zip-o'=>'file-zip-o','files-o'=>'files-o','film'=>'film','filter'=>'filter','fire'=>'fire','fire-extinguisher'=>'fire-extinguisher','firefox'=>'firefox','first-order'=>'first-order','flag'=>'flag','flag-checkered'=>'flag-checkered','flag-o'=>'flag-o','flash'=>'flash','flask'=>'flask','flickr'=>'flickr','floppy-o'=>'floppy-o','folder'=>'folder','folder-o'=>'folder-o','folder-open'=>'folder-open','folder-open-o'=>'folder-open-o','font'=>'font','font-awesome'=>'font-awesome','fonticons'=>'fonticons','fort-awesome'=>'fort-awesome','forumbee'=>'forumbee','forward'=>'forward','foursquare'=>'foursquare','free-code-camp'=>'free-code-camp','frown-o'=>'frown-o','futbol-o'=>'futbol-o','gamepad'=>'gamepad','gavel'=>'gavel','gbp'=>'gbp','ge'=>'ge','gear'=>'gear','gears'=>'gears','genderless'=>'genderless','get-pocket'=>'get-pocket','gg'=>'gg','gg-circle'=>'gg-circle','gift'=>'gift','git'=>'git','git-square'=>'git-square','github'=>'github','github-alt'=>'github-alt','github-square'=>'github-square','gitlab'=>'gitlab','gittip'=>'gittip','glass'=>'glass','glide'=>'glide','glide-g'=>'glide-g','globe'=>'globe','google'=>'google','google-plus'=>'google-plus','google-plus-circle'=>'google-plus-circle','google-plus-official'=>'google-plus-official','google-plus-square'=>'google-plus-square','google-wallet'=>'google-wallet','graduation-cap'=>'graduation-cap','gratipay'=>'gratipay','grav'=>'grav','group'=>'group','h-square'=>'h-square','hacker-news'=>'hacker-news','hand-grab-o'=>'hand-grab-o','hand-lizard-o'=>'hand-lizard-o','hand-o-down'=>'hand-o-down','hand-o-left'=>'hand-o-left','hand-o-right'=>'hand-o-right','hand-o-up'=>'hand-o-up','hand-paper-o'=>'hand-paper-o','hand-peace-o'=>'hand-peace-o','hand-pointer-o'=>'hand-pointer-o','hand-rock-o'=>'hand-rock-o','hand-scissors-o'=>'hand-scissors-o','hand-spock-o'=>'hand-spock-o','hand-stop-o'=>'hand-stop-o','handshake-o'=>'handshake-o','hard-of-hearing'=>'hard-of-hearing','hashtag'=>'hashtag','hdd-o'=>'hdd-o','header'=>'header','headphones'=>'headphones','heart'=>'heart','heart-o'=>'heart-o','heartbeat'=>'heartbeat','history'=>'history','home'=>'home','hospital-o'=>'hospital-o','hotel'=>'hotel','hourglass'=>'hourglass','hourglass-1'=>'hourglass-1','hourglass-2'=>'hourglass-2','hourglass-3'=>'hourglass-3','hourglass-end'=>'hourglass-end','hourglass-half'=>'hourglass-half','hourglass-o'=>'hourglass-o','hourglass-start'=>'hourglass-start','houzz'=>'houzz','html5'=>'html5','i-cursor'=>'i-cursor','id-badge'=>'id-badge','id-card'=>'id-card','id-card-o'=>'id-card-o','ils'=>'ils','image'=>'image','imdb'=>'imdb','inbox'=>'inbox','indent'=>'indent','industry'=>'industry','info'=>'info','info-circle'=>'info-circle','inr'=>'inr','instagram'=>'instagram','institution'=>'institution','internet-explorer'=>'internet-explorer','intersex'=>'intersex','ioxhost'=>'ioxhost','italic'=>'italic','joomla'=>'joomla','jpy'=>'jpy','jsfiddle'=>'jsfiddle','key'=>'key','keyboard-o'=>'keyboard-o','krw'=>'krw','language'=>'language','laptop'=>'laptop','lastfm'=>'lastfm','lastfm-square'=>'lastfm-square','leaf'=>'leaf','leanpub'=>'leanpub','legal'=>'legal','lemon-o'=>'lemon-o','level-down'=>'level-down','level-up'=>'level-up','life-bouy'=>'life-bouy','life-buoy'=>'life-buoy','life-ring'=>'life-ring','life-saver'=>'life-saver','lightbulb-o'=>'lightbulb-o','line-chart'=>'line-chart','link'=>'link','linkedin'=>'linkedin','linkedin-square'=>'linkedin-square','linode'=>'linode','linux'=>'linux','list'=>'list','list-alt'=>'list-alt','list-ol'=>'list-ol','list-ul'=>'list-ul','location-arrow'=>'location-arrow','lock'=>'lock','long-arrow-down'=>'long-arrow-down','long-arrow-left'=>'long-arrow-left','long-arrow-right'=>'long-arrow-right','long-arrow-up'=>'long-arrow-up','low-vision'=>'low-vision','magic'=>'magic','magnet'=>'magnet','mail-forward'=>'mail-forward','mail-reply'=>'mail-reply','mail-reply-all'=>'mail-reply-all','male'=>'male','map'=>'map','map-marker'=>'map-marker','map-o'=>'map-o','map-pin'=>'map-pin','map-signs'=>'map-signs','mars'=>'mars','mars-double'=>'mars-double','mars-stroke'=>'mars-stroke','mars-stroke-h'=>'mars-stroke-h','mars-stroke-v'=>'mars-stroke-v','maxcdn'=>'maxcdn','meanpath'=>'meanpath','medium'=>'medium','medkit'=>'medkit','meetup'=>'meetup','meh-o'=>'meh-o','mercury'=>'mercury','microchip'=>'microchip','microphone'=>'microphone','microphone-slash'=>'microphone-slash','minus'=>'minus','minus-circle'=>'minus-circle','minus-square'=>'minus-square','minus-square-o'=>'minus-square-o','mixcloud'=>'mixcloud','mobile'=>'mobile','mobile-phone'=>'mobile-phone','modx'=>'modx','money'=>'money','moon-o'=>'moon-o','mortar-board'=>'mortar-board','motorcycle'=>'motorcycle','mouse-pointer'=>'mouse-pointer','music'=>'music','navicon'=>'navicon','neuter'=>'neuter','newspaper-o'=>'newspaper-o','object-group'=>'object-group','object-ungroup'=>'object-ungroup','odnoklassniki'=>'odnoklassniki','odnoklassniki-square'=>'odnoklassniki-square','opencart'=>'opencart','openid'=>'openid','opera'=>'opera','optin-monster'=>'optin-monster','outdent'=>'outdent','pagelines'=>'pagelines','paint-brush'=>'paint-brush','paper-plane'=>'paper-plane','paper-plane-o'=>'paper-plane-o','paperclip'=>'paperclip','paragraph'=>'paragraph','paste'=>'paste','pause'=>'pause','pause-circle'=>'pause-circle','pause-circle-o'=>'pause-circle-o','paw'=>'paw','paypal'=>'paypal','pencil'=>'pencil','pencil-square'=>'pencil-square','pencil-square-o'=>'pencil-square-o','percent'=>'percent','phone'=>'phone','phone-square'=>'phone-square','photo'=>'photo','picture-o'=>'picture-o','pie-chart'=>'pie-chart','pied-piper'=>'pied-piper','pied-piper-alt'=>'pied-piper-alt','pied-piper-pp'=>'pied-piper-pp','pinterest'=>'pinterest','pinterest-p'=>'pinterest-p','pinterest-square'=>'pinterest-square','plane'=>'plane','play'=>'play','play-circle'=>'play-circle','play-circle-o'=>'play-circle-o','plug'=>'plug','plus'=>'plus','plus-circle'=>'plus-circle','plus-square'=>'plus-square','plus-square-o'=>'plus-square-o','podcast'=>'podcast','power-off'=>'power-off','print'=>'print','product-hunt'=>'product-hunt','puzzle-piece'=>'puzzle-piece','qq'=>'qq','qrcode'=>'qrcode','question'=>'question','question-circle'=>'question-circle','question-circle-o'=>'question-circle-o','quora'=>'quora','quote-left'=>'quote-left','quote-right'=>'quote-right','ra'=>'ra','random'=>'random','ravelry'=>'ravelry','rebel'=>'rebel','recycle'=>'recycle','reddit'=>'reddit','reddit-alien'=>'reddit-alien','reddit-square'=>'reddit-square','refresh'=>'refresh','registered'=>'registered','remove'=>'remove','renren'=>'renren','reorder'=>'reorder','repeat'=>'repeat','reply'=>'reply','reply-all'=>'reply-all','resistance'=>'resistance','retweet'=>'retweet','rmb'=>'rmb','road'=>'road','rocket'=>'rocket','rotate-left'=>'rotate-left','rotate-right'=>'rotate-right','rouble'=>'rouble','rss'=>'rss','rss-square'=>'rss-square','rub'=>'rub','ruble'=>'ruble','rupee'=>'rupee','s15'=>'s15','safari'=>'safari','save'=>'save','scissors'=>'scissors','scribd'=>'scribd','search'=>'search','search-minus'=>'search-minus','search-plus'=>'search-plus','sellsy'=>'sellsy','send'=>'send','send-o'=>'send-o','server'=>'server','share'=>'share','share-alt'=>'share-alt','share-alt-square'=>'share-alt-square','share-square'=>'share-square','share-square-o'=>'share-square-o','shekel'=>'shekel','sheqel'=>'sheqel','shield'=>'shield','ship'=>'ship','shirtsinbulk'=>'shirtsinbulk','shopping-bag'=>'shopping-bag','shopping-basket'=>'shopping-basket','shopping-cart'=>'shopping-cart','shower'=>'shower','sign-in'=>'sign-in','sign-language'=>'sign-language','sign-out'=>'sign-out','signal'=>'signal','signing'=>'signing','simplybuilt'=>'simplybuilt','sitemap'=>'sitemap','skyatlas'=>'skyatlas','skype'=>'skype','slack'=>'slack','sliders'=>'sliders','slideshare'=>'slideshare','smile-o'=>'smile-o','snapchat'=>'snapchat','snapchat-ghost'=>'snapchat-ghost','snapchat-square'=>'snapchat-square','snowflake-o'=>'snowflake-o','soccer-ball-o'=>'soccer-ball-o','sort'=>'sort','sort-alpha-asc'=>'sort-alpha-asc','sort-alpha-desc'=>'sort-alpha-desc','sort-amount-asc'=>'sort-amount-asc','sort-amount-desc'=>'sort-amount-desc','sort-asc'=>'sort-asc','sort-desc'=>'sort-desc','sort-down'=>'sort-down','sort-numeric-asc'=>'sort-numeric-asc','sort-numeric-desc'=>'sort-numeric-desc','sort-up'=>'sort-up','soundcloud'=>'soundcloud','space-shuttle'=>'space-shuttle','spinner'=>'spinner','spoon'=>'spoon','spotify'=>'spotify','square'=>'square','square-o'=>'square-o','stack-exchange'=>'stack-exchange','stack-overflow'=>'stack-overflow','star'=>'star','star-half'=>'star-half','star-half-empty'=>'star-half-empty','star-half-full'=>'star-half-full','star-half-o'=>'star-half-o','star-o'=>'star-o','steam'=>'steam','steam-square'=>'steam-square','step-backward'=>'step-backward','step-forward'=>'step-forward','stethoscope'=>'stethoscope','sticky-note'=>'sticky-note','sticky-note-o'=>'sticky-note-o','stop'=>'stop','stop-circle'=>'stop-circle','stop-circle-o'=>'stop-circle-o','street-view'=>'street-view','strikethrough'=>'strikethrough','stumbleupon'=>'stumbleupon','stumbleupon-circle'=>'stumbleupon-circle','subscript'=>'subscript','subway'=>'subway','suitcase'=>'suitcase','sun-o'=>'sun-o','superpowers'=>'superpowers','superscript'=>'superscript','support'=>'support','table'=>'table','tablet'=>'tablet','tachometer'=>'tachometer','tag'=>'tag','tags'=>'tags','tasks'=>'tasks','taxi'=>'taxi','telegram'=>'telegram','television'=>'television','tencent-weibo'=>'tencent-weibo','terminal'=>'terminal','text-height'=>'text-height','text-width'=>'text-width','th'=>'th','th-large'=>'th-large','th-list'=>'th-list','themeisle'=>'themeisle','thermometer'=>'thermometer','thermometer-0'=>'thermometer-0','thermometer-1'=>'thermometer-1','thermometer-2'=>'thermometer-2','thermometer-3'=>'thermometer-3','thermometer-4'=>'thermometer-4','thermometer-empty'=>'thermometer-empty','thermometer-full'=>'thermometer-full','thermometer-half'=>'thermometer-half','thermometer-quarter'=>'thermometer-quarter','thermometer-three-quarters'=>'thermometer-three-quarters','thumb-tack'=>'thumb-tack','thumbs-down'=>'thumbs-down','thumbs-o-down'=>'thumbs-o-down','thumbs-o-up'=>'thumbs-o-up','thumbs-up'=>'thumbs-up','ticket'=>'ticket','times'=>'times','times-circle'=>'times-circle','times-circle-o'=>'times-circle-o','times-rectangle'=>'times-rectangle','times-rectangle-o'=>'times-rectangle-o','tint'=>'tint','toggle-down'=>'toggle-down','toggle-left'=>'toggle-left','toggle-off'=>'toggle-off','toggle-on'=>'toggle-on','toggle-right'=>'toggle-right','toggle-up'=>'toggle-up','trademark'=>'trademark','train'=>'train','transgender'=>'transgender','transgender-alt'=>'transgender-alt','trash'=>'trash','trash-o'=>'trash-o','tree'=>'tree','trello'=>'trello','tripadvisor'=>'tripadvisor','trophy'=>'trophy','truck'=>'truck','try'=>'try','tty'=>'tty','tumblr'=>'tumblr','tumblr-square'=>'tumblr-square','turkish-lira'=>'turkish-lira','tv'=>'tv','twitch'=>'twitch','twitter'=>'twitter','twitter-square'=>'twitter-square','umbrella'=>'umbrella','underline'=>'underline','undo'=>'undo','universal-access'=>'universal-access','university'=>'university','unlink'=>'unlink','unlock'=>'unlock','unlock-alt'=>'unlock-alt','unsorted'=>'unsorted','upload'=>'upload','usb'=>'usb','usd'=>'usd','user'=>'user','user-circle'=>'user-circle','user-circle-o'=>'user-circle-o','user-md'=>'user-md','user-o'=>'user-o','user-plus'=>'user-plus','user-secret'=>'user-secret','user-times'=>'user-times','users'=>'users','vcard'=>'vcard','vcard-o'=>'vcard-o','venus'=>'venus','venus-double'=>'venus-double','venus-mars'=>'venus-mars','viacoin'=>'viacoin','viadeo'=>'viadeo','viadeo-square'=>'viadeo-square','video-camera'=>'video-camera','vimeo'=>'vimeo','vimeo-square'=>'vimeo-square','vine'=>'vine','vk'=>'vk','volume-control-phone'=>'volume-control-phone','volume-down'=>'volume-down','volume-off'=>'volume-off','volume-up'=>'volume-up','warning'=>'warning','wechat'=>'wechat','weibo'=>'weibo','weixin'=>'weixin','whatsapp'=>'whatsapp','wheelchair'=>'wheelchair','wheelchair-alt'=>'wheelchair-alt','wifi'=>'wifi','wikipedia-w'=>'wikipedia-w','window-close'=>'window-close','window-close-o'=>'window-close-o','window-maximize'=>'window-maximize','window-minimize'=>'window-minimize','window-restore'=>'window-restore','windows'=>'windows','won'=>'won','wordpress'=>'wordpress','wpbeginner'=>'wpbeginner','wpexplorer'=>'wpexplorer','wpforms'=>'wpforms','wrench'=>'wrench','xing'=>'xing','xing-square'=>'xing-square','y-combinator'=>'y-combinator','y-combinator-square'=>'y-combinator-square','yahoo'=>'yahoo','yc'=>'yc','yc-square'=>'yc-square','yelp'=>'yelp','yen'=>'yen','yoast'=>'yoast','youtube'=>'youtube','youtube-play'=>'youtube-play','youtube-square'=>'youtube-square');
    return $icon;
}





class WorkScout_Incremental_Jobs_Suggest {

    static function on_load() {

        add_action( 'init', array( __CLASS__, 'init' ) );
    }

    static function init() {

        add_action( 'wp_print_footer_scripts', array( __CLASS__, 'wp_print_footer_scripts' ), 11 );
        add_action( 'wp_ajax_workscout_incremental_jobs_suggest', array( __CLASS__, 'wp_ajax_workscout_incremental_jobs_suggest' ) );
        add_action( 'wp_ajax_nopriv_workscout_incremental_jobs_suggest', array( __CLASS__, 'wp_ajax_workscout_incremental_jobs_suggest' ) );
    }



    static function wp_print_footer_scripts() {

        ?>
    <script type="text/javascript">
        (function($){
        

        $(document).ready(function(){

            $( '.sc-jobs #search_keywords, .sc-jobs #intro-keywords' ).autocomplete({
                
                source: function(req, response){
                    $.getJSON('<?php echo admin_url( 'admin-ajax.php' ); ?>'+'?callback=?&action=workscout_incremental_jobs_suggest', req, response);
                },
                select: function(event, ui) {
                    window.location.href=ui.item.link;
                },
                minLength: 3,
            }); 
         });

        })(this.jQuery);

           
    </script><?php
    }

    static function wp_ajax_workscout_incremental_jobs_suggest() {
    
        $suggestions = array();
        $posts = get_posts( array(
            's' => $_REQUEST['term'],
            'post_type'     => 'job_listing',
            'posts_per_page'     => '8',
        ) );
        global $post;
        $results = array();
        foreach ($posts as $post) {
            setup_postdata($post);
            $suggestion = array();
            $suggestion['label'] =  html_entity_decode($post->post_title, ENT_QUOTES, 'UTF-8');
            $suggestion['link'] = get_permalink($post->ID);
            
            $suggestions[] = $suggestion;
        }
        // JSON encode and echo
            $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
            echo $response;
             // Don't forget to exit!
            exit;

    }
}

WorkScout_Incremental_Jobs_Suggest::on_load();


class WorkScout_Incremental_Resumes_Suggest {

    static function on_load() {

        add_action( 'init', array( __CLASS__, 'init' ) );
    }

    static function init() {

        add_action( 'wp_print_footer_scripts', array( __CLASS__, 'wp_print_footer_scripts' ), 11 );
        add_action( 'wp_ajax_workscout_incremental_resumes_suggest', array( __CLASS__, 'wp_ajax_workscout_incremental_resumes_suggest' ) );
        add_action( 'wp_ajax_nopriv_workscout_incremental_resumes_suggest', array( __CLASS__, 'wp_ajax_workscout_incremental_resumes_suggest' ) );
    }



    static function wp_print_footer_scripts() {

        ?>
    <script type="text/javascript">
        (function($){
        

        $(document).ready(function(){

            $( '.sc-resumes #search_keywords,.sc-resumes #intro-keywords' ).autocomplete({
                
                source: function(req, response){
                    $.getJSON('<?php echo admin_url( 'admin-ajax.php' ); ?>'+'?callback=?&action=workscout_incremental_resumes_suggest', req, response);
                },
                select: function(event, ui) {
                    window.location.href=ui.item.link;
                },
                minLength: 3,
            }); 

         });

        })(this.jQuery);

           
    </script><?php
    }

    static function wp_ajax_workscout_incremental_resumes_suggest() {
    
        $suggestions = array();
        $posts = get_posts( array(
            's' => $_REQUEST['term'],
            'post_type'     => 'resume',
            'posts_per_page'     => '8',
        ) );
        global $post;
        $results = array();
        foreach ($posts as $post) {
            setup_postdata($post);
            $suggestion = array();
            $suggestion['label'] =  html_entity_decode($post->post_title, ENT_QUOTES, 'UTF-8');
            $suggestion['link'] = get_permalink($post->ID);
            
            $suggestions[] = $suggestion;
        }
        // JSON encode and echo
            $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
            echo $response;
             // Don't forget to exit!
            exit;

    }
}

WorkScout_Incremental_Resumes_Suggest::on_load();




add_filter('bcn_breadcrumb_url', 'workscout_browse_jobs_breadcrumb_url_changer', 3, 10);
function workscout_browse_jobs_breadcrumb_url_changer($url, $type, $id)
{
    if(in_array('post-job_listing-archive', $type) )
    {
        $url = get_permalink(get_option('job_manager_jobs_page_id'));
    }
    return $url;
}


if( ! function_exists( 'field_editor_user_can_upload_file_via_ajax' ) ){

    /**
     * Checks if the user can upload a file via the Ajax endpoint.
     *
     * This is a function added for compatibility with older versions of WP Job Manager, as this function
     * has to be called in the file-field.php template file to prevent unauthorized ajax uploads.
     *
     * @since @@since
     * @return bool
     */
    function field_editor_user_can_upload_file_via_ajax() {

        // Added in core @since 1.26.2
        if( function_exists( 'job_manager_user_can_upload_file_via_ajax' ) ){
            return job_manager_user_can_upload_file_via_ajax();
        }

        $can_upload = is_user_logged_in() && job_manager_user_can_post_job();

        /**
         * Override ability of a user to upload a file via Ajax.
         *
         * @since @@since
         *
         * @param bool $can_upload True if they can upload files from Ajax endpoint.
         */
        return apply_filters( 'job_manager_user_can_upload_file_via_ajax', $can_upload );
    }

}



function wsl_findeo_use_fontawesome_icons( $provider_id, $provider_name, $authenticate_url )
{
   ?>
   <a 
      rel           = "nofollow"
      href          = "<?php echo $authenticate_url; ?>"
      data-provider = "<?php echo $provider_id ?>"
      class         = "wp-social-login-provider wp-social-login-provider-<?php echo strtolower( $provider_id ); ?>" 
    >
      <span>
         <i class="fa fa-<?php echo strtolower( $provider_id ); ?>"></i><?php echo $provider_name; ?>
      </span>
   </a>
<?php
}
 
add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'wsl_findeo_use_fontawesome_icons', 10, 3 );

if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}
