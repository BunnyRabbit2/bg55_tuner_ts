
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="Forza Motorsport, Forza Horizon, Forza, Tuning Calculator, Forza Tuning, Up 2 Speed Customs, Lou-ne-tunes, U2SC, justlou72, Lou's Tunes, bigglou55, bg55">
	<!-- Edit the Three lines below as needed -->
	<meta name="description" content="FH5 Tuning Calculator">
	<title>FH5 Tuning Calculator</title>
	<!-- -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap.css" media="screen" rel="stylesheet">
	<script src="js/npm.js"></script>
	<script src="js/bootswatch.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</head>

<body class=" hasGoogleVoiceExt" style="background-color: #1a1a1a;">
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="navbar-main">
				<ul class="nav navbar-nav">
					<li><a href="bg55ftc-main.php">Forza Tuning Calculator</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other Versions <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="bg55ftc-main.php">Main Forza Calculator</a></li>
						<li><a href="bg55ftc-main-fh5.php">FH5 Only Calculator</a></li>
						<li><a href="bg55ftc-classic.php">Classic Calculator</a></li>
					</ul>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">FTC Resources <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="fm7-tuning-help.html" target="_blank">Forza Upgrades &amp; Tuning Assistant</a></li>
							<li>-------------------------</li>
                            <li><a href="https://www.dltuning.co.uk/" target="_blank">Dave Lacey's DLTuning Calculator</a></li>
							<li>-------------------------</li>
							<li><a href="http://www.rapid-racer.com/suspension-tuning.php" target="_blank">Rapid-Racer.com Suspension Tuning Guide</a></li>
							<li><a href="http://rapidtables.com/convert/color/index.htm" target="_blank">Color Conversion (to HSL)</a></li>
						</ul>
				</ul>
			</div>
		</div>
    </div>
    
	<div class="container-fluid" style="padding-left: 10%;padding-right: 10%">
		<br>
	<div class="jumbotron" id="banner">
		<h3 class="text-danger">Forza Horizon 5 Tuning Calculator (ALPHA)</h3>
        <br><i>For help with undertanding how all of the different parts work and/or help with tunings/fine-tuning, please check out the <a href="fm7-tuning-help.html" target="_blank">Forza Tuning Assistant</a>.</i>
	</div>

	<div>
		<a name="input"></a>
	</div>
	
<!-- BEGIN PHP SCRIPT -->

<?php
//==================================================================
// CORE PHP FUNCTIONS
//------------------------------------------------------------------
//==================================================================
// Error Reporting
//------------------------------------------------------------------
error_reporting(0); // Turn off all error reporting

//==================================================================
// BEGIN SCRIPT
//==================================================================

//==================================================================
// Core Tuning Entries
//------------------------------------------------------------------
$tunedatetime = date("d-M-Y Hi:s");
$rhf = number_format($_POST['rhf'], 1, '.', ''); // Front Ride Height
$rhr = number_format($_POST['rhr'], 1, '.', ''); // Rear Ride Height
if ($rhf == NULL) { $rhf = 0.0; }
if ($rhr == NULL) { $rhr = 0.0; }
$ovyear = $_POST['ovyear']; // Vehicle Year
$ovmake = $_POST['ovmake']; // Vehicle Make
$ovmodel = $_POST['ovmodel']; // Vehicle Model
if ($ovyear == NULL) { $ovyear = date("Y"); }
if ($ovmake == NULL) { $ovmake = "U2SC"; }
if ($ovmodel == NULL) { $ovmodel = date("l-Hi"); }
#----------------
$tirecomp = $_POST['tirecomp']; //getting tire compound
if ($tirecomp == NULL) { $tirecomp = "Stock"; }
$ftire = (int)$_POST['ftire']; // Front Tire Width
$fasp = (int)$_POST['fasp']; // Front Tire Aspect Ratio
$frim = (int)$_POST['frim']; // Front Rim Diameter
$samesize = $_POST['samesize']; // Square tire setup (front and rear same size)
if ($samesize == "Same") {
	$rtire = $ftire; // Rear Tire Width
	$rasp = $fasp; // Rear Tire Aspect Ratio
	$rrim = $frim; // Rear Rim Diameter
} else {
	$rtire = (int)$_POST['rtire']; // Rear Tire Width
	$rasp = (int)$_POST['rasp']; // Rear Tire Aspect Ratio
	$rrim = (int)$_POST['rrim']; // Rear Rim Diameter
}
// $fhdampermod = $_POST['fhdampermod']; // 
$power = (int)$_POST['hp']; // Max Power
$torque = (int)$_POST['tq']; // Max Torque
$weight = (int)$_POST['wght']; // Weight
$wpf = number_format((int)$_POST['wpf'], 0, '.', '');  // Weight Percentage Front (as whole number)
$dffront = number_format((int)$_POST['dff'], 0, '.', ''); // Downforce Front
$dfrear = number_format((int)$_POST['dfr'], 0, '.', ''); // Downforce Rear
$gamever = $_POST['gamever']; // Game Verison
if ($gamever == NULL) { $gamever = "FH5"; }
$gameverstat = $gamever;
$StiffType = $_POST['stifftype']; // Damper Stiffness
if ($StiffType == NULL) { $StiffType = "Normal"; }
$TravType = $_POST['travtype']; // Damper Travel
if ($TravType == NULL) { $TravType = "Average"; }

//------------------------------------------------------------------
// Transmission Tuning Entries
//------------------------------------------------------------------
$redline = (int)$_POST['redline']; // Redline RPM
if ($redline == NULL) { $redline = 0; }
$topspeed = (int)$_POST['topspd']; // Input Top Speed
if ($topspeed == NULL) { $topspeed = 0; }
$numgears = (int)$_POST['numgears']; //Number of Forward Gears
if ($numgears <= 0) { $numgears = 6; }

//------------------------------------------------------------------
// Advanced Data Input
//------------------------------------------------------------------
$resetdmod = $_POST['resetdmod']; // Reset advanced drivetrain input requested
if ($resetdmod == "reset") {
	$fdratiog = 0;
	$fdratioo = 0;
	$cfirstg = 0;
	$cfirstgr = 0;
	$cspeedfirstg = 0;
	$cspeedf = 0;
	$speedfirst = 0;
} else {
	$fdratioo = number_format($_POST['fdratio'], 2, '.', ''); //Number of Forward Gears
	if ($fdratioo !== 0) { $fdratiog = $fdratioo; }
	$cfirstg = number_format($_POST['firstg'], 2, '.', ''); //Custom 1st gear ratio
	$cspeedfirst = number_format($_POST['speedfirst'], 2, '.', ''); // Input 1st gear Top Speed
	if ($cspeedfirst !== 0) { $cspeedfirstg = $cspeedfirst; }		
}
$resetsmod = $_POST['resetsmod']; // Reset to default fine-tuning requested
if ($resetsmod == "reset") {
	$csmod = number_format(1.00, 2, '.', '');
	$csmodf = "$csmod x";
} else {
    $cstiffn = $_POST['cstiff'];
    if ($cstiffn == NULL) { $cstiffn = number_format(1.00, 2, '.', ''); }
    $csmod = number_format(($cstiffn), 2, '.', '');
}

//==================================================================
//==================================================================
// Metric Conversions For Calculations
//------------------------------------------------------------------
$units = $_POST['units']; // Imperial or Metric
if ($units == NULL) { $units = "Imperial"; }
if ($units == 'Metric') {
	$metric = 1;
} elseif ($units == 'Imperial') {
	$metric = 0;
}
if ($metric == 1) {
	$rhtag = 'mm';
	$prtag = 'bar';
	$pwtag = 'kw';
	$tqtag = 'Nm';
	$wtag = 'kg';
	$stag = 'kph';
	$pwrtag = 'kg/kw';
	$wght = $weight; // Preserve form input
	$dff = $dffront; // Preserve form input
	$dfr = $dfrear; // Preserve form input
	$hp = $power; // Preserve form input
	$tq = $torque; // Preserve form input
	$tspeed = $topspeed; // Preserve form input
	$cspeedf = $cspeedfirst; // Preserve form input
	// Convert to Imperial for certain formulas to work.
	$dff = $dff * 2.20462;
	$dfr = $dfr * 2.20462;
	$wght = $wght * 2.20462;
	$hp = $hp * 1.34102; // convert KW to HP for modifier calculations 
	$tq = $tq * 0.7375621483695506; // convert Nm to lb-ft for modifier calculations
	$cspeedfirst = number_format(($cspeedfirst * 0.621371), 1, '.', ''); // convert to KPH to MPH for calculations
	if ($topspeed !== 0) { $topspeed = number_format(($topspeed * 0.621371), 1, '.', ''); } // convert to KPH to MPH for calculations
	$pwr = number_format(($weight / $power), 2, '.', ''); // Power to Weight Ratio
} else {
	$rhtag = 'in';
	$prtag = 'psi';
	$pwtag = 'HP';
	$tqtag = 'LB-FT';
	$wtag = 'lbs';
	$stag = 'mph';
	$pwrtag = 'lbs/HP';
	$wght = $weight; // Preserve form input
	$dff = $dffront; // Preserve form input
	$dfr = $dfrear; // Preserve form input
	$hp = $power; // Preserve form input
	$tq = $torque; // Preserve form input
	$tspeed = $topspeed; // Preserve form input
	$cspeedf = $cspeedfirst; // Preserve form input
	$pwr = number_format(($weight / $power), 2, '.', ''); // Power to Weight Ratio
}
//==================================================================
//==================================================================

//------------------------------------------------------------------
// Determine Tune Type
//------------------------------------------------------------------
$ttype = $_POST['ttype']; // Tune Type - Circuit, Drag or Drift
if ($ttype == NULL) { $ttype = 'Circuit'; }
$drivetype = $_POST['drivetype']; // Drive Type
$elayout = $_POST['elayout']; // Engine Layout
if ($elayout == NULL) { $elayout = 'front'; }
if ($elayout == 'front') { $elayoutd = 'Front Engine'; }
if ($elayout == 'mid') { $elayoutd = 'Mid Engine'; }
if ($elayout == 'rear') { $elayoutd = 'Rear Engine'; }
$ttyped = "$gameverstat $ttype";
$offroad = 0;
$drag = 0;
$drift = 0;
if ($ttype == 'Drift') { $drift = 1; }      
if ($ttype == 'Drag') { $drag = 1; }      
if ($ttype == 'Rally') { $offroad = 1; }      
if ($ttype == 'Offroad') { $offroad = 2; }

//==================================================================
//==================================================================
// General Calculations
//------------------------------------------------------------------

//------------------------------------------------------------------
// Setting Front and Rear Weight Calculations & Other Special Vars
//------------------------------------------------------------------
$dft = ($dff + $dfr);
$wpr = (int)(100 - $wpf); // Weight Percentage Rear (whole number)
$wpfd = number_format(($wpf/100), 3, '.', ''); // Weight Percentage Front (decimal)
$wprd = number_format(($wpr/100), 3, '.', ''); // Weight Percentage Rear (decimal)
$wghtf = number_format(($wght * ($wpf/100)), 1, '.', '');
$wghtf = ($wghtf + $dff);
$wghtr = number_format(($wght * ($wpr/100)), 1, '.', '');
$wghtr = ($wghtr + $dfr);
if ($wpf !== 50) {
	$wpm = (($wpf - 50) / 2);
} else {
	$wpm = 0;
}
// Setting Weight % modifiers
$wpmf = 1;
$wpmr = 1;
if ($wpfd > .50) {
	$wpmf = (1 + ($wpfd - .50));
	$wpmr = (1 - (.50 - $wprd));
}
if ($wpf < .50) {
	$wpmf = (1 - (.50 - $wpfd));
	$wpmr = (1 + ($wprd - .50));
}

//------------------------------------------------------------------
// STIFFNESS values and modifiers
//------------------------------------------------------------------
$StiffTyped = "Normal";
$springstmod = 1.00;
$arbstmod = 1.00;
if ($StiffType == "Firm2") {
    $StiffTyped = "Firmest";
    $springstmod = 1.1;
}
if ($StiffType == "Firm") {
    $StiffTyped = "Firmer";
    $springstmod = 1.05;
}
if ($StiffType == "Soft") {
    $StiffTyped = "Softer";
    $springstmod = 0.95;
}
if ($StiffType == "Soft2") {
    $StiffTyped = "Softest";
    $springstmod = 0.90;
}
// MIN/MAX checks
if ($csmod > 2.00) {
	$csmod = number_format(1.00, 2, '.', '');
	$csmodf = "ERROR";
} else {
	$csmodf = "$csmod x";
}

//==================================================================
//==================================================================
// Calculate Tire Ratios
//------------------------------------------------------------------
$tireavg = (($ftire + $rtire) / 2);
$tirefrat = ($ftire / $tireavg);
$tirerrat = ($rtire / $tireavg);

//------------------------------------------------------------------
// Setting Rear tire multiplier for brake balance calculations
//------------------------------------------------------------------
$tiredmulti = 0;
$tirediff = ($rtire - $ftire);
if ($tirediff >= 20) { $tiredmulti++; }
if ($tirediff >= 40) { $tiredmulti++; }
if ($tirediff >= 60) { $tiredmulti++; }
if ($tirediff >= 80) { $tiredmulti++; }

//------------------------------------------------------------------
// Advanced Tire calculations
//------------------------------------------------------------------
if ($metric == 1) {
	$tireunitl = "mm";
	$tireunitv = "L";
	// metric front tire
	$ftw = $ftire;
	$fth = ($ftw * ($fasp/100));
	$ftr = ($frim * 25.4);
	// metric rear tire;
	$rtw = $rtire;
	$rth = ($rtw * ($rasp/100));
	$rtr = ($rrim * 25.4);
} else {
	$tireunitl = "in";
	$tireunitv = "cu ft";
	// imperial front tire
	$ftw = ($ftire / 25.4);
	$fth = ($ftw * ($fasp/100));
	$ftr = $frim;
	// imperial rear tire;
	$rtw = ($rtire / 25.4);
	$rth = ($rtw * ($rasp/100));
	$rtr = $rrim;
}
// Front Tires
$ftd = ($fth + $fth + $ftr);
$ftri = ($ftr / 2);
$ftro = ($ftd / 2);
$ftvi = (3.14159265359 * ($ftri * $ftri) * $ftw);
$ftvo = (3.14159265359 * ($ftro * $ftro) * $ftw);
// Rear Tires
$rtd = ($rth + $rth + $rtr);
$rtri = ($rtr / 2);
$rtro = ($rtd / 2);
$rtvi = (3.14159265359 * ($rtri * $rtri) * $rtw);
$rtvo = (3.14159265359 * ($rtro * $rtro) * $rtw);
// Final Calculations
$ftc = number_format((2 * 3.14159265359 * $ftro), 2, '.', '');
$rtc = number_format((2 * 3.14159265359 * $rtro), 2, '.', '');
if ($metric == 1) {
	$ftv = number_format((($ftvo - $ftvi) / 1000)/1000, 2, '.', '');
	$rtv = number_format((($rtvo - $rtvi) / 1000)/1000, 2, '.', '');
} else {
	$ftv = number_format(($ftvo - $ftvi)/1728, 2, '.', '');
	$rtv = number_format(($rtvo - $rtvi)/1728, 2, '.', '');	
}

