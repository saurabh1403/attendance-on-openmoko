<?php
//  include "./extra/class.linegraph.php";

require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/class-linegraph.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/lib-common1.php';
//echo line_my();

function line_my($info,$data,$labels,$temp_file)
{
	global $_CONF1;

	if(!isset($info['title'])) $info['title']= "line-gggdffdfd";
	if(!isset($info['height'])) $info['height']= 250;
	if(!isset($info['width'])) $info['width']= 650;

	$def_file_path = $_SERVER['DOCUMENT_ROOT'] . 'gl/btp/linegraph.def';

	$graph = new lineGraph();
	$graph->LoadGraph($def_file_path,$info,$data);
	$graph->SetLegendData($labels);
	$graph->SetLegendVisible(1);
	$graph->SetLegendFloating(1);
//	$graph->SetLegendFont(3);
//	$graph->SetGraphAreaHeight(100);
	if(isset($temp_file))
	$temp_image_file =$_CONF1['path'].'images/'.$temp_file;
	else
	$temp_image_file = $_CONF1['path'].'images/temp.png';

	$graph->DrawGraph($temp_image_file);

}

?>