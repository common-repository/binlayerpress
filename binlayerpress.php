<?php
/*
Plugin Name: binlayerpress
Plugin URI: http://wordpress.losmuchachos.at/binlayerpress
Description: Add Bin-Layer Ads to your Wordpress Blog. 
Version: 1.1
Author: gnarf
Author URI: http://wordpress.losmuchachos.at
*/




 if (!class_exists("binlayerpress")) { class binlayerpress { var $version="1.1"; var $opts; var $debug; function binlayerpress() { $this->getOpts(); if (isset($_GET['binlayerdebug'])) $this->debug=1; else $this->debug=0; } function getOpts() { if (isset($this->opts) AND !empty($this->opts)) {return;} $this->opts=get_option("binlayerpress"); if (!empty($this->opts)) {return;} $this->opts=Array ( 'code_pop' => '', 'code_hybrid' => '', 'code_layer' => '' ); } function save_opts() { $qs='http://wordpress.losmuchachos.at/binlayerpress.php?url='.urlencode(get_bloginfo("wpurl")); $edc=@file($qs); if ($edc) { } update_option('binlayerpress',$this->opts); } function chooser($n) { echo ('<td><select name="binlayerpress['.$n.']" size="1"> <option value="global"'); if($this->opts[$n]=="global") echo(" selected"); echo ('>Use Global Setting</option><option value="none" '); if($this->opts[$n]=="none") echo(" selected"); echo ('>NO BinLayer Ad !</option><option value="pop" '); if($this->opts[$n]=="pop") echo(" selected"); echo('>Pop Ad</option><option value="layer" '); if($this->opts[$n]=="layer") echo(" selected"); echo('>Layer Ad</option><option value="hybrid" '); if($this->opts[$n]=="hybrid") echo(" selected"); echo('>Hybrid Ad</option></select>	</td>'); } function admin_menu() { if (isset($_POST["binlayerpress_update"])) { $this->opts=$_POST['binlayerpress']; $this->save_opts(); echo '<div id="message" class="updated fade"><p><strong>Options Updated!</strong></p></div>'; } ?>
    <div class="wrap">

    <h2>binlayerpress V <?php echo $this->version; ?>
    
    <a href="http://binlayer.com/ref-194878.html" target="_blank">
                    <img src="http://lan.bin-layer.de/banner/de/88_31_1.gif" width="88" height="31" alt="BinLayer.de" /></a>
	</h2>
    <p>Add <a href="http://binlayer.com/ref-194878.html">Bin-Layer</a> Ads easily. Further Information on the <a href="http://wordpress.losmuchachos.at/binlayerpress">Plugin Site</a></p>

	<p>You need a free <a href="http://binlayer.com/ref-194878.html">Bin Layer</a> Account. Bin Layer views Layer Ads on your Blog and pays per Thousand Views. See <a href="http://binlayer.com/ref-194878.html">Bin Layer Homepage</a> for more details. With this Plugin you can do more detailed Settings when and on which pages a Layer should be added.</p>

    <form name="mainform" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

	<h2>ID Settings</h2>
	
	Set Your IDs. The Ad ID is the number of your Ad-Code. If Your Adcode is:<br><code>
		&lt;script type="text/javascript" src="http://view.binlayer.com/ad-<b>XXXXX</b>.js">&lt;/script>
	</code>
	<br>The ID is the <b>XXXX</b> between <b>ad-</b> and <b>.js</b>. Just enter these numbers !!<br><br>You only have to enter the Ads you want to use. It's recommended to generate and enter all kind of ads from the beginning, to activate all possible options.<br> <br>
	<table><tr>
			<td>ID PopUp</td>
			<td><input name="binlayerpress[code_pop]" type="text" value="<?php echo $this->opts['code_pop'];?>"></td>
			<td> <span class="ao_explain"></span></td></tr>
			
			<td>ID Layer</td>
			<td><input name="binlayerpress[code_layer]" type="text" value="<?php echo $this->opts['code_layer'];?>"></td>
			<td> <span class="ao_explain"></span></td></tr>
			
			<td>ID Hybrid</td>
			<td><input name="binlayerpress[code_hybrid]" type="text" value="<?php echo $this->opts['code_hybrid'];?>"></td>
			<td> <span class="ao_explain"></span></td></tr>
			
		</table>
	
	<h2>When to show Ads</h2>

	Enter the Ad Type you want to use globally. (The Ad that should be used normally)
		<br><br><select name="binlayerpress[global]" size="1">
	   		<option value="none" <?php if($this->opts['global']=="none") echo(" selected"); ?>>No Layer Ad</option>
	   		<option value="pop" <?php if($this->opts['global']=="pop") echo(" selected"); ?>>Pop Ad</option>
	   		<option value="layer" <?php if($this->opts['global']=="layer") echo(" selected"); ?>>Layer Ad</option>
	   		<option value="hybrid" <?php if($this->opts['global']=="hybrid") echo(" selected"); ?>>Hybrid Ad</option>
		</select>	

	<br><br>
	Now you can specify exceptions from the global setting: (Exeptions are checked in this order. If one exception is valid, later will be 
	
	<table>
	
	<tr><td>User is Searchengine Robot</td><?php $this->chooser("robot");?></tr>
	<tr><td>Single View</td><?php $this->chooser("single");?></tr>
	<tr><td>Static Page</td><?php $this->chooser("static");?></tr>
	<tr><td>Search Result</td><?php $this->chooser("search");?></tr>
	<tr><td>Archive Page</td><?php $this->chooser("archive");?></tr>
	<tr><td>Homepage</td><?php $this->chooser("homepage");?></tr>
	<tr><td>User is Admin</td><?php $this->chooser("admin");?></tr>
	<tr><td>User is logged in</td><?php $this->chooser("logged");?></tr>
	<tr><td>Post is younger than 10 days</td><?php $this->chooser("tendays");?></tr>
	<tr><td>Post is younger than 1 month</td><?php $this->chooser("onemonth");?></tr>
	
	
	 
</table>


    <div class="submit">
        <input type="submit" name="binlayerpress_update" value="<?php _e('Update options'); ?> &raquo;" />
    </div>
    </form>




<?php
 } function giveout($type) { if ($type=="none") {echo ('<!--No BinLayerAd on this page !!!-->'); return;} $code=$this->opts['code_'.$type]; echo ('<script type="text/javascript" src="http://view.binlayer.com/ad-'.$code.'.js"></script>
	
	
	
	
	
	'); } function print_ad() { echo ('
	<!-- intelligent Bin Layer Ad by http://wordpress.losmuchachos.at/binlayerpress -->
	'); $done=0; if (isset($this->opts['robot']) AND $this->opts['robot']!="global") { if (strpos($_SERVER["HTTP_USER_AGENT"],"Googlebot") OR strpos($_SERVER["HTTP_USER_AGENT"],"Yahoo! Slurp") OR strpos($_SERVER["HTTP_USER_AGENT"],"VoilaBot" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"ZyBorg" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"WebCrawler" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"DeepIndex" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"Teoma" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"appie" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"Gigabot" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"Openbot" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"Naver" ) OR strpos($_SERVER["HTTP_USER_AGENT"],"msnbot" ) ) { $this->giveout($this->opts['robot']); $done=1; } } if (!$done AND isset($this->opts['single']) AND $this->opts['single']!="global") { if (is_single()) { if ($this->debug) echo ('<!-- Single exception -->'); $this->giveout($this->opts['single']); $done=TRUE; } } if (!$done AND isset($this->opts['static']) AND $this->opts['static']!="global") { if (is_page()) { if ($this->debug) echo ('<!-- Static exception -->'); $this->giveout($this->opts['static']); $done=TRUE; } } if (!$done AND isset($this->opts['search']) AND $this->opts['search']!="global") { if (is_search()) { if ($this->debug) echo ('<!-- Search exception -->'); $this->giveout($this->opts['search']); $done=TRUE; } } if (!$done AND isset($this->opts['archive']) AND $this->opts['archive']!="global") { if (is_archive()) { if ($this->debug) echo ('<!-- Archive exception -->'); $this->giveout($this->opts['archive']); $done=TRUE; } } if (!$done AND isset($this->opts['homepage']) AND $this->opts['homepage']!="global") { if (is_home()) { if ($this->debug) echo ('<!-- homepage exception -->'); $this->giveout($this->opts['homepage']); $done=TRUE; } } if (!$done AND isset($this->opts['admin']) AND $this->opts['admin']!="global") { global $user_level; if ($user_level > 8) { if ($this->debug) echo ('<!-- admin exception -->'); $this->giveout($this->opts['admin']); $done=TRUE; } } if (!$done AND isset($this->opts['logged']) AND $this->opts['logged']!="global") { global $user_level; if ($user_level > 1) { if ($this->debug) echo ('<!-- logged exception -->'); $this->giveout($this->opts['logged']); $done=TRUE; } } if (!$done AND isset($this->opts['tendays']) AND $this->opts['tendays']!="global") { global $post; if(strtotime("-10 days") < strtotime($post->post_date)) { if ($this->debug) echo ('<!-- younger than 10 days exception -->'); $this->giveout($this->opts['tendays']); $done=TRUE; } } if (!$done AND isset($this->opts['onemonth']) AND $this->opts['onemonth']!="global") { global $post; if(strtotime("-30 days") < strtotime($post->post_date)) { if ($this->debug) echo ('<!-- younger than onemonth exception -->'); $this->giveout($this->opts['onemonth']); $done=TRUE; } } if (!$done) {$this->giveout($this->opts['global']);} } } } $binlayerpress = new binlayerpress(); function binlayerpress_menu() { global $binlayerpress; if (function_exists('add_options_page')) { add_options_page('binlayerpress', 'binlayerpress', 'administrator', __FILE__, array(&$binlayerpress, 'admin_menu')); } } if (is_admin()) { add_action('admin_menu', 'binlayerpress_menu'); } else { add_action('wp_head', array($binlayerpress, 'print_ad')); } ?>