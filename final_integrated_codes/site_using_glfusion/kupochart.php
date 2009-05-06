<?php

# KupoChart version 0.1.5 (Revised 2008-04-15)
# Google Chart API clone in PHP, using Image_Graph
# By J. L. Blank <j@twu.net>
# Provided with no warranty under the GNU General Public License
# Official homepage: http://twu.net/projects/kupochart/

# ------------------------------------------------------------------------
# CONFIGURATION - Feel free to edit these variables.
# ------------------------------------------------------------------------

$GLOBALS['kccfg']['width_max'] = 2400;
$GLOBALS['kccfg']['height_max'] = 1200;
$GLOBALS['kccfg']['width_default'] = 120;
$GLOBALS['kccfg']['height_default'] = 120;
$GLOBALS['kccfg']['date_format_x'] = 'M-d-Y';
	# The date format used by default for the X axis, where date
	# preprocessing is being used (i.e., pass Un*x-style timestamps
	# as the X axis and tell KupoChart to process them as dates with
	# xaxis=date). You can override by passing the parameter 'xdatefmt'.
$GLOBALS['kccfg']['date_format_y'] = 'M-d-Y';
	# Same as above, but for the Y axis. Override with 'ydatefmt'.
$GLOBALS['kccfg']['date_interval_minimum'] = 3600;
	# To avoid hogging the CPU, limits the minimum date interval between
	# axis points to this many seconds.
$GLOBALS['kccfg']['date_gridline_maxcount'] = 300;
	# To avoid hogging the CPU, limits the maximum number of date points
	# (points on the X axis) that we will allow to use 'dateint=all'.
	# This prevents users from passing thousands of data points and
	# demanding one point on the axis (and one label!) for each, grinding
	# the CPU to a halt.

$GLOBALS['kccfg']['y_axis_margin'] = .07;
	# The margin between the minimum and maximum Y values and the edge
	# of the graph. A number between 0 (no margin at all; maximum points
	# will bump up against the top and bottom of the graph area) and 1
	# (100% margin on both the top and the bottom; i.e. the graph would
	# only occupy the central third vertically).
			

# Default colours - used if the user does not specify colours
# =========================
$GLOBALS['kccfg']['defaultcolours'][0] = 'red';
$GLOBALS['kccfg']['defaultcolours'][1] = 'green';
$GLOBALS['kccfg']['defaultcolours'][2] = 'blue';
$GLOBALS['kccfg']['defaultcolours'][3] = 'purple';
$GLOBALS['kccfg']['defaultcolours'][4] = 'orange';
$GLOBALS['kccfg']['defaultcolours'][5] = 'brown';
$GLOBALS['kccfg']['defaultcolours'][6] = 'cyan';
$GLOBALS['kccfg']['defaultcolours'][7] = 'magenta';
$GLOBALS['kccfg']['defaultcolours'][8] = 'tan';
$GLOBALS['kccfg']['defaultcolours'][9] = 'yellow';
$GLOBALS['kccfg']['defaultcolours'][10] = 'lightblue';
$GLOBALS['kccfg']['defaultcolours'][11] = 'lightgreen';
$GLOBALS['kccfg']['defaultcolours'][12] = 'pink';
$GLOBALS['kccfg']['defaultcolours'][13] = 'silver';
$GLOBALS['kccfg']['defaultcolours'][14] = 'gold';
$GLOBALS['kccfg']['defaultcolours'][15] = 'indigo';

# End of configuration -- You shouldn't need to edit below this line
# ------------------------------------------------------------------------


# Information on HTTP status codes
# =========================
$httpstatuscodes['400']['title'] = 'Bad Request';

# Information on error states. Some may trigger an HTTP status code.
# =========================
$allerrors['badinput']['title'] = 'Bad Request';
$allerrors['badinput']['longdesc'] = 'Your client has issued a malformed or illegal request.';
$allerrors['badinput']['statuscode'] = 400;



