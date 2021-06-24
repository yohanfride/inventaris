<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'libraries/PHPExcel/PHPExcel.php';

class excel extends CI_Controller {

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('lingkungan_m');
		$this->load->model('umat_m');
		$this->load->model('rekaplingkungan_m');
		$this->load->model('kembaliamplop_m');
		$this->load->model('user_m');
		$this->style_col = array(
		  //'font' => array('bold' => true), // Set font nya jadi bold
		  'alignment' => array(
		    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
		    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$this->style_row = array(
		  'alignment' => array(
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
		    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);
    }

    function excelTitle(&$excel,$nama_toko,$title,$description,$keywords){
    	$excel->getProperties()->setCreator($nama_toko)
             ->setLastModifiedBy($nama_toko)
             ->setTitle($title)
             ->setDescription($description)
             ->setKeywords($keywords);	
        return $excel;
    }

    function setformat(&$excel,$cell,$format="_-* #,##0"){
    	///  _(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)
    	/// "_-* #,##0"
    	$excel->getActiveSheet()
			    ->getStyle($cell)
			    ->getNumberFormat()
			    ->setFormatCode($format);
        return $excel;
    }

    function convert_date($date_string){
	  $date = DateTime::createFromFormat('Y-m-d H:i', date("Y-m-d H:i",strtotime($date_string)) ); 
	  return $date;
	}


	function data_perlingkungan(&$excel, $rekap, $lingkungan, $wilayah){
		$excel->getActiveSheet()->setCellValue('A2',"Perhitungan Amplop APP"); 
    	$excel->getActiveSheet()->mergeCells('A1:N1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$excel->getActiveSheet()->setCellValue('A2',"Wilayah :  ".$wilayah); 
		$excel->getActiveSheet()->mergeCells('A2:N2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$excel->getActiveSheet()->setCellValue('A3',"Lingkungan : ".$lingkungan); 
		$excel->getActiveSheet()->mergeCells('A3:N3'); 
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "No"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "Wilayah");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "Lingkungan"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "KK ID"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "Nama Kepala Keluarga"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "Amplop 1"); 
		$excel->getActiveSheet()->setCellValue('G'.$coltitle, "Amplop 2"); 
		$excel->getActiveSheet()->setCellValue('H'.$coltitle, "Amplop 3"); 
		$excel->getActiveSheet()->setCellValue('I'.$coltitle, "Amplop 4"); 
		$excel->getActiveSheet()->setCellValue('J'.$coltitle, "Amplop 5"); 
		$excel->getActiveSheet()->setCellValue('K'.$coltitle, "Amplop 6"); 
		$excel->getActiveSheet()->setCellValue('L'.$coltitle, "Amplop 7"); 
		$excel->getActiveSheet()->setCellValue('M'.$coltitle, "Total"); 
		$excel->getActiveSheet()->setCellValue('N'.$coltitle, "Status"); 

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('H'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('I'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('J'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('K'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('L'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('M'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('N'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0; $amplop1 = 0; $amplop2 = 0; $amplop3 = 0; $amplop4 = 0; 
		$amplop5 = 0; $amplop6 = 0; $amplop7 = 0; $jumlah=0;
		foreach ($rekap as $d) {
			$status = 0;
			if( $d->status_amplop1 == 7)
				$status++;
			if( $d->status_amplop2 == 7)
				$status++;
			if( $d->status_amplop3 == 7)
				$status++;
			if( $d->status_amplop4 == 7)
				$status++;
			if( $d->status_amplop5 == 7 )
				$status++;
			if( $d->status_amplop6 == 7 )
				$status++;
			if( $d->status_amplop7 == 7)
				$status++;
			$d_total = $d->amplop1 + $d->amplop2 + $d->amplop3 + $d->amplop4 + $d->amplop5 + $d->amplop6 + $d->amplop7; 
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->wilayah );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->lingkungan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->kk_id);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->nama);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->amplop1);
			$excel->getActiveSheet()->setCellValue('G'.$numrow, $d->amplop2);
			$excel->getActiveSheet()->setCellValue('H'.$numrow, $d->amplop3);
			$excel->getActiveSheet()->setCellValue('I'.$numrow, $d->amplop4);
			$excel->getActiveSheet()->setCellValue('J'.$numrow, $d->amplop5);
			$excel->getActiveSheet()->setCellValue('K'.$numrow, $d->amplop6);
			$excel->getActiveSheet()->setCellValue('L'.$numrow, $d->amplop7);
			$excel->getActiveSheet()->setCellValue('M'.$numrow, $d_total);
			if($status!=0){
				$excel->getActiveSheet()->setCellValue('N'.$numrow, 'Telah Dihitung ('.$status.')');
				$excel->getActiveSheet()->getStyle('N'.$numrow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00B050');
			} else {
				$excel->getActiveSheet()->setCellValue('N'.$numrow, 'Belum Dihitung');
				$excel->getActiveSheet()->getStyle('N'.$numrow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FF3300');
			}
			$excel->getActiveSheet()->getStyle('N'.$numrow)->getFont()->getColor()->setRGB('000000');

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d_total;
			$amplop1+=$d->amplop1;
			$amplop2+=$d->amplop2;
			$amplop3+=$d->amplop3;
			$amplop4+=$d->amplop4;
			$amplop5+=$d->amplop5;
			$amplop6+=$d->amplop6;
			$amplop7+=$d->amplop7;
			$jumlah+=$status;
		}
		
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'Total');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'E'.$numrow); 
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $amplop1);
		$excel->getActiveSheet()->setCellValue('G'.$numrow, $amplop2);
		$excel->getActiveSheet()->setCellValue('H'.$numrow, $amplop3);
		$excel->getActiveSheet()->setCellValue('I'.$numrow, $amplop4);
		$excel->getActiveSheet()->setCellValue('J'.$numrow, $amplop5);
		$excel->getActiveSheet()->setCellValue('K'.$numrow, $amplop6);
		$excel->getActiveSheet()->setCellValue('L'.$numrow, $amplop7);
		$excel->getActiveSheet()->setCellValue('M'.$numrow, $total);
		$excel->getActiveSheet()->setCellValue('N'.$numrow, $jumlah);

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$excel = $this->setformat($excel,'F4:N'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet()->setTitle($lingkungan);
    }

	function rekap_total_perhitungan($rekap){
    	$excel = new PHPExcel();
    	$title = "Laporan Rekapitulasi Perhitungan Amplop APP - per tanggal ".(date("d-m-Y"));
    	$excel = $this->excelTitle($excel,'RAMP',$title,"Laporan Rekapitulasi","Data Rekapitulasi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekapitulasi Perhitungan Amplop APP"); 
		$excel->getActiveSheet()->mergeCells('A1:K1'); 
		// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Data per Tanggal ".(date("d-m-Y"))); 
		$excel->getActiveSheet()->mergeCells('A2:K2'); 
		// $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "No"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "Wilayah");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "Lingkungan"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "Amplop 1"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "Amplop 2"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "Amplop 3"); 
		$excel->getActiveSheet()->setCellValue('G'.$coltitle, "Amplop 4"); 
		$excel->getActiveSheet()->setCellValue('H'.$coltitle, "Amplop 5"); 
		$excel->getActiveSheet()->setCellValue('I'.$coltitle, "Amplop 6"); 
		$excel->getActiveSheet()->setCellValue('J'.$coltitle, "Amplop 7"); 
		$excel->getActiveSheet()->setCellValue('K'.$coltitle, "Total"); 

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('H'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('I'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('J'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('K'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0; $amplop1 = 0; $amplop2 = 0; $amplop3 = 0; $amplop4 = 0; 
		$amplop5 = 0; $amplop6 = 0; $amplop7 = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->wilayah );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->lingkungan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->amplop1);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->amplop2);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->amplop3);
			$excel->getActiveSheet()->setCellValue('G'.$numrow, $d->amplop4);
			$excel->getActiveSheet()->setCellValue('H'.$numrow, $d->amplop5);
			$excel->getActiveSheet()->setCellValue('I'.$numrow, $d->amplop6);
			$excel->getActiveSheet()->setCellValue('J'.$numrow, $d->amplop7);
			$excel->getActiveSheet()->setCellValue('K'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->total;
			$amplop1+=$d->amplop1;
			$amplop2+=$d->amplop2;
			$amplop3+=$d->amplop3;
			$amplop4+=$d->amplop4;
			$amplop5+=$d->amplop5;
			$amplop6+=$d->amplop6;
			$amplop7+=$d->amplop7;
		}
		
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'Total');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'C'.$numrow); 
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $amplop1);
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $amplop2);
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $amplop3);
		$excel->getActiveSheet()->setCellValue('G'.$numrow, $amplop4);
		$excel->getActiveSheet()->setCellValue('H'.$numrow, $amplop5);
		$excel->getActiveSheet()->setCellValue('I'.$numrow, $amplop6);
		$excel->getActiveSheet()->setCellValue('J'.$numrow, $amplop7);
		$excel->getActiveSheet()->setCellValue('K'.$numrow, $total);

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:K'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekapitulasi");
    	
    	//Detail Data//
    	$index=1;
    	foreach ($rekap as $d) {
    		$excel->createSheet($index);
			$excel->setActiveSheetIndex($index)->setCellValue('A1', "Perhitungan Amplop APP"); 
			$data = $this->umat_m->get_data_all('','',$d->kode_lingkungan);
			$this->data_perlingkungan($excel,$data,$d->lingkungan,$d->wilayah);
			$index++;
    	}
		
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if(ob_get_length() > 0) {
		    ob_clean();
		}
		$write->save('php://output');
		exit();	
    }

