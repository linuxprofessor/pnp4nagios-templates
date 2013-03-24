<?php
# Template for EDS probe
# Written by Marcus Wilhelmsson
# License: MIT

# Vertical label
$vertlabel = "Temperature";

# Define opt and def as empty
$opt[1] = '';
$def[1] = '';

# Set image format, title, etc.
$opt[1] .= " --imgformat=PNG --title=\" $hostname / " . $this->MACRO['DISP_SERVICEDESC'] . "\" --base=1024 --vertical-label=\"$vertlabel\" --slope-mode ";
$opt[1] .= "--watermark=\"http://www.nickebo.net\" ";

# Print graph
$def[1] .= "DEF:ds1=$rrdfile:$DS[1]:AVERAGE " ;
$def[1] .= "CDEF:var1=ds1 ";

# Draw line
$def[1] .= "LINE1:var1" . "#00A2FF" . "FF:\"$NAME[1]\t\" ";
# Draw area under line
$def[1] .= "AREA:var1" . "#00A2FF32 ";

# Draw Current, Average and Max under graph
$def[1] .= "GPRINT:var1:LAST:\"Cur\\:%8.2lf $UNIT[1]\" ";
$def[1] .= "GPRINT:var1:AVERAGE:\"Avg\\:%8.2lf $UNIT[1]\" ";
$def[1] .= "GPRINT:var1:MAX:\"Max\\:%8.2lf $UNIT[1]\\n\" ";

# Draw warning and crit
if (isset($WARN[1]) && $WARN[1] != "") {
	$def[1] .= "HRULE:$WARN[1]#FFFF00:\"Warning ($NAME[1])\: " . $WARN[1] . " " . $UNIT[1] . " \\n\" " ;
}

if (isset($CRIT[1]) && $CRIT[1] != "") {
	$def[1] .= "HRULE:$CRIT[1]#FF0000:\"Critical ($NAME[1])\: " . $CRIT[1] . " " . $UNIT[1] . " \\n\" " ;
}

?>