# Error-handling functions
# =========================
function ThrowError($inerrcode) {
	global $allerrors;
	$tmperrtitle = $allerrors{$inerrcode}{'title'};
	$tmperrlongdesc = $allerrors{$inerrcode}{'longdesc'};
	if ($tmperrtitle == '') { $tmperrtitle = 'Unknown error'; }
	if ($tmperrlongdesc == '') { $tmperrlongdesc = 'An unknown error has occurred.'; }
	$tmpstatuscode = $allerrors{$inerrcode}{'statuscode'};
	if ($allerrors{'badinput'}{'statuscode'} > 0) { # If an HTTP status code is merited...
		global $httpstatuscodes;
		if ($httpstatuscodes{$tmpstatuscode}{'title'} != '') {
			$tmpstatusdesc = $httpstatuscodes{$tmpstatuscode}{'title'};
			header("HTTP/1.0 ${tmpstatuscode} ${tmpstatusdesc}");
			header("Content-type: text/html");
			print "<html><head><title>${tmpstatuscode} ${tmpstatusdesc}</title></head><body>";
		}
	}
	print "<h1>${tmperrtitle}</h1>\n<hr>\n";
	print "<b>${tmperrlongdesc}</b>";
}

function ThrowFatalError($inerrcode) {
	ThrowError($inerrcode);
	exit();
}

# Functions for each type of pie
# =========================
function handleGraph_Pie2D($Canvas) {

	# Reject bad data.
	if (preg_match('/\|/', $_REQUEST['chd'])) {
		ThrowFatalError('badinput');
	}
	
	# Create graph object on canvas.
	$Graph =& Image_Graph::factory('graph', $Canvas);
	$Plotarea =& $Graph->addNew('plotarea');
	$Plotarea->hideAxis();


	# Eliminate the pesky padding to make the graph
	# nearly edge-to-edge on its canvas.
	$Plotarea->setPadding($Graph->height() * -0.075);

	# Set up colours.
	$fill =& Image_Graph::factory('Image_Graph_Fill_Array');
	if ($_REQUEST['chco']) {
		$tmpcolours = split(',',$_REQUEST['chco']);
		for ($tc = 0; $tc < count($tmpcolours); $tc++) {
			if (preg_match('/^[0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f]$/i', trim($tmpcolours[$tc]))) { # HTML-style hex colour value, e.g. 00FF22
				$fill->addColor('#' . trim($tmpcolours[$tc]), "${tc}");
			} else { # Presumably a named colour entity (e.g. 'red')
				$fill->addColor(trim($tmpcolours[$tc]));
			}
		}
	} else { # Default colours
		for ($dc = 0; $dc < count($GLOBALS['kccfg']['defaultcolours']); $dc++) {
			$fill->addColor($GLOBALS['kccfg']['defaultcolours'][$dc], "${dc}");
		}
	}

	# Pull in data.
	$Dataset =& Image_Graph::factory('dataset');
	if ($_REQUEST['chd']) {
		$tmptypeanddata = split(':',$_REQUEST['chd'],2);
		$tmpdatapts = split(',',$tmptypeanddata[1]);
		for ($d = 0; $d < count($tmpdatapts); $d++) {
			$Dataset->addPoint("${d}", $tmpdatapts[$d], "${d}"); # Note the forced numerification and stringification.
		}
	}

	$Plot =& $Plotarea->addNew('pie', &$Dataset);
	$Plot->setFillStyle($fill);

	# Graph it.
	$Graph->done();
}