    public function perhitungan($cetak=""){
   		$data=array();
		$data['menu']='grafik-perhitungan';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Rekap Perhitungan Amplop';
		$data['opt'] = $this->input->get('option');
   		$data['wil'] = $this->input->get('wilayah');
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		if($data['opt']=='umat'){
			$data['data'] = $this->umat_m->total_rekap_lingkungan_excel($data['wil']);
		} else {
			$data['data'] = $this->rekaplingkungan_m->total_rekap_lingkungan_excel($data['wil']);
		}
		$this->rekap_total_perhitungan($data['data']);
   	}

   	function rekap_jumlah_perhitungan($rekap){
    	$excel = new PHPExcel();
    	$title = "Laporan Rekapitulasi Perhitungan Amplop APP (Jumlah Amplop) - per tanggal ".(date("d-m-Y"));
    	$excel = $this->excelTitle($excel,'RAMP',$title,"Laporan Rekapitulasi","Data Rekapitulasi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekapitulasi Perhitungan Amplop APP"); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Data per Tanggal ".(date("d-m-Y"))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		// $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "No"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "Wilayah");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "Lingkungan"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "Jumlah Amplop Dibagikan"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "Jumlah Amplop Terhitung"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "Persentase");

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$jumlah_bagi = 0;
		$jumlah_hitung = 0;
		foreach ($rekap as $d) {
			$persentase =  $d->jumlah_terhitung / $d->jumlah_amplop ; 
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->wilayah );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->lingkungan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->jumlah_amplop);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->jumlah_terhitung);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $persentase);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$jumlah_bagi+=$d->jumlah_amplop;
			$jumlah_hitung+=$d->jumlah_terhitung;
		}
		$persentase =  $jumlah_hitung / $jumlah_bagi; 
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'Total');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'C'.$numrow); 
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $jumlah_bagi);
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $jumlah_hitung);
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $persentase);

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:E'.$numrow);
		$excel = $this->setformat($excel,'F4:F'.$numrow,'0.00%');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekapitulasi");
    	
    	//Detail Data//
    	$index=1;
    	foreach ($rekap as $d) {
    		$excel->createSheet($index);
			$excel->setActiveSheetIndex($index)->setCellValue('A1', "Perhitungan Amplop APP"); 
			$data = $this->umat_m->get_data_all('','',$d->kode_lingkungan);
			$this->data_perlingkungan($excel,$data,$d->lingkungan,$d->wilayah);
			$index++;
    	}
		
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if(ob_get_length() > 0) {
		    ob_clean();
		}
		$write->save('php://output');
		exit();	
    }

   	public function jumlah($cetak=""){
   		$data=array();
		$data['menu']='grafik-jumlah';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Rekap Jumlah Amplop';
		$data['opt'] = $this->input->get('option');
   		$data['wil'] = $this->input->get('wilayah');
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		if($data['opt']=='umat'){
			$data['data'] = $this->umat_m->jumlah_rekap_lingkungan($data['wil']);
		} else {
			$data['data'] = $this->rekaplingkungan_m->jumlah_rekap_lingkungan($data['wil']);
		}
		$this->rekap_jumlah_perhitungan($data['data']);
   	}

   	function rekap_pengembalian_amplop($rekap){
    	$excel = new PHPExcel();
    	$title = "Laporan Rekapitulasi Penerimaan Amplop APP - per tanggal ".(date("d-m-Y"));
    	$excel = $this->excelTitle($excel,'RAMP',$title,"Laporan Rekapitulasi","Data Rekapitulasi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekapitulasi Penerimaan Amplop APP"); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Data per Tanggal ".(date("d-m-Y"))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		// $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "No"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "Wilayah");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "Lingkungan"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "Jumlah Amplop Dibagikan"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "Jumlah Amplop Diterima"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "Persentase");

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$jumlah_bagi = 0;
		$jumlah_kembali = 0;
		foreach ($rekap as $d) {
			$persentase =  $d->jumlah_pengembalian / $d->jumlah_amplop ; 
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->wilayah );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->lingkungan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->jumlah_amplop);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->jumlah_pengembalian);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $persentase);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$jumlah_bagi+=$d->jumlah_amplop;
			$jumlah_kembali+=$d->jumlah_pengembalian;
		}
		$persentase =  $jumlah_kembali / $jumlah_bagi; 
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'Total');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'C'.$numrow); 
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $jumlah_bagi);
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $jumlah_kembali);
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $persentase);

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:E'.$numrow);
		$excel = $this->setformat($excel,'F4:F'.$numrow,'0.00%');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekapitulasi");
    	
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if(ob_get_length() > 0) {
		    ob_clean();
		}
		$write->save('php://output');
		exit();	
    }

   	public function pengembalian($cetak=""){
   		$data=array();
		$data['menu']='grafik-kembali';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Rekap Pengembalian Amplop';
		$data['opt'] = $this->input->get('option');
   		$data['wil'] = $this->input->get('wilayah');
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		$data['data'] = $this->kembaliamplop_m->jumlah_pengembalian_amplop($data['wil']);
		$this->rekap_pengembalian_amplop($data['data']);
   	}

   	function import(){
   		$tmpfname = "LIST KK DATA AMPLOP FIX.xlsx";
   		$tmpfname = "assets/upload/import/".$tmpfname;
   		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$sheetCount = $excelObj->getSheetCount();
		for($i=0; $i<$sheetCount; $i++){
			$worksheet = $excelObj->getSheet($i);
			$lingkungan =  $worksheet->getCell('A3')->getValue();
			$lingkungan = str_replace("Lingkungan : ", '', $lingkungan);
			$dataling = $this->lingkungan_m->get_detail_bynama($lingkungan);
			if($dataling){
				echo "Inser Data $lingkungan";
				$row=5;
				$status = true;
				$berhasil=0;$gagal=0;
				while($status){
					$no = $worksheet->getCell('A'.$row)->getValue();
					if(empty($no))
						break;
					$kk_id = $worksheet->getCell('D'.$row)->getValue();
					$nama = $worksheet->getCell('E'.$row)->getValue();
					$input=array(
						'kk_id' => $kk_id,			
						'nama' => strtoupper($nama),			
						'kode_lingkungan' => $dataling->kode_lingkungan			
					);
					$insert=$this->umat_m->insert('amplop_umat',$input);
					if($this->db->affected_rows()){            
		                $berhasil++;
		            } else {                
		                $gagal++;
		            }
					$row++;
				}
				echo " -> Berhasil: ".$berhasil." - Gagal: ".$gagal;
				echo "<br/>";
			} else {
				echo "$lingkungan - Gagal<br/>";
			}	
		}
   	}
}
