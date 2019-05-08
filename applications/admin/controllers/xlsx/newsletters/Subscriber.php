<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber extends CI_Controller {

    /**
     * index: Export Subscriber data to excel
     *
     * @access public
     * @return void
    **/
    public function index() 
    {
        $this->load->library('excel');
        $this->load->helper('download');

        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        
        // Build Header
        $excel->getActiveSheet()->SetCellValue('A1', lang('newsletter_subscriber_email'));
        $excel->getActiveSheet()->SetCellValue('B1', lang('newsletter_subscriber_email'));
        $excel->getActiveSheet()->SetCellValue('C1', lang('newsletter_subscriber_source'));
        $excel->getActiveSheet()->SetCellValue('D1', lang('newsletter_subscriber_creation_date'));
        $excel->getActiveSheet()->SetCellValue('E1', lang('newsletter_subscriber_active_flag'));   

        $rowCount = 2;
        $subscribers = new Newsletter_Subscriber();
        $subscribers->order_by('creation_date','DESC');
        foreach( $subscribers->get() as $subscriber ) 
        {
            $status = '';
            switch( $subscriber->active_flag ) 
            {
                case 0 : $status = lang('inactive'); break;
                case 1 : $status = lang('active'); break;
                default: $status = lang('pending');
            }

            $excel->getActiveSheet()->SetCellValue('A' . $rowCount, $subscriber->email);
            $excel->getActiveSheet()->SetCellValue('B' . $rowCount, $subscriber->name);
            $excel->getActiveSheet()->SetCellValue('C' . $rowCount, $subscriber->source);
            $excel->getActiveSheet()->SetCellValue('D' . $rowCount, $subscriber->creation_date);
            $excel->getActiveSheet()->SetCellValue('E' . $rowCount, $status );

            $rowCount++;
        }

        $filename = lang('newsletter_subscriber_title_filename') . time() . '.xlsx'; 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = new PHPExcel_Writer_Excel2007($excel);
        $objWriter->save('php://output');
    }
}