function handleGraph_Line2D($Canvas) {

	$Graph =& Image_Graph::factory('graph', $Canvas);

	$Plotarea =& Image_Graph::factory('plotarea', 'axis', 'axis');
	$tmppadding_horizontal = $_REQUEST['xpad'];
	$tmppadding_vertical = $_REQUEST['ypad'];
	if (tmppadding_horizontal > 0) {
		if ($tmppadding_vertical == '') { $tmppadding_vertical = 5; }
	} else {
		if (tmppadding_vertical > 0) {
			if ($tmppadding_horizontal == '') { $tmppadding_horizontal = 10; }
		}
	}
	if (($tmppadding_horizontal > 0) || ($tmppadding_vertical > 0)) {
		$Plotarea->setPadding(array("right"=>$tmppadding_horizontal,"left"=>$tmppadding_horizontal,"bottom"=>$tmppadding_vertical,"top"=>$tmppadding_vertical));
	}

	$Graph->setFont($Font);
	$Graph->add($Plotarea);

	# Set up colours.
	$fill =& Image_Graph::factory('Image_Graph_Fill_Array');
	if ($_REQUEST['chco']) {
		$tmpcolours = split(',',$_REQUEST['chco']);
		for ($tc = 0; $tc < count($tmpcolours); $tc++) {
			if (preg_match('/^[0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f]$/i', trim($tmpcolours[$tc]))) { # HTML-style hex colour value, e.g. 00FF22
				$tmpcolours[$tc] = '#' . $tmpcolours[$tc];
			} else { # Presumably a named colour entity (e.g. 'red')
				$tmpcolours[$tc] = trim($tmpcolours[$tc]);
			}
		}
	} else { # Default colours
		$tmpcolours = $GLOBALS['kccfg']['defaultcolours'];
	}

	# Pull in data.
	$Datasets = array();
	if ($_REQUEST['chd']) {
		$tmptypeanddata = split(':',$_REQUEST['chd'],2);
		$tmpdatapts = split('\|',$tmptypeanddata[1]);
		$ds = 0;
		$all_xpoints = array();
		$all_ypoints = array();
		for ($d = 0; $d < count($tmpdatapts); $d+=2) {
			$Datasets[$ds] =& Image_Graph::factory('dataset');
			$xpoints = split('\,',$tmpdatapts[$d]);
			$ypoints = split('\,',$tmpdatapts[$d+1]);
			$all_xpoints = array_merge($all_xpoints, $xpoints);
			$all_ypoints = array_merge($all_ypoints, $ypoints);
			for ($pt = 0; $pt < min(count($xpoints), count($ypoints)); $pt++) {
				$Datasets[$ds]->addPoint($xpoints[$pt], $ypoints[$pt]);
			}
			$ds++;
		}
	}

	$Empty_dataset =& Image_Graph::factory('dataset');
	$Plot =& $Plotarea->addNew('line', $Empty_dataset); # Plot an empty dataset.
	$Plot->setBackgroundColor('white'); # add a white background colour.


	# Layer on the gridlines.
	$Plotarea->addNew('line_grid', false, IMAGE_GRAPH_AXIS_X);
	$Plotarea->addNew('line_grid', false, IMAGE_GRAPH_AXIS_Y);
	$XAxis =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
	$XAxis->forceMinimum(min($all_xpoints));
	$XAxis->forceMaximum(max($all_xpoints));
    

	$YAxis =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
#	$YAxis->forceMinimum(min($all_ypoints));
#	$YAxis->forceMaximum(max($all_ypoints));
	$YAxis->forceMinimum(floor(min($all_ypoints) - ($GLOBALS['kccfg']['y_axis_margin'] * abs(min($all_ypoints)))));
	$YAxis->forceMaximum(ceil(max($all_ypoints) + ($GLOBALS['kccfg']['y_axis_margin'] * abs(max($all_ypoints)))));

	if ($_REQUEST['xlabelangle'] != '') {
		if ($_REQUEST['xlabelangle'] % 90 == 0) {
			$XAxis->setFontAngle($_REQUEST['xlabelangle']);
		}
	}
	if ($_REQUEST['ylabelangle'] != '') {
		if ($_REQUEST['ylabelangle'] % 90 == 0) {
			$YAxis->setFontAngle($_REQUEST['ylabelangle']);
		}
	}


	# Preprocess data for axes if necessary.
	if (strtolower($_REQUEST['xaxis']) == 'date') {
		$tmpdateformat_x = $GLOBALS['kccfg']['date_format_x'];
		if ($_REQUEST['xdatefmt'] != '') {
			$tmpdateformat_x = $_REQUEST['xdatefmt'];
		}
		$XAxis->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Date', $tmpdateformat_x)); 
		if ($_REQUEST['dateint'] != '') {
			$tmpdateinterval = $_REQUEST['dateint'];
			if ($tmpdateinterval == 'all') {
				if (count($all_xpoints) <= $GLOBALS['kccfg']['date_gridline_maxcount']) {
					$tmpdateinterval = $all_xpoints;
				}
			} else {
				if ($tmpdateinterval < $GLOBALS['kccfg']['date_interval_minimum']) {
					$tmpdateinterval = $GLOBALS['kccfg']['date_interval_minimum'];
				}
			}
			$XAxis->setLabelInterval($tmpdateinterval);
		}
		$XAxis->showLabel(IMAGE_GRAPH_LABEL_MAXIMUM|IMAGE_GRAPH_LABEL_MINIMUM);

	}
	if (strtolower($_REQUEST['yaxis']) == 'date') {
		$tmpdateformat_y = $GLOBALS['kccfg']['date_format_y'];
		if ($_REQUEST['ydatefmt'] != '') {
			$tmpdateformat_y = $_REQUEST['ydatefmt'];
		}
		$YAxis->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Date', $tmpdateformat_y)); 
		if ($_REQUEST['dateint'] != '') {
			$tmpdateinterval = $_REQUEST['dateint'];
			if ($tmpdateinterval == 'all') {
				if (count($all_ypoints) <= $GLOBALS['kccfg']['date_gridline_maxcount']) {
					$tmpdateinterval = $all_ypoints;
				}
			} else {
				if ($tmpdateinterval < $GLOBALS['kccfg']['date_interval_minimum']) {
					$tmpdateinterval = $GLOBALS['kccfg']['date_interval_minimum'];
				}
			}
			$YAxis->setLabelInterval($tmpdateinterval);
		}
		$YAxis->showLabel(IMAGE_GRAPH_LABEL_MAXIMUM|IMAGE_GRAPH_LABEL_MINIMUM);
	}

	for ($ln = 0; $ln < count($Datasets); $ln++) {
		$Plot =& $Plotarea->addNew('line', array(&$Datasets[$ln]));
		$Plot->setLineColor($tmpcolours[$ln]);
	}


	# Graph it.
	$Graph->done();
}

