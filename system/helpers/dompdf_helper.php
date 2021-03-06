<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create1($html, $filename='', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}

function pdf_create($html, $filename='', $stream=TRUE, $set_paper='')
{
	require_once("dompdf/dompdf_config.inc.php");

	$dompdf = new DOMPDF();
	$dompdf->load_html($html);

	if ($set_paper != '')
	{
		$dompdf->set_paper("a4", "landscape" );
	}

	$dompdf->render();
	if ($stream) {
		$dompdf->stream($filename.".pdf");
	} else {
		return $dompdf->output();
	}
}

?>