//==================================================================
//==================================================================
// SRING RATE
//------------------------------------------------------------------

// Modifiers
$wpfds = $wpfd; // Front Weight percentage in decimal form
$sstiffmod = $springstmod; //setting based on stiffness/travel
$weightmod = 0.85; //used to dial in the spring rates
$ttypesprmod = 1.0;
if ($ttype == 'Rally') { $ttypesprmod = 0.667; }
if ($ttype == 'Offroad') { $ttypesprmod = 0.333; }

// Calculating Spring Rates
$srate = ($wght * $weightmod * $springstmod * $ttypesprmod) / 2;
$fsrate = ($srate * $wpfds) + ($dff/10);
$rsrate = ($srate - $fsrate) + ($dfr/10);
if ($metric == 1) {
    $fsrate = $fsrate * 0.453592;
    $rsrate = $rsrate * 0.453592;
    $srfa = number_format($fsrate * 0.3937, 1, '.', '');
    $srra = number_format($rsrate * 0.3937, 1, '.', '');
} else {
    $srfa = number_format($fsrate, 1, '.', '');
    $srra = number_format($rsrate, 1, '.', '');
}

// Apply Spring User Fine-Tuning Stiffness Modifier
$srfa = number_format($srfa * $csmod, 1, '.', '');
$srra = number_format($srra * $csmod, 1, '.', '');

//==================================================================
//==================================================================
// Determine PSI/BAR
//------------------------------------------------------------------
$fpsi = 30.0;
$rpsi = 30.0;
if ($offroad == 1) {
	$fpsi = 25.0;
	$rpsi = 25.0;	
}
if ($offroad == 2) {
	$fpsi = 20.0;
	$rpsi = 20.0;	
}
//Weight Mods
$fwcalc = $wghtf;
$rwcalc = $wghtr;
while ($fwcalc > 1600) {
	$fpsi = $fpsi + 0.5;
	$fwcalc = $fwcalc - 200;
}
while ($rwcalc > 1600) {
	$rpsi = $rpsi + 0.5;
	$rwcalc = $rwcalc - 200;
}
while ($fwcalc < 1600) {
	$fpsi = $fpsi - 0.5;
	$fwcalc = $fwcalc + 200;
}
while ($rwcalc < 1600) {
	$rpsi = $rpsi - 0.5;
	$rwcalc = $rwcalc + 200;
}
if ($fpsi > 45.0) {$fpsi = 45.0;}
if ($fpsi < 15.0) {$fpsi = 15.0;}
if ($rpsi > 45.0) {$rpsi = 45.0;}
if ($rpsi < 15.0) {$rpsi = 15.0;}
//METRIC
if ($metric == 1) {
	$rbar = ($rpsi * 0.0689475729);
	$fbar = ($fpsi * 0.0689475729);
	$rpsi = round($rbar, 2);
	$fpsi = round($fbar, 2);
}

//==================================================================
//==================================================================
// Determine Brake Settings
//------------------------------------------------------------------
$brfor = '~130';
if (($tirecomp == "Race") or ($tirecomp == "Semi") or ($tirecomp == "Drift") OR ($tirecomp == "VintR") OR ($tirecomp == "Drag")) {
	$brfor = '~140';
}
$brbal = 50;
if ($wpf > 58) { $brbal = $brbal - 1; }
if ($wpf > 54) { $brbal = $brbal - 1; }
if ($wpf < 46) { $brbal = $brbal + 1; }
if ($wpf < 42) { $brbal = $brbal + 1; }
if ($offroad > 0) {$brbal = $brbal -1;}

//==================================================================
//==================================================================
// Determine Differential Settings
//------------------------------------------------------------------
$rdiff = 'X';
$rdiffd = 'X';
$fdiff = 'X';
$fdiffd = 'X';
$cdiff = 'X';
// Rear Diff
if (($drivetype == 'RWD') OR ($drivetype == 'AWD')) {
	// Setting Offroad, Drift & Drag
	$rdiff = 50;
	$rdiffd = 25;	
	if ($ttype == 'Offroad') {
        $rdiff = 80;
        $rdiffd = 60;
    }
	if ($ttype == 'Rally') {
        $rdiff = 60;
        $rdiffd = 30;
	}
	if ($ttype == 'Drift') {
        $rdiff = 100;
        $rdiffd = 1;
	}
	if ($rdiff > 100) { $rdiff = 100; }
	if ($rdiffd < 0) { $rdiffd = 0; }
	$wpcalc = $wpf;
	//weight mods
	while ($wpcalc > 51) {
		$rdiff = $rdiff + 1;
		$rdiffd = $rdiffd - 1;
		$wpcalc = $wpcalc - 1;
	}
	while ($wpcalc < 49) {
		$rdiff = $rdiff - 1;
		$rdiffd = $rdiffd + 1;
		$wpcalc = $wpcalc + 1;
	}
	if ($elayout == 'mid') {
		$rdiff = $rdiff - 4;
		$rdiffd = $rdiffd + 4;
	}
	if ($elayout == 'rear') {
		$rdiff = $rdiff - 8;
	}	$rdiffd = $rdiffd + 8;
	//min-max
	if ($rdiff > 100) {$rdiff = 100;}
	if ($rdiffd < 0) {$rdiffd = 0;}
}
// Front Diff
if (($drivetype == 'FWD') OR ($drivetype == 'AWD')) {
	$fdiff = 30;
	$fdiffd = 5;	
	if ($ttype == 'Offroad') {
        $fdiff = 80;
        $fdiffd = 60;
    }
	if ($ttype == 'Rally') {
        $fdiff = 40;
        $fdiffd = 20;
	}
	if ($ttype == 'drift') {
        $fdiff = 15;
        $fdiffd = 0;
	}
	//weight mods
	$wpcalc = $wpf;
	while ($wpcalc > 51) {
		$fdiff = $fdiff - 1;
		$fdiffd = $fdiffd + 1;	
		$wpcalc = $wpcalc - 1;
	}
	while ($wpcalc < 49) {
		$fdiff = $fdiff + 1;
		$fdiffd = $fdiffd - 1;	
		$wpcalc = $wpcalc + 1;
	}
	//min-max
	if ($fdiff > 100) {$fdiff = 100;}
	if ($fdiffd < 0) {$fdiffd = 0;}
}
// Center Diff
if ($drivetype == 'AWD') {
	$cdiff = 65;
	if ($ttype == 'Offroad') { $cdiff = 55; }
	if ($ttype == 'Rally') { $cdiff = 60; }
	if ($ttype == 'drift') { $cdiff = 90; }
	// Modifying Center Diff based on engine placement
	if ($elayout == 'mid') { $cdiff = $cdiff + 4; }
	if ($elayout == 'rear') { $cdiff = $cdiff + 8; }
	//weight mods
	$wpcalc = $wpf;
	while ($wpcalc < 50) {
		$cdiff = $cdiff + 1;
		$wpcalc = $wpcalc + 1;
	}
	//min-max
	if ($cdiff > 100) { $cdiff = 100; }
}
// Engine Layout Mods

//==================================================================
//==================================================================
// Drift Tuning Adjustments
//------------------------------------------------------------------

