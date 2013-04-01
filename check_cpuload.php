<?php
# Template for EDS probe
# Written by Marcus Wilhelmsson
# License: MIT

# To be used with my check_cpuload.sh for SmartOS for generating graphs with pnp4nagios

# Define opt and def as empty
$opt[1] = '';
$def[1] = '';

# Set image format, title, etc.
$opt[1] .= " --imgformat=PNG --title=\" $hostname / " . $this->MACRO['DISP_SERVICEDESC'] . "\" --base=1024 --vertical-label=\"$vertlabel\" --slope-mode ";
$opt[1] .= "--watermark=\"http://www.nickebo.net\" ";

function generateRandomColor() {
	$randomcolor = '#' . strtoupper(dechex(rand(0,10000000)));
	if (strlen($randomcolor) != 7) {
		$randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
		$randomcolor = substr($randomcolor,0,7);
	}
	return $randomcolor;
}

for ($i = 0; $i <= sizeof($DS)-1; $i++) {
	$def[1] .= "DEF:core" . $i . "=$RRDFILE[1]:" . $DS[  ($i+1)  ] . ":AVERAGE ";
}

srand(800);
for ($i = 0; $i <= sizeof($DS)-1; $i++) {
	$color = generateRandomColor();
	$def[1] .= "LINE1:core" . $i . $color . ":Core" . $i . " ";
	$def[1] .= "GPRINT:core" . $i . ":LAST:\" Current\\:%3.2lf $UNIT[1]\" ";
	$def[1] .= "GPRINT:core" . $i . ":AVERAGE:\"Average\\:%3.2lf $UNIT[1]\" ";
	$def[1] .= "GPRINT:core" . $i . ":MAX:\"Maximum\\:%3.2lf $UNIT[1]\\n\" ";
}
?>
