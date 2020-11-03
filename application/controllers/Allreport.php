<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Allreport extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('Allreport_model');
        $this->load->model('Listuser_model');
    }

    public function goto2()
    {

        $taa = $this->input->post('ta');
        $tba = $this->input->post('tb');
        $ta = str_replace("-", "", $taa);
        $tb = str_replace("-", "", $tba);
        redirect(base_url('allreport/allreportemp/' . $ta . "/" . $tb));
    }
    function ke()
    {

        $taa = $this->input->post('ta');
        $tba = $this->input->post('tb');
        $empId = $this->uri->segment(3);
        $ta = str_replace("-", "", $taa);
        $tb = str_replace("-", "", $tba);
        redirect(base_url('allreport/reportemp/' . $empId . "/" . $ta . "/" . $tb));
    }

    private function dataEmployee($empCode)
    {
        $emp = $this->Allreport_model->ambilEmployee($empCode);
        $jadwal = $this->Allreport_model->ambilJadwal($empCode);
        return ['emp' => $emp, 'empworkschedule' => $jadwal];
    }

    private function dataLog($empCode)
    {
        $return = array();
        $dataEmployee = $this->dataEmployee($empCode);
        $empworkschedule = $dataEmployee['empworkschedule'];
        foreach ($empworkschedule as $ews) {
            if ($ews['WSCode'] != 'Holiday') {
                $ambilLogMasuk = $this->Allreport_model->ambilLogMasuk($empCode, $ews['Dt'], $ews['bIn1'], $ews['aIn1']);
                if ($ambilLogMasuk) {
                    $data = ['nama' => $ews['WSCode'], 'log' => ['jenis' => 'Masuk', 'tgl' => $ambilLogMasuk['Dt'], 'tm' => $ambilLogMasuk['Tm'], 'selisih' => ($ambilLogMasuk['Tm'] > $ews['In1']) ? $ambilLogMasuk['Tm'] - $ews['In1'] : '-']];
                    array_push($return, $data);
                }
                $ambilLogKeluar = $this->Allreport_model->ambilLogKeluar($empCode, $ews['Dt'], $ews['bOut1'], $ews['aOut1']);
                if ($ambilLogKeluar) {
                    $data = ['nama' => $ews['WSCode'], 'log' => ['jenis' => 'Keluar', 'tgl' => $ambilLogKeluar['Dt'], 'tm' => $ambilLogKeluar['Tm'], 'selisih' => ($ambilLogKeluar['Tm'] < $ews['Out1']) ? $ews['Out1'] - $ambilLogKeluar['Tm'] : '-']];
                    array_push($return, $data);
                }
            } else {
                $data = ['nama' => $ews['WSCode'], 'log' => ['tgl' => $ews['Dt']]];
                array_push($return, $data);
            }
        }
        // var_dump($return);
        return $return;
    }

    public function allreportemp()
    {
        $data['emp'] = $this->Allreport_model->user();
        $hasil = array();
        $jadwal = array();
        foreach ($data['emp'] as $emp) {
            $ambil = $this->dataLog($emp['EmpCode']);
            $jadwalemp = $this->dataEmployee($emp['EmpCode']);
            array_push($hasil, ['emp' => $emp['EmpCode'], $ambil]);
            array_push($jadwal, $jadwalemp);
        }
        $data['jadwal'] = $jadwal;
        $data['absen'] = $hasil;
        // var_dump($hasil);
        // die;
        $data['_view'] = 'report/allreport';
        $this->load->view('layouts/main', $data);
    }

    public function reportemp($emp = null)
    {
        if ($emp == null) {
            $data['listuser'] = $this->Listuser_model->listuser();
            $data['_view'] = 'users/listuser';
            $this->load->view('layouts/main', $data);
        }
        $hasil = array();
        $jadwal = array();
        $ambil = $this->dataLog($emp);
        $jadwalemp = $this->dataEmployee($emp);
        array_push($hasil, ['emp' => $emp, $ambil]);
        array_push($jadwal, $jadwalemp);
        $data['jadwal'] = $jadwal;
        $data['absen'] = $hasil;
        $data['detailuser'] = $this->Listuser_model->detailuser($emp);
        // var_dump($hasil);
        // die;
        $data['_view'] = 'users/detailuser';
        $this->load->view('layouts/main', $data);
    }

    function cetakLaporan()
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Diki Rahmad Sandi - TA')
            ->setLastModifiedBy('Diki Rahmad Sandi - TA')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Laporan PRESENSI')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Laporan');
        $fontStyleKop = [
            'font' => [
                'size' => 16,
                'bold' => true,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'center'
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'LAPORAN PRESENSI')
            ->mergeCells('A1:K1')
            ->getStyle('A1')->applyFromArray($fontStyleKop);
        $fontStyle = [
            'font' => [
                'size' => 8,
                'color' => [
                    'rgb' => 'FF0000'
                ],
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'left'
            ]
        ];
        $fontStyle2 = [
            'font' => [
                'size' => 12,
                'bold' => true,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'center'
            ],
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '000000'),
                ),
            ),
        ];
        $fontStyle3 = [
            'font' => [
                'size' => 12,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'center'
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Format: Tanggal/KodeJadwal/Jenis/Waktu/Selisih')
            ->mergeCells('A2:K2')
            ->getStyle('A2')->applyFromArray($fontStyle);
        $mulai = 5;
        $empList = $this->Listuser_model->listuser();
        // var_dump($empList);
        // die;
        $mulai2 = 5;
        foreach ($empList as $emp) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . ($mulai2 - 1), 'NAMA')
                ->mergeCells('A' . ($mulai2 - 1) . ':C' . ($mulai2 - 1))
                ->getStyle('A' . ($mulai2 - 1) . ':C' . ($mulai2 - 1))->applyFromArray($fontStyle2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('D' . ($mulai2 - 1), ' TANGGAL ')
                ->mergeCells('D' . ($mulai2 - 1) . ':E' . ($mulai2 - 1))
                ->getStyle('D' . ($mulai2 - 1) . ':E' . ($mulai2 - 1))->applyFromArray($fontStyle2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F' . ($mulai2 - 1), 'PRESENSI')
                ->mergeCells('F' . ($mulai2 - 1) . ':K' . ($mulai2 - 1))
                ->getStyle('F' . ($mulai2 - 1) . ':K' . ($mulai2 - 1))->applyFromArray($fontStyle2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $mulai, $emp['EmpName'])
                ->mergeCells('A' . $mulai . ':C' . $mulai)
                ->getStyle('A' . $mulai)->applyFromArray($fontStyle3);
            $jadwalemp = $this->dataEmployee($emp['EmpCode']);
            foreach ($jadwalemp['empworkschedule'] as $jadwal) {
                if ($this->uri->segment(3) != null && $this->uri->segment(4) != null) {
                    if ($jadwal['Dt'] >= $this->uri->segment(3) && $jadwal['Dt'] <= $this->uri->segment(4)) {
                        $tahun1 = substr($jadwal['Dt'], 0, 4);
                        $bulan1 = substr($jadwal['Dt'], 4, 2);
                        $tanggal1 = substr($jadwal['Dt'], 6, 2);
                        $tgl =  '  ' . $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '  ';
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('D' . $mulai2, $tgl)
                            ->mergeCells('D' . $mulai2 . ':E' . $mulai2)
                            ->getStyle('D' . $mulai2)->applyFromArray($fontStyle3);
                        foreach ($this->dataLog($emp['EmpCode']) as $log) {
                            if ($jadwal['Dt'] == $log['log']['tgl']) {
                                if ($log['nama'] == 'Holiday') {
                                    $tahun1 = substr($log['log']['tgl'], 0, 4);
                                    $bulan1 = substr($log['log']['tgl'], 4, 2);
                                    $tanggal1 = substr($log['log']['tgl'], 6, 2);
                                    $presensi1 = $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $log['nama'];
                                    $spreadsheet->setActiveSheetIndex(0)
                                        ->setCellValue('F' . $mulai2, $presensi1)
                                        ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                        ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                                }
                                if ($log['nama'] != 'Holiday') {
                                    $tahun2 = substr($log['log']['tgl'], 0, 4);
                                    $bulan2 = substr($log['log']['tgl'], 4, 2);
                                    $tanggal2 = substr($log['log']['tgl'], 6, 2);
                                    $presensi2 = $tanggal2 . "-" . $bulan2 . "-" . $tahun2 . '/' . $log['nama'] . '/';
                                    $presensi3 = ($log['log']['jenis'] == 'Masuk') ? $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'] . ' | ' : $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'];
                                    $spreadsheet->setActiveSheetIndex(0)
                                        ->setCellValue('F' . $mulai2, $presensi2 . $presensi3)
                                        ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                        ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                                }
                            }
                        }
                        $mulai2++;
                        $mulai++;
                    }
                } else {
                    $tahun1 = substr($jadwal['Dt'], 0, 4);
                    $bulan1 = substr($jadwal['Dt'], 4, 2);
                    $tanggal1 = substr($jadwal['Dt'], 6, 2);
                    $tgl =  '  ' . $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '  ';
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('D' . $mulai2, $tgl)
                        ->mergeCells('D' . $mulai2 . ':E' . $mulai2)
                        ->getStyle('D' . $mulai2)->applyFromArray($fontStyle3);
                    foreach ($this->dataLog($emp['EmpCode']) as $log) {
                        if ($jadwal['Dt'] == $log['log']['tgl']) {
                            if ($log['nama'] == 'Holiday') {
                                $tahun1 = substr($log['log']['tgl'], 0, 4);
                                $bulan1 = substr($log['log']['tgl'], 4, 2);
                                $tanggal1 = substr($log['log']['tgl'], 6, 2);
                                $presensi1 = $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $log['nama'];
                                $spreadsheet->setActiveSheetIndex(0)
                                    ->setCellValue('F' . $mulai2, $presensi1)
                                    ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                    ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                            }
                            if ($log['nama'] != 'Holiday') {
                                $tahun2 = substr($log['log']['tgl'], 0, 4);
                                $bulan2 = substr($log['log']['tgl'], 4, 2);
                                $tanggal2 = substr($log['log']['tgl'], 6, 2);
                                $presensi2 = $tanggal2 . "-" . $bulan2 . "-" . $tahun2 . '/' . $log['nama'] . '/';
                                $presensi3 = ($log['log']['jenis'] == 'Masuk') ? $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'] . ' | ' : $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'];
                                $spreadsheet->setActiveSheetIndex(0)
                                    ->setCellValue('F' . $mulai2, $presensi2 . $presensi3)
                                    ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                    ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                            }
                        }
                    }
                    $mulai2++;
                    $mulai++;
                }
            }

            $styleArray = [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array('argb' => '000000'),
                    ]
                ]
            ];

            $spreadsheet->setActiveSheetIndex(0)->getStyle('A' . ($mulai2 - 1) . ':K' . ($mulai2 - 1))->applyFromArray($styleArray);
            $mulai2 = $mulai2 + 3;
            $mulai = $mulai + 3;
        }

        $spreadsheet->getActiveSheet()->setTitle('Report Excel ' . date('d-m-Y H'));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Report Excel.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    function cetakLaporanEmp($emp)
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Diki Rahmad Sandi - TA')
            ->setLastModifiedBy('Diki Rahmad Sandi - TA')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Laporan PRESENSI')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Laporan');
        $fontStyleKop = [
            'font' => [
                'size' => 16,
                'bold' => true,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'center'
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'LAPORAN PRESENSI')
            ->mergeCells('A1:K1')
            ->getStyle('A1')->applyFromArray($fontStyleKop);
        $fontStyle = [
            'font' => [
                'size' => 8,
                'color' => [
                    'rgb' => 'FF0000'
                ],
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'left'
            ]
        ];
        $fontStyle2 = [
            'font' => [
                'size' => 12,
                'bold' => true,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'center'
            ],
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '000000'),
                ),
            ),
        ];
        $fontStyle3 = [
            'font' => [
                'size' => 12,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => 'center'
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Format: Tanggal/KodeJadwal/Jenis/Waktu/Selisih')
            ->mergeCells('A2:K2')
            ->getStyle('A2')->applyFromArray($fontStyle);
        $emp = $this->Listuser_model->detailuser($emp);
        // var_dump($empList);
        // die;
        $mulai2 = 5;

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . ($mulai2 - 1), 'NAMA')
                ->mergeCells('A' . ($mulai2 - 1) . ':C' . ($mulai2 - 1))
                ->getStyle('A' . ($mulai2 - 1) . ':C' . ($mulai2 - 1))->applyFromArray($fontStyle2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('D' . ($mulai2 - 1), ' TANGGAL ')
                ->mergeCells('D' . ($mulai2 - 1) . ':E' . ($mulai2 - 1))
                ->getStyle('D' . ($mulai2 - 1) . ':E' . ($mulai2 - 1))->applyFromArray($fontStyle2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('F' . ($mulai2 - 1), 'PRESENSI')
                ->mergeCells('F' . ($mulai2 - 1) . ':K' . ($mulai2 - 1))
                ->getStyle('F' . ($mulai2 - 1) . ':K' . ($mulai2 - 1))->applyFromArray($fontStyle2);
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A5', $emp['EmpName'])
                ->mergeCells('A5:C5')
                ->getStyle('A5')->applyFromArray($fontStyle3);
            $jadwalemp = $this->dataEmployee($emp['EmpCode']);
            foreach ($jadwalemp['empworkschedule'] as $jadwal) {
                if ($this->uri->segment(4) != null && $this->uri->segment(5) != null) {
                    if ($jadwal['Dt'] >= $this->uri->segment(4) && $jadwal['Dt'] <= $this->uri->segment(5)) {
                        $tahun1 = substr($jadwal['Dt'], 0, 4);
                        $bulan1 = substr($jadwal['Dt'], 4, 2);
                        $tanggal1 = substr($jadwal['Dt'], 6, 2);
                        $tgl =  '  ' . $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '  ';
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('D' . $mulai2, $tgl)
                            ->mergeCells('D' . $mulai2 . ':E' . $mulai2)
                            ->getStyle('D' . $mulai2)->applyFromArray($fontStyle3);
                        foreach ($this->dataLog($emp['EmpCode']) as $log) {
                            if ($jadwal['Dt'] == $log['log']['tgl']) {
                                if ($log['nama'] == 'Holiday') {
                                    $tahun1 = substr($log['log']['tgl'], 0, 4);
                                    $bulan1 = substr($log['log']['tgl'], 4, 2);
                                    $tanggal1 = substr($log['log']['tgl'], 6, 2);
                                    $presensi1 = $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $log['nama'];
                                    $spreadsheet->setActiveSheetIndex(0)
                                        ->setCellValue('F' . $mulai2, $presensi1)
                                        ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                        ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                                }
                                if ($log['nama'] != 'Holiday') {
                                    $tahun2 = substr($log['log']['tgl'], 0, 4);
                                    $bulan2 = substr($log['log']['tgl'], 4, 2);
                                    $tanggal2 = substr($log['log']['tgl'], 6, 2);
                                    $presensi2 = $tanggal2 . "-" . $bulan2 . "-" . $tahun2 . '/' . $log['nama'] . '/';
                                    $presensi3 = ($log['log']['jenis'] == 'Masuk') ? $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'] . ' | ' : $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'];
                                    $spreadsheet->setActiveSheetIndex(0)
                                        ->setCellValue('F' . $mulai2, $presensi2 . $presensi3)
                                        ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                        ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                                }
                            }
                        }
                        $mulai2++;
                    }
                } else {
                    $tahun1 = substr($jadwal['Dt'], 0, 4);
                    $bulan1 = substr($jadwal['Dt'], 4, 2);
                    $tanggal1 = substr($jadwal['Dt'], 6, 2);
                    $tgl =  '  ' . $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '  ';
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('D' . $mulai2, $tgl)
                        ->mergeCells('D' . $mulai2 . ':E' . $mulai2)
                        ->getStyle('D' . $mulai2)->applyFromArray($fontStyle3);
                    foreach ($this->dataLog($emp['EmpCode']) as $log) {
                        if ($jadwal['Dt'] == $log['log']['tgl']) {
                            if ($log['nama'] == 'Holiday') {
                                $tahun1 = substr($log['log']['tgl'], 0, 4);
                                $bulan1 = substr($log['log']['tgl'], 4, 2);
                                $tanggal1 = substr($log['log']['tgl'], 6, 2);
                                $presensi1 = $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $log['nama'];
                                $spreadsheet->setActiveSheetIndex(0)
                                    ->setCellValue('F' . $mulai2, $presensi1)
                                    ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                    ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                            }
                            if ($log['nama'] != 'Holiday') {
                                $tahun2 = substr($log['log']['tgl'], 0, 4);
                                $bulan2 = substr($log['log']['tgl'], 4, 2);
                                $tanggal2 = substr($log['log']['tgl'], 6, 2);
                                $presensi2 = $tanggal2 . "-" . $bulan2 . "-" . $tahun2 . '/' . $log['nama'] . '/';
                                $presensi3 = ($log['log']['jenis'] == 'Masuk') ? $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'] . ' | ' : $log['log']['jenis'] . '/' . $log['log']['tm'] . '/' . $log['log']['selisih'];
                                $spreadsheet->setActiveSheetIndex(0)
                                    ->setCellValue('F' . $mulai2, $presensi2 . $presensi3)
                                    ->mergeCells('F' . $mulai2 . ':K' . $mulai2)
                                    ->getStyle('F' . $mulai2)->applyFromArray($fontStyle3);
                            }
                        }
                    }
                    $mulai2++;
                }
            }

            $styleArray = [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array('argb' => '000000'),
                    ]
                ]
            ];

            $spreadsheet->setActiveSheetIndex(0)->getStyle('A' . ($mulai2 - 1) . ':K' . ($mulai2 - 1))->applyFromArray($styleArray);


        $spreadsheet->getActiveSheet()->setTitle('Report Excel ' . date('d-m-Y H'));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Report Excel.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