if ($ttype == 'Drift') {
	$caster = number_format(7.0, 1, '.', '');
    $toef = number_format(($toef - 0.0), 1, '.', '');
	$toer = number_format(($toer - 0.0), 1, '.', '');
	$camf = number_format(($camf - 2.0), 1, '.', '');
	$camr = number_format(($camr -0.0), 1, '.', '');
	$arbf = number_format(($arbf * 1.5), 1, '.', '');
	$arbr = number_format(($arbr * 1.5), 1, '.', '');
	$srfa = number_format(($srfa * 1.2), 1, '.', '');
	$srra = number_format(($srra * 1.2), 1, '.', '');
	$bumpf = number_format(($bumpf * 1.0), 1, '.', '');
	$bumpr = number_format(($bumpr * 1.0), 1, '.', '');
	$rebf = number_format(($rebf * 1.0), 1, '.', '');
	$rebr = number_format(($rebr * 1.0), 1, '.', '');
	$brbal = $brbal - 2;
	$brfor = '~140';
}

//==================================================================
//==================================================================
// BEGIN DRAG TUNING
//------------------------------------------------------------------

if ($drag == 1) {
    // FM7 ARB Range = 1.0 to 40.0
    $arbf = 1.0;
    $arbr = 40.0;
    // FM7 B&R Range = 1.0 to 14.0
    $rebf = 1.0;
    $rebr = 14.0;
    $bumpf = 14.0;
    $bumpr = 14.0;
	$srfa = "&darr;&darr; MIN &darr;&darr;";
	$srra = "&uarr;&uarr; MAX &uarr;&uarr;";
	$camf = -0.5;
	$camr = -0.5;
	$toef = -0.1;
	$toer = -0.1;
	$caster = 5.0;
	$brbal = 10;
	$brfor = 150;
	$rhf = "&uarr;&uarr; MAX &uarr;&uarr;";
	$rhr = "&uarr;&uarr; MAX &uarr;&uarr;";
	
	// Differential
	if ($drivetype == 'RWD') {
		$rdiff = 100;
		$rdiffd = 90;
		$fpsi = 35.0;
		$rpsi = 25.0;
	}
    if ($drivetype == 'FWD') {
		$fdiff = 100;
		$fdiffd = 90;
		$fpsi = 25.0;
		$rpsi = 35.0;
	}
    if ($drivetype == 'AWD') {
		$fdiff = 100;
		$fdiffd = 90;
		$rdiff = 100;
		$rdiffd = 90;
		$cdiff = 75;
		$fpsi = 27.5;
		$rpsi = 25.0;
	}
	if ($metric == 1) {
		$rbar = ($rpsi * 0.0689475729);
		$fbar = ($fpsi * 0.0689475729);
		$rpsi = round($rbar, 2);
		$fpsi = round($fbar, 2);
	}
}

//==================================================================
//==================================================================
// BEGIN Tuning Gear Ratios
//------------------------------------------------------------------
// Setting Gear Ratio Variables
//------------------------------------------------------------------
$fdratio = 'X'; 
$firstg = 'X';
$secondg = 'X';
$thirdg = 'X';
$fourthg = 'X';
$fifthg = 'X';
$sixthg = 'X';
$seventhg = 'X';
$eighthg = 'X';
$ninthg = 'X';
$tenthg = 'X';
$eleventhg = 'X';
$twelvethg = 'X';

