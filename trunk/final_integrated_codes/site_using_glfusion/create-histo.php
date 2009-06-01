<?php
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// MODULE: Teste la classe Graph
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/class-histo.php';

function draw_my_bar($vals,$xlabel,$ylabel)
{
	//header("Pragma: no-cache"); 
	//header("Cache-Control: no-cache");
	//	header('Content-type: image/jpg');
	//$document_titre = "Test Graph Histogramme"; // Titre de la page

	if (isset($_POST['h_width'])) $h_width = $_POST['h_width']; else $h_width = 700;
	if (isset($_POST['h_height'])) $h_height = $_POST['h_height']; else $h_height = 300;
	if (isset($_POST['h_border'])) $h_border = $_POST['h_border']; else $h_border = 0;
	if (isset($_POST['h_drawscale']))$h_drawscale = "checked"; else $h_drawscale = "checked";
	if (isset($_POST['h_drawgradline']))$h_drawgradline = "checked"; else $h_drawgradline = "checked";
	if (isset($_POST['h_showvalue']))$h_showvalue = "checked"; else $h_showvalue = "";
//	if (isset($_POST['h_xaxislabel'])) $h_xaxislabel = $_POST['h_xaxislabel']; else $h_xaxislabel = "Month";
//	if (isset($_POST['h_yaxislabel'])) $h_yaxislabel = $_POST['h_yaxislabel']; else $h_yaxislabel = "Beers";
	if (isset($_POST['h_xaxislabel'])) $h_xaxislabel = $_POST['h_xaxislabel']; else $h_xaxislabel = $xlabel;
	if (isset($_POST['h_yaxislabel'])) $h_yaxislabel = $_POST['h_yaxislabel']; else $h_yaxislabel = $ylabel;
	
	if (!isset($_POST['h_width']))
	{
		$h_drawscale = "checked";
		$h_drawgradline = "";
		$h_showvalue = "";
	}

	$H = new Histogram($vals);
	$H->width = $h_width;                        // 150 par défaut
	$H->height = $h_height;                      // 150 par défaut
	$H->bgcolor = "#EFFFDD";                     // #FFFFFF par défaut
	$H->DrawScale = ($h_drawscale != "");        // true par défaut
//	$H->DrawGradLine = ($h_drawgradline != "");  // false par défaut     
	$H->DrawGradLine = 1;  // false par défaut     
	$H->border=$h_border;                        // 0 par défaut
//	$H->ShowValue = ($h_showvalue != "");        // false par défaut
	$H->ShowValue = 1;        // false par défaut	

	$H->XAxisLabel = $h_xaxislabel;              //
	$H->YAxisLabel = $h_yaxislabel;              //
	$H->XAxisLabelColor = "#6666FF";             // #000000 par défaut
	$H->YAxisLabelColor = "#00CC66";             // #000000 par défaut
	$H->Draw();	

	if ($H->ErrorMsg != "")
		print("<tr><td colspan=\"2\" bgcolor=\"#FF0000\" style=\"color: #FFFF33;\">".$H->ErrorMsg."</td></tr>");
}
?>