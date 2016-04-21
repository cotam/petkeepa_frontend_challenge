<?php

require_once(PET_COMMON.'Inc/PHPExcel/PHPExcel.php');

/**
 * Set login session
 */
function set_session( $id, $email ) {
    if ( ! session( '?login_user' ) ) {
        session( array( 'name' => 'login_user', 'expire' => 1200 ) );
        session( 'login_user', $email );
    }
    if ( ! session( '?login_user_id' ) ) {
        session( array( 'name' => 'login_user_id', 'expire' => 1200 ) );
        session( 'login_user_id', $id );
    }
}

/**
 * Clear login session
 */
function clear_session() {
    session( 'login_user', null );
    session( 'login_user_id', null );
}

/**
 * Get session ID
 */
function get_session_id() {
    if ( session( '?login_user_id' ) ) {
        return session( 'login_user_id' );
    } else {
        return false;
    }
}

/**
 * SESSION EMAIL Get session email
 */
function get_session_email() {
    if ( session( '?login_user' ) ) {
        return session( 'login_user' );
    } else {
        return false;
    }
}

// * => USD
function finance_convert($fee,$scur='SGD',$tcur='USD'){
	$d_option=D('Administrator/Option');
	$finance_api=$d_option->getParam('finance_rate_api');
	$response=json_decode(file_get_contents($finance_api));
	$resources=$response->list->resources;
	foreach($resources as $resource){
		if($resource->resource->fields->name=="{$tcur}/{$scur}"){
			$price=$resource->resource->fields->price;
			return number_format($fee/$price,2);
		}
	}
	return $fee;
}


function export($name='export.xls',$data=array(),$rows=array()){
    $excel=new PHPExcel();
    $index='A';
    foreach($rows as $key=>$value){
        $excel->getActiveSheet()->setCellValue("{$index}1", $value);
        $index=chr(ord($index)+1);
    }
    $index2=2;
    foreach($data as $key=>$value){
        $index='A';
        foreach($value as $v){
            $excel->getActiveSheet()->setCellValue("{$index}{$index2}", $v);
            $index=chr(ord($index)+1);
        }
        $index2++;
    }
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    // 从浏览器直接输出$filename
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type: application/vnd.ms-excel;");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header("Content-Disposition:attachment;filename=".$name);
    header("Content-Transfer-Encoding:binary");
    $objWriter->save("php://output"); 
}