# MAIN CODE
# ================================================================
require_once 'Image/Graph.php';    


# Determine output mode
if ($_REQUEST['outputmode']) {
	$outputmode = trim(strtolower($_REQUEST['outputmode']));
}


if (($outputmode != 'svg') && ($outputmode != 'png')) {
	$outputmode = 'png';
}


# Determine chart type
$GLOBALS['cht'] = $_REQUEST['cht'];
switch (trim(strtolower($_REQUEST['cht']))) {
	case 'p': # Pie; we only do a 2D pie for now.
		$GLOBALS['cht'] = 'p';
	break;

	case 'lxy': # Line
		$GLOBALS['cht'] = 'lxy';
	break;

	default:
		if (preg_match('/\|/', $_REQUEST['chd'])) { # Data contains pipes; assume it's a line chart
			$GLOBALS['cht'] = 'lxy';
		} else { # No pipes; assume a pie chart.
			$GLOBALS['cht'] = 'p';
		}
	break;
}


# Set up canvas size.
if ($_REQUEST['chs']) {
	$tmpsize = split('x', $_REQUEST['chs']);
	$canvaswidth = intval($tmpsize[0]);
	$canvasheight = intval($tmpsize[1]);
	if ($canvasheight == '') {
		$canvasheight = $canvaswidth;
	}
	if (($canvaswidth > $GLOBALS['kccfg']['width_max']) || ($canvasheight > $GLOBALS['kccfg']['height_max'])) {
		ThrowFatalError('badinput');
	}
} else {
	$canvaswidth = $GLOBALS['kccfg']['width_default'];
	$canvasheight = $GLOBALS['kccfg']['height_default'];
}

if ($GLOBALS['DO_NOTHING'] == 1) { return; }
# Used for tools like colourslist.php; loads settings, then stops before
# actually plotting anything.


# Establish canvas.
$Canvas =& Image_Canvas::factory($outputmode, array('width' => $canvaswidth, 'height' => $canvasheight, 'antialias' => true, 'transparent' => true));


switch ($GLOBALS['cht']) {
	case 'p':
		handleGraph_Pie2D($Canvas);
		break;
	case 'lxy':
		handleGraph_Line2D($Canvas);
		break;
}

# Plot said data.
?>