If ($redline !== 0)	{
	if ($topspeed == 0) { 
		$topspeed = 145;
		$hpcalc = $hp;
		while ($hpcalc >= 175 and $topspeed <= 265) {
			$topspeed = $topspeed + 15;
			$hpcalc = $hpcalc - 100;
		}
		if ($metric == 1) {
			$tspeed = ($topspeed * 1.60934);
		} else {
			$tspeed = $topspeed;
		}
	}

	// Calculate info drive axle tire diameter.  Rear axle is used for 'AWD'.
	if ($drivetype == 'FWD') { 
		$tdiam = (($ftire * $fasp) + (1270 * $frim)) / (1270); // calculates front tire diameter
	} else {
		$tdiam = (($rtire * $rasp) + (1270 * $rrim)) / (1270); // calculates rear tire diameter
	}

	// Check for custom 1st gear ratio and set default value if not provided
	if ($cfirstg > 0) {
		$firstg = $cfirstg;
		$cfirstgr = $firstg; //setting display for form data
	} elseif ($redline > 17000) {
		$firstg = 5.50; // Setting for Formula E
		$cfirstgr = $firstg; //setting display for form data
	} else {
		if ($drivetype == 'RWD') {
			$firstg = 2.90;
			$gearcalc = $numgears;
			while ($gearcalc > 4) {
				$firstg = $firstg + 0.05;
				$gearcalc = $gearcalc - 1;
			}
		}
		if ($drivetype == 'FWD') {
			$firstg = 3.05;
			$gearcalc = $numgears;
			while ($gearcalc > 4) {
				$firstg = $firstg + 0.05;
				$gearcalc = $gearcalc - 1;
			}
		}
		if ($drivetype == 'AWD') {
			$firstg = 3.20;
			$gearcalc = $numgears;
			while ($gearcalc > 4) {
				$firstg = $firstg + 0.05;
				$gearcalc = $gearcalc - 1;
			}
		}
	}
	
	//checks for custom 1st gear speed and calculates one if not provided
	if ($cspeedfirst > 0) {
		$speedfirst = $cspeedfirst;
	} elseif ($redline > 17000) {
		$speedfirst = 65; // Setting for Formula E
	} else {
		if ($numgears == 3) { $speedfirst = (($topspeed / $numgears) + 5); }
		if ($numgears == 4) { $speedfirst = (($topspeed / $numgears) + 10); }
		if ($numgears == 5) { $speedfirst = (($topspeed / $numgears) + 15); }
		if ($numgears == 6) { $speedfirst = (($topspeed / $numgears) + 20); }
		if (($numgears == 6) && ($hp >= 400)) { $speedfirst = (($topspeed / $numgears) + 25); }
		if (($numgears == 6) && ($hp >= 600)) { $speedfirst = (($topspeed / $numgears) + 30); }
		if (($numgears == 6) && ($hp >= 800)) { $speedfirst = (($topspeed / $numgears) + 35); }
		if ($numgears == 7) { $speedfirst = (($topspeed / $numgears) + 25); }
		if (($numgears == 7) && ($hp >= 400)) { $speedfirst = (($topspeed / $numgears) + 30); }
		if (($numgears == 7) && ($hp >= 600)) { $speedfirst = (($topspeed / $numgears) + 35); }
		if (($numgears == 7) && ($hp >= 800)) { $speedfirst = (($topspeed / $numgears) + 35); }
		if ($numgears >= 8) { $speedfirst = (($topspeed / $numgears) + 30); }
		if (($numgears >= 8) && ($hp >= 400)) { $speedfirst = (($topspeed / $numgears) + 35); }
		if (($numgears >= 8) && ($hp >= 600)) { $speedfirst = (($topspeed / $numgears) + 40); }
		if (($numgears >= 8) && ($hp >= 800)) { $speedfirst = (($topspeed / $numgears) + 45); }
		if ($drivetype == 'AWD') { $speedfirst = ($speedfirst * 0.86); }
	}
	if ($fdratioo > 0) {
		$fdratio = $fdratioo;
	} else {
		$fdratio = number_format(($redline * $tdiam) / ($speedfirst * $firstg * 336.13), 2, '.', '');
	}
	$changespeed = ($topspeed - $speedfirst) / ($numgears - 1);
	$gearspeed = $speedfirst;
	$numgearsp = 2;
	$firstg = number_format($firstg, 2, '.', '');

	// Setting other gear ratios
	while ($numgearsp <= $numgears) {
		$gearspeed = $gearspeed + $changespeed;
		if ($numgearsp == 2) { $secondg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 3) { $thirdg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 4) { $fourthg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 5) { $fifthg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 6) { $sixthg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 7) { $seventhg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 8) { $eighthg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 9) { $ninthg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 10) { $tenthg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 11) { $eleventhg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		if ($numgearsp == 12) { $twelvethg = number_format(($redline * $tdiam) / ($gearspeed * $fdratio * 336.13), 2, '.', ''); }
		$numgearsp++;
	}
}

//------------------------------------------------------------------
// Assemble Gear Ratio Output
//------------------------------------------------------------------
if ($numgears == 1) {$gearratios = "<small>(1) $firstg</small>";}
if ($numgears == 2) {$gearratios = "<small>(1) $firstg - (2) $secondg</small>";}
if ($numgears == 3) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg</small>";}
if ($numgears == 4) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg</small>";}
if ($numgears == 5) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg</small>";}
if ($numgears == 6) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg - (6) $sixthg</small>";}
if ($numgears == 7) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg - (6) $sixthg - (7) $seventhg</small>";}
if ($numgears == 8) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg - (6) $sixthg - (7) $seventhg - (8) $eighthg</small>";}
if ($numgears == 9) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg - (6) $sixthg - (7) $seventhg - (8) $eighthg - (9) $ninthg</small>";}
if ($numgears == 10) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg - (6) $sixthg - (7) $seventhg - (8) $eighthg - (9) $ninthg - (10) $tenthg</small>";}
if ($numgears == 11) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg - (6) $sixthg - (7) $seventhg - (8) $eighthg - (9) $ninthg - (10) $tenthg - (10) $eleventhg</small>";}
if ($numgears == 12) {$gearratios = "<small>(1) $firstg - (2) $secondg - (3) $thirdg - (4) $fourthg - (5) $fifthg - (6) $sixthg - (7) $seventhg - (8) $eighthg - (9) $ninthg - (10) $tenthg - (10) $eleventhg - (10) $twelvethg</small>";}
if ($metric == 1) { $speedfirst = number_format(($speedfirst * 1.60934), 2, '.', ''); }

//==================================================================
//==================================================================

//==================================================================
//==================================================================
// Zero out form data if no weight is input.  This keeps ratios private and keeps the form clean on first load.

if ($wght == 0) {
	$fpsi = "X";
	$rpsi = "X";
	$arbf = "X";
	$arbr = "X";
	$srfa = "X";
	$srra = "X";
	$rebf = "X";
	$rebr = "X";
	$bumpf = "X";
	$bumpr = "X";
	$camf = "X";
	$camr = "X";
	$toef = "X";
	$toer = "X";
	$caster = "X";
	$brbal = "X";
	$brfor = "X";
	$arbf3 = "X";
	$arbr3 = "X";
	$rebf3r = "X";
	$rebr3r = "X";
	$bumpf3r = "X";
	$bumpr3r = "X";
	$rebf3o = "X";
	$rebr3o = "X";
	$bumpf3o = "X";
	$bumpr3o = "X";
	$arbf6 = "X";
	$arbr6 = "X";
	$rebf6 = "X";
	$rebr6 = "X";
	$bumpf6 = "X";
	$bumpr6 = "X";
	$cdiff = "X";
	$fdiff = "X";
	$fdiffd = "X";
	$rdiff = "X";
	$rdiffd = "X";
	$arbfraw = "X";
	$arbrraw = "X";
}
//==================================================================
//==================================================================

	
//==================================================================
//==================================================================
// Form Selection calculations for setting previous selection to make sticky


//------------------------------------------------------------------
// Units Selection
//------------------------------------------------------------------
$units01 = '<option value="Imperial">Imperial Units</option>';
if ($units == "Imperial") { $units01 = '<option value="Imperial" selected>Imperial Units</option>'; }
        
$units02 = '<option value="Metric">Metric Units</option>';
if ($units == "Metric") { $units02 = '<option value="Metric" selected>Metric Units</option>'; } 

//------------------------------------------------------------------
// Tune Type Selection
//------------------------------------------------------------------
$tt01 = '<option value="Circuit">Circuit/Street</option>';
if ($ttype == "Circuit") { $tt01 = '<option value="Circuit" selected>Circuit/Street</option>'; }
        
$tt02 = '<option value="Drag">Drag</option>';
if ($ttype == "Drag") { $tt02 = '<option value="Drag" selected>Drag</option>'; }
        
$tt03 = '<option value="Drift">Drift</option>';
if ($ttype == "Drift") { $tt03 = '<option value="Drift" selected>Drift</option>'; }
        
$tt04 = '<option value="Rally">Rally</option>';
if ($ttype == "Rally") { $tt04 = '<option value="Rally" selected>Rally</option>'; }
        
$tt05 = '<option value="Offroad">Off-road</option>';
if ($ttype == "Offroad") { $tt05 = '<option value="Offroad" selected>Off-road</option>'; }
        
//------------------------------------------------------------------
// Drive Type Selection
//------------------------------------------------------------------
$dtrwd = '<option value="RWD">RWD</option>';
if ($drivetype == 'RWD') {$dtrwd = '<option value="RWD" selected>RWD</option>';}
        
$dtfwd = '<option value="FWD">FWD</option>';
if ($drivetype == 'FWD') {$dtfwd = '<option value="FWD" selected>FWD</option>';}
        
$dtawd = '<option value="AWD">AWD</option>';
if ($drivetype == 'AWD') {$dtawd = '<option value="AWD" selected>AWD</option>';}

//------------------------------------------------------------------
// Tire Type Selection
//------------------------------------------------------------------
$tirestock = '<option value="Stock">Stock</option>';
if ($tirecomp == "Stock") {$tirestock = '<option value="Stock" selected>Stock</option>';}

$tirestreet = '<option value="Street">Street</option>';
if ($tirecomp == "Street") {$tirestreet = '<option value="Street" selected>Street</option>';}

$tiresport = '<option value="Sport">Sport</option>';
if ($tirecomp == "Sport") {$tiresport = '<option value="Sport" selected>Sport</option>';}

$tiresemi = '<option value="Semi">Semi-Slick</option>';
if ($tirecomp == "Semi") {$tiresemi = '<option value="Semi" selected>Semi-Slick</option>';}

$tirerace = '<option value="Race">Race Slick</option>';
if ($tirecomp == "Race") {$tirerace = '<option value="Race" selected>Race Slick</option>';}

$tiredrag = '<option value="Drag">Drag</option>';
if ($tirecomp == "Drag") {$tiredrag = '<option value="Drag" selected>Drag</option>';}

$tiredrift = '<option value="Drift">Drift</option>';
if ($tirecomp == "Drift") {$tiredrift = '<option value="Drift" selected>Drift</option>';}

$tirerally = '<option value="Rally">Rally</option>';
if ($tirecomp == "Rally") {$tirerally = '<option value="Rally" selected>Rally</option>';}

$tireoffroad = '<option value="Offroad">Offroad</option>';
if ($tirecomp == "Offroad") {$tireoffroad = '<option value="Offroad" selected>Offroad</option>';}

$tirewinter = '<option value="Winter">Snow</option>';
if ($tirecomp == "Winter") {$tirewinter = '<option value="Winter" selected>Snow</option>';}

$tirevintr = '<option value="VintR">Vintage Race</option>';
if ($tirecomp == "VintR") {$tirewinter = '<option value="VintR" selected>Vintage Race</option>';}

$tirevintw = '<option value="VintW">Vintage White Wall</option>';
if ($tirecomp == "VintW") {$tirewinter = '<option value="VintW">Vintage White Wall</option>';}

//------------------------------------------------------------------
// Game Version
//------------------------------------------------------------------

$gver1 = '<option value="FH5">Horizon 5</option>';
if ($gameverstat == "FH5") {$gver1 = '<option value="FH5" selected>Horizon 5</option>';}

//------------------------------------------------------------------
// Same Size Checkbox check
//------------------------------------------------------------------

if ($samesize == "Same") {
	$sizecheck = " checked";
} else {
	$sizecheck = "";
}

//------------------------------------------------------------------
// Number of Gears
//------------------------------------------------------------------
$ng1 = '<option value="1">1</option>';
if ($numgears == 1) { $ng1 = '<option value="1" selected>1</option>'; }

$ng2 = '<option value="2">2</option>';
if ($numgears == 2) { $ng2 = '<option value="2" selected>2</option>'; }
        
$ng3 = '<option value="3">3</option>';
if ($numgears == 3) { $ng3 = '<option value="3" selected>3</option>'; }
        
$ng4 = '<option value="4">4</option>';
if ($numgears == 4) { $ng4 = '<option value="4" selected>4</option>'; }
        
$ng5 = '<option value="5">5</option>';
if ($numgears == 5) { $ng5 = '<option value="5" selected>5</option>'; }
        
$ng6 = '<option value="6">6</option>';
if ($numgears == 6) { $ng6 = '<option value="6" selected>6</option>'; }
        
$ng7 = '<option value="7">7</option>';
if ($numgears == 7) { $ng7 = '<option value="7" selected>7</option>'; }
        
$ng8 = '<option value="8">8</option>';
if ($numgears == 8) { $ng8 = '<option value="8" selected>8</option>'; }
        
$ng9 = '<option value="9">9</option>';
if ($numgears == 9) { $ng9 = '<option value="9" selected>9</option>'; }
        
$ng10 = '<option value="10">10</option>';
if ($numgears == 10) { $ng10 = '<option value="10" selected>10</option>'; }
        
$ng11 = '<option value="11">11</option>';
if ($numgears == 11) { $ng11 = '<option value="11" selected>11</option>'; }


//------------------------------------------------------------------
// Suspension Stiffness Type
//------------------------------------------------------------------
$StiffType1 = '<option value="Normal">Average</option>';
if ($StiffType == "Normal") { $StiffType1 = '<option value="Normal" selected>Average</option>'; }
        
$StiffType2 = '<option value="Firm">Firmer</option>';
if ($StiffType == "Firm") { $StiffType2 = '<option value="Firm" selected>Firmer</option>'; }
        
$StiffType3 = '<option value="Soft">Softer</option>';
if ($StiffType == "Soft") { $StiffType3 = '<option value="Soft" selected>Softer</option>'; }
        
$StiffType4 = '<option value="Firm2">Firmest</option>';
if ($StiffType == "Firm2") { $StiffType4 = '<option value="Firm2" selected>Firmest</option>'; }
        
$StiffType5 = '<option value="Soft2">Softest</option>';
if ($StiffType == "Soft2") { $StiffType5 = '<option value="Soft2" selected>Softest</option>'; }


//------------------------------------------------------------------
// Engine Location
//------------------------------------------------------------------
$elayout1 = '<option value="front">Front-Eng</option>';
if ($elayout == "front") { $elayout1 = '<option value="front" selected>Front-Eng</option>'; }

$elayout2 = '<option value="mid">Mid-Eng</option>';
if ($elayout == "mid") { $elayout2 = '<option value="mid" selected>Mid-Eng</option>'; }

$elayout3 = '<option value="rear">Rear-Eng</option>';
if ($elayout == "rear") { $elayout3 = '<option value="rear" selected>Rear-Eng</option>'; }

//==================================================================
//==================================================================

?>

<!-- END PHP SCRIPT -->

	<div class="row">
		<div class="col-lg-6">
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-danger">
							<div class="panel-body">
                                <h4 id="forms">Forza Tuning Calculator</h4>
                                <p>For help with undertanding how all of the different parts work and/or help with tunings/fine-tuning, please check out the <a href="fm7-tuning-help.html" target="_blank">BG55.COM Forza Tuning Assistant</a>.</p>
							</div>
					</div>
				</div>
			</div>

			<div class="well bs-component">
				<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#results" method="post">
					<fieldset>
						<legend>Vehicle Data Input</legend>
						
						<div class="form-group">
							<label class="col-lg-3 control-label" for="select">Tune Type</label>
							<div class="col-lg-3">
								<select class="form-control" id="select" name="ttype">
									<?php echo $tt01; ?>
									<?php echo $tt02; ?>
									<?php echo $tt03; ?>
									<?php echo $tt04; ?>
									<?php echo $tt05; ?>
								</select>
							</div>
							<label class="col-lg-3 control-label" for="select">Forza Version</label>
							<div class="col-lg-3">
								<select class="form-control" id="select" name="gamever">
									<?php echo $gver1; ?>
								</select>
							</div>
                        </div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="select"><b>Units</b></label>
							<div class="col-lg-9">
								<select class="form-control" id="select" name="units">
									<?php echo $units01; ?>
									<?php echo $units02; ?>
								</select>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-12">
								<p><i><small>Enter Year, Make, &amp; Model (optional for multi-tabs &amp; future export)</small></i><p>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-lg-1 control-label" for="inputSmall">Year</label>
                            <div class="col-lg-2">
                                <input type="number" class="form-control input-sm" step="1" min="1900" max="2099" name="ovyear" value="<?php echo $ovyear; ?>">
                            </div>
                            <label class="col-lg-1 control-label" for="inputSmall">Make</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control input-sm" name="ovmake" value="<?php echo $ovmake; ?>">
                            </div>
                            <label class="col-lg-1 control-label" for="inputSmall">Model</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control input-sm" name="ovmodel" value="<?php echo $ovmodel; ?>">
                            </div>
                        </div>
						<hr>
						<div class="form-group">
							<div class="col-lg-12">
								<p><i><b>Enter Vehicle Data for Tuning</b></i><p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="select">Drive Type</label>
							<div class="col-lg-3">
								<select class="form-control" id="select" name="drivetype">
									<?php echo $dtrwd; ?>
									<?php echo $dtawd; ?>
									<?php echo $dtfwd; ?>
								</select>
							</div>
							<label class="col-lg-3 control-label" for="select">Eng. Layout</label>
							<div class="col-lg-3">
								<select class="form-control" id="select" name="elayout">
									<?php echo $elayout1; ?>
									<?php echo $elayout2; ?>
									<?php echo $elayout3; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-3">
								<span></span>
							</div>
							<div class="col-lg-9">
								<span><small>Define preferred Damper <b><i>Stiffness</i></b> and suspension length of <b><i>Travel</i></b></small></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="select">Stiffness</label>
							<div class="col-lg-3">
								<select class="form-control" id="select" name="stifftype">
									<?php echo $StiffType4; ?>
									<?php echo $StiffType2; ?>
									<?php echo $StiffType1; ?>
									<?php echo $StiffType3; ?>
									<?php echo $StiffType5; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-3">
								<span></span>
							</div>
							<div class="col-lg-9">
								<span><small>Enter Tire information.  Use <i>Same Size</i> if fornt and rear sizes match.</small></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="select">Tire Compound</label>
							<div class="col-lg-9">
								<select class="form-control" id="select" name="tirecomp">
									<?php echo $tirestock; ?>
									<?php echo $tirestreet; ?>
									<?php echo $tiresport; ?>
									<?php echo $tiresemi; ?>
									<?php echo $tirerace; ?>
									<?php echo $tiredrag; ?>
									<?php echo $tiredrift; ?>
                                    <?php echo $tirerally; ?>
                                    <?php echo $tireoffroad; ?>
                                    <?php echo $tirewinter; ?>
                                    <?php echo $tirevintr; ?>
                                    <?php echo $tirevintw; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-3">
							</div>
							<label class="col-lg-9" for="inputSmall">
								<input type="checkbox" name="samesize" value="Same"<?php echo $sizecheck; ?>><small><i>&nbsp;-&nbsp;Front &amp; Rear Tires Same Size (Square)</i></small>
							</label>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="inputSmall">Tire Size (F)</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="5" min="0" max="1000" value="<?php echo $ftire; ?>" name="ftire">
							</div>
							<label class="col-lg-1 control-label" for="inputSmall">/</label>
							<div class="col-lg-2">
								<input type="number" class="form-control input-sm" step="5" min="0" max="995" value="<?php echo $fasp; ?>" name="fasp">
							</div>
							<label class="col-lg-1 control-label" for="inputSmall">R</label>
							<div class="col-lg-2">
								<input type="number" class="form-control input-sm" step="1" min="0" max="32" value="<?php echo $frim; ?>" name="frim">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="inputSmall">Tire Size (R)</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="5" min="0" max="1000" value="<?php echo $rtire; ?>" name="rtire">
							</div>
							<label class="col-lg-1 control-label" for="inputSmall">/</label>
							<div class="col-lg-2">
								<input type="number" class="form-control input-sm" step="5" min="0" max="995" value="<?php echo $rasp; ?>" name="rasp">
							</div>
							<label class="col-lg-1 control-label" for="inputSmall">R</label>
							<div class="col-lg-2">
								<input type="number" class="form-control input-sm" step="1" min="0" max="99" value="<?php echo $rrim; ?>" name="rrim">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-3">
								<span></span>
							</div>
							<div class="col-lg-9">
								<span><small>Enter Power, Weight and misc. information</small></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="inputSmall">Max Power</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="1" min="0" max="9999" name="hp" value="<?php echo $power; ?>">
							</div>
							<label class="col-lg-3 control-label" for="inputSmall">Max Torque</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="1" min="0" max="9999" name="tq" value="<?php echo $torque; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="inputSmall">Weight</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" min="0" max="999999" name="wght" value="<?php echo $weight; ?>">
							</div>
							<label class="col-lg-3 control-label" for="inputSmall">Front Wght %</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" min="0" max="100" name="wpf" value="<?php echo $wpf; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="inputSmall">Ride Heigh (F)</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="0.1" min="0.0" max="99999.9" name="rhf" value="<?php echo number_format($rhf, 1, '.', ''); ?>">
							</div>
							<label class="col-lg-3 control-label" for="inputSmall">Ride Height (R)</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="0.1" min="0.0" max="99999.9" name="rhr" value="<?php echo number_format($rhr, 1, '.', ''); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="inputSmall">Downforce (F)</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="0.1" min="0.0" max="99999.9" name="dff" value="<?php echo $dffront; ?>">
							</div>
							<label class="col-lg-3 control-label" for="inputSmall">Downforce (R)</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="0.1" min="0.0" max="99999.9" name="dfr" value="<?php echo $dfrear; ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<h6>Fine-Tuning Multipliers</h6>
								<p><i><small>Enter the optional suspension component multiplier (1.00 is standard).</small></i><p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="select">Spring</label>
							<div class="col-lg-3">
								<input type="number" class="form-control input-sm" step="0.01" min="0.10" max="2.0" name="cstiff" value="<?php echo number_format($csmod, 2, '.', ''); ?>">
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-12">
								<h6>Transmission Tuning (Race Trans ONLY)</h6>
								<p><i><small>"Top Speed", "# Gears" and "Redline RPM" are all required if Transmission tuning is desired. Leave at ZERO (0) if Transmission tuining is not desired.</small></i><p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="inputSmall">Top Speed</label>
							<div class="col-lg-2">
								<input type="number" step="0" class="form-control input-sm" min="0" max="999" name="topspd" value="<?php echo $tspeed; ?>">
							</div>
							<label class="col-lg-1 control-label" for="inputSmall">Gears</label>
							<div class="col-lg-2">
								<select class="form-control" id="select" name="numgears">
									<?php echo $ng1; ?>
									<?php echo $ng2; ?>
									<?php echo $ng3; ?>
									<?php echo $ng4; ?>
									<?php echo $ng5; ?>
									<?php echo $ng6; ?>
									<?php echo $ng7; ?>
									<?php echo $ng8; ?>
									<?php echo $ng9; ?>
									<?php echo $ng10; ?>
									<?php echo $ng11; ?>
								</select>
							</div>
							<label class="col-lg-2 control-label" for="inputSmall">Redline</label>
							<div class="col-lg-3">
								<input type="number" step="25" class="form-control input-sm" min="0" max="100000" name="redline" value="<?php echo $redline; ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-12">
								<h6>ADVANCED Transmission Tuning (optional)</h6>
								<p><small><i>If the values are set to non-zero, then the calculator assumes you know what you are doing.  Output will be skewed of the inputs here are wrong.  The input here is for custom "Final Drive", "1st Gear Ratio", and "1st Gear Top Speed".</i></small></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="inputSmall">Final Drive</label>
							<div class="col-lg-2">
								<input type="number" step=".01" class="form-control input-sm" min="0.00" max="6.10" name="fdratio" value="<?php echo number_format($fdratiog, 2, '.', ''); ?>">
							</div>
							<label class="col-lg-2 control-label" for="inputSmall">1st Ratio</label>
							<div class="col-lg-2">
								<input type="number" step=".01" class="form-control input-sm" min="0.00" max="6.10" name="firstg" value="<?php echo number_format($cfirstgr, 2, '.', ''); ?>">
							</div>
							<label class="col-lg-2 control-label" for="inputSmall">1st Speed</label>
							<div class="col-lg-2">
								<input type="number" step=".1" class="form-control input-sm" min="0.0" max="999.9" name="speedfirst" value="<?php echo number_format($cspeedf, 2, '.', ''); ?>">
							</div>
							<label class="col-lg-2 control-label" for="inputSmall"></label>
							<div class="col-lg-2">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-2">
							</div>
							<label class="col-lg-10" for="inputSmall">
								<input type="checkbox" name="resetdmod" value="reset"<?php echo $resetdmod; ?>><small><i>&nbsp;-&nbsp;Clear Advanced Transmission Input Data (zero out)</i></small>
							</label>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-4">
								<button type="submit" class="btn btn-danger btn-lg">Calculate Tune</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	<div>
		<a NAME="results"></a>
	</div>
		<div class="col-lg-6">
			<div class="panel panel-danger">
				<div class="panel-body">
					<h4>The Tune</h4>
                    <p>For help with undertanding how all of the different parts work and/or help with tunings/fine-tuning, please check out the <a href="fm7-tuning-help.html" target="_blank">BG55.COM Forza Tuning Assistant</a>.</p>
				</div>
			</div>
			<div class="bs-component" align="center">
				<table class="table table-striped table-hover table-bordered ">
					<thead class="bg-danger">
						<tr>
							<td align="center" colspan="3"><h5><?php echo $ttyped; ?>: <?php echo $ovyear; ?> <?php echo $ovmake; ?> <?php echo $ovmodel; ?></h5></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center" colspan="3"><i><strong><?php echo $elayoutd; ?> <?php echo $drivetype; ?> / <?php echo $tunedatetime; ?></strong></i></td>
						</tr>
						<tr class="bg-danger">
							<td class="bg-danger"><i>Tire Settings</i></td>
							<td align="center" class="bg-danger"><i>Front</i></td>
							<td align="center" class="bg-danger"><i>Rear</i></td>
						</tr>
						<tr>
							<td align="right">Tire Pressure (<?php echo $tirecomp; ?>): </td>
							<td align="center"><?php echo $fpsi; ?> <?php echo $prtag; ?></td>
							<td align="center"><?php echo $rpsi; ?> <?php echo $prtag; ?></td>
						</tr>
						<tr class="bg-danger">
							<td colspan="3" class="bg-danger"><i>Gear Ratios</i></td>
						</tr>
						<tr>
							<td align="right"><i>Final Drive:</i></td>
							<td align="center" colspan="2"><i><?php echo $fdratio; ?></i></td>
						</tr>
						<tr>
							<td align="center" colspan="3">Ratios: <?php echo $gearratios; ?></td>
						</tr>
						<tr class="bg-danger">
							<td class="bg-danger"><abbr title=''><i>Alignment Settings</i></abbr></td>
							<td align="center" class="bg-danger"><i>Front</i></td>
							<td align="center" class="bg-danger"><i>Rear</i></td>
						</tr>
						<tr>
							<td align="right"><font color="gray"><i><abbr title='Wider Tire = less camber'>Camber: </abbr></i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
						</tr>
						<tr>
							<td align="right"><i><abbr title='Start with in-game default settings as base'>Toe (F/R): </abbr></i></td>
							<td align="center"><i>0.0</i></td>
							<td align="center"><i>0.0</i></td>
						</tr>
						<tr>
							<td align="right"><font color="gray"><i><abbr title='Increase for better turn-in; decrease for more stability'>Caster (use base forza values): </abbr></i></td>
							<td align="center" colspan="2"><font color="gray"><i>Default</i></td>
						</tr>
						<tr class="bg-danger">
							<td class="bg-danger"><abbr title=''><i>Suspension Settings (<?php echo $StiffTyped; ?>)</i></td>
							<td align="center" class="bg-danger"><i>Front</i></td>
							<td align="center" class="bg-danger"><i>Rear</i></td>
						</tr>

						<tr>
							<td align="right"><font color="gray"><i>Anti-Roll Bar (use base forza values): </i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
						</tr>

						<tr>
							<td align="right"><abbr title='Increase to make stiffer; decrease to make softer'>Spring Rate <?php echo $csmodf; ?>: </abbr></td>
							<td align="center"><?php echo $srfa; ?></td>
							<td align="center"><?php echo $srra; ?></td>
						</tr>

						<tr>
							<td align="right"><font color="gray"><i>Rebound (use base forza values): </i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
						</tr>
						<tr>
							<td align="right"><font color="gray"><i>Bump (use base forza values): </i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
							<td align="center"><font color="gray"><i>Default</i></td>
						</tr>
						<tr>
							<td align="right"><font color="gray"><i>Ride Height (set by you): </td>
							<td align="center"><font color="gray"><i><?php echo $rhf; ?></td>
							<td align="center"><font color="gray"><i><?php echo $rhr; ?></td>
						</tr>
						<tr>
							<td align="right"><font color="gray"><i>Downforce (set by you): </td>
							<td align="center"><font color="gray"><i><?php echo $dffront; ?></td>
							<td align="center"><font color="gray"><i><?php echo $dfrear; ?></td>
						</tr>

						<tr class="bg-danger">
							<td class="bg-danger"><abbr title=''><i>Brakes</i></td>
							<td align="center" class="bg-danger"><i>Balance</i></td>
							<td align="center" class="bg-danger"><i>Force</i></td>
						</tr>
						<tr>
							<td align="right"><abbr title=''>Race Brakes: </td>
							<td align="center"><abbr title='100% = all rear; 0% = all front'><?php echo $brbal; ?>%</abbr></td>
							<td align="center"><abbr title="Wide Range | Higher % = quicker response &amp; shorter pedal"><?php echo $brfor; ?>%</abbr></td>
						</tr>
						<tr class="bg-danger">
							<td class="bg-danger"><abbr title='Start with in-game default settings as base'><i>Differential (<?php echo $drivetype; ?>)</i></td>
							<td align="center" class="bg-danger"><i>Front</i></td>
							<td align="center" class="bg-danger"><i>Rear</i></td>
						</tr>
						<tr>
							<td align="right"><abbr title='Start with in-game default settings as base'>Acceleration %: </abbr></td>
							<td align="center"><abbr title=''><?php echo $fdiff; ?></abbr></td>
							<td align="center"><abbr title=''><?php echo $rdiff; ?></abbr></td>
						</tr>
						<tr>
							<td align="right"><abbr title='Start with in-game default settings as base'>Deceleration %: </abbr></td>
							<td align="center"><abbr title=''><?php echo $fdiffd; ?></abbr></td>
							<td align="center"><abbr title=''><?php echo $rdiffd; ?></abbr></td>
						</tr>
						<tr>
							<td align="right"><abbr title='on tarmac, increase % (to rear) for more control'>Center Balance %: </abbr></td>
							<td align="center" colspan="2"><?php echo $cdiff; ?></td>
						</tr>
						<!-- ==================================  -->
						<tr class="bg-danger">
							<td colspan="3" class="bg-danger" align="left"><b><i>Inputs &amp; Additional Vehicle Data (<?php echo $units; ?>)</i></b></td>
						</tr>
						<tr>
							<td align="right"><i>Power to Weight Ratio</i></td>
							<td align="center" colspan="2"><b><?php echo $pwr; ?>  <?php echo $pwrtag; ?></b></td>
						</tr>
						<tr>
							<td align="right"><i>Engine &amp; Drive Layout</i></td>
							<td align="center"><?php echo $elayoutd; ?></td>
							<td align="center"><?php echo $drivetype; ?></td>
						</tr>
						<tr>
							<td align="right"><i><?php echo $tirecomp; ?> Tire Compound (F | R)</i></td>
							<td align="center"><?php echo $ftire; ?>/<?php echo $fasp; ?>R<?php echo $frim; ?> (F)</td>
							<td align="center"><?php echo $rtire; ?>/<?php echo $rasp; ?>R<?php echo $rrim; ?> (R)</td>
						</tr>
						<tr>
							<td align="right"><i>Tire Circumfrance (F | R)</i></td>
							<td align="center">(F) <?php echo $ftc; ?> <?php echo $tireunitl; ?></td>
							<td align="center">(R) <?php echo $rtc; ?> <?php echo $tireunitl; ?></td>
						</tr>
						<tr>
							<td align="right"><i>Tire Volume (F | R)</i></td>
							<td align="center">(F) <?php echo $ftv; ?> <?php echo $tireunitv; ?></td>
							<td align="center">(R) <?php echo $rtv; ?> <?php echo $tireunitv; ?></td>
						</tr>
						<tr>
							<td align="right"><i>Ride Height (input): </td>
							<td align="center">(F) <?php echo $rhf; ?></td>
							<td align="center">(R) <?php echo $rhr; ?></td>
						</tr>
						<tr>
							<td align="right"><i>Downforce (input): </td>
							<td align="center">(F) <?php echo $dffront; ?></td>
							<td align="center">(R) <?php echo $dfrear; ?></td>
						</tr>
						<tr>
							<td align="right"><i>Max Power &amp; Torque</i></td>
							<td align="center"><?php echo $power; ?> <?php echo $pwtag; ?></td>
							<td align="center"><?php echo $torque; ?> <?php echo $tqtag; ?></td>
						</tr>
						<tr>
							<td align="right"><i>Total Wght &amp; Wght % Front</i></td>
							<td align="center"><?php echo $weight; ?> <?php echo $wtag; ?></td>
							<td align="center"><?php echo $wpf; ?>%</td>
						</tr>
						<tr>
							<td align="right"><i>Target Top Spd (in 1st)</i></td>
							<td align="center" colspan="2"><?php echo $tspeed; ?> <?php echo $stag; ?> (<?php echo number_format($speedfirst, 2, '.', ''); ?> <?php echo $stag; ?> in 1st)</td>
						</tr>
						<tr>
							<td align="right"><i>Redline RPM &amp; # of Gears</i></td>
							<td align="center"><?php echo $redline; ?> RPM</td>
							<td align="center"><?php echo $numgears; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	</div>

<!-- End Display Tune Data -->
	
</FONT>
</body></html>