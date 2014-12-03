<?php

class RenderController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getPdf()
	{
	    $obj = Render::instantiate();
	    $obj = Render::fillDataBreak($obj);
	    
	    $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
	    $rendererLibraryPath = base_path().'/vendor/mpdf/mpdf/';

	    PHPExcel_Settings::setPdfRenderer(
			$rendererName,
			$rendererLibraryPath
		);
		
	    header('Content-Type: application/pdf');
	    header('Content-Disposition: attachment;filename="scores.pdf"');
	    header('Cache-Control: max-age=0');
	    if((bool)preg_match('/msie 9./i', $_SERVER['HTTP_USER_AGENT'])) {
	        header('Cache-Control: max-age=1');
	    }
	
	    $obj->setActiveSheetIndex(0);
	    $objWriter = PHPExcel_IOFactory::createWriter($obj, 'PDF');
	    $objWriter->save('php://output');
	    exit;
	}
	
	public function getXls()
	{
	    $obj = Render::instantiate();
	    $obj = Render::fillData($obj);
	
	    header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment;filename="scores.xls"');
	    header('Cache-Control: max-age=0');
	    if((bool)preg_match('/msie 9./i', $_SERVER['HTTP_USER_AGENT'])) {
	        header('Cache-Control: max-age=1');
	    }
	    
	    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	    header ('Cache-Control: cache, must-revalidate');
	    header ('Pragma: public');
	    
	    $obj->setActiveSheetIndex(0);
	    $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel5');
	    $objWriter->save('php://output');
	    exit;
	}
	
	public function getXlsx()
	{
	    $obj = Render::instantiate();
	    $obj = Render::fillData($obj);
	
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename="scores.xlsx"');
	    header('Cache-Control: max-age=0');
	    if((bool)preg_match('/msie 9./i', $_SERVER['HTTP_USER_AGENT'])) {
	        header('Cache-Control: max-age=1');
	    }
	    
	    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	    header ('Cache-Control: cache, must-revalidate');
	    header ('Pragma: public');
	    
	    $obj->setActiveSheetIndex(0);
	    $objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
	    $objWriter->save('php://output');
	    exit;
	}

}
