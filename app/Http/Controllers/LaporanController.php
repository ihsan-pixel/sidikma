<?php

namespace App\Http\Controllers;


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class LaporanController extends Controller
{
    public function view()
    {
        $data['title'] = "Laporan";

        $data['payment'] = DB::select("select * from payment");
        $data['kelas'] = DB::select("select * from kelas");
        $data['thajaran'] = DB::select("select * from tahun_ajaran where active = 'ON'");
        $data['jnpembayaran'] = DB::select("select * from jenis_pembayaran where status = 'ON'");
        return view('backend.laporan.view', $data);
    }
    public function load_data(Request $request)
    {
        // dd($request->)
        // $and = "";
        $and1 = $request->thajaran_id != null ? "and t.thajaran_id = '$request->thajaran_id'" : "";
        $and2 = $request->kelas_id != null ? "and t.kelas_id = '$request->kelas_id'" : "";
        $and3 = $request->jenis_pembayaran != null ? "and t.jenis_pembayaran = '$request->jenis_pembayaran'" : "";
        // dd($and3);
        if ($and1 != "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran where 1=1 $and1 $and2 $and3");
        } elseif ($and2 != "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran where 1=1 $and1 $and2 $and3");
        } elseif ($and3 != "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran where 1=1 $and1 $and2 $and3");
        } elseif ($and1 || $and2 || $and3 == "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran");
        }

        // dd($data);
        echo json_encode($data);
    }

    public function cetakExcel(Request $request)
    {
        // dd(request()->user()->name);
        $and1 = $request->thajaran_id != null ? "and t.thajaran_id = '$request->thajaran_id'" : "";
        $and2 = $request->kelas_id != null ? "and t.kelas_id = '$request->kelas_id'" : "";
        $and3 = $request->jenis_pembayaran != null ? "and t.jenis_pembayaran = '$request->jenis_pembayaran'" : "";
        // dd($and3);
        if ($and1 != "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran where 1=1 $and1 $and2 $and3");
        } elseif ($and2 != "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran where 1=1 $and1 $and2 $and3");
        } elseif ($and3 != "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran where 1=1 $and1 $and2 $and3");
        } elseif ($and1 || $and2 || $and3 == "") {
            $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran");
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER,)
        );
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER,)
        );
        foreach (range('A1', 'G1') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getStyle('A3:G3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('d5d5d5');
        $sheet->setCellValue(
            'A1',
            'LAPORAN KEUANGAN'
        );
        $sheet->setCellValue(
            'A2',
            ' Laporan PADA TANGGAL ' . now() . ''
        );

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A3', 'Nama Lengkap');
        $sheet->setCellValue('B3', 'Tahun');
        $sheet->setCellValue('C3', 'Pembayaran');
        $sheet->setCellValue('D3', 'Nilai');
        $sheet->setCellValue('E3', 'Metode Pembayaran');
        $sheet->setCellValue('F3', 'Status');
        $sheet->setCellValue('G3', 'Dibuat');
        $rows = 4;
        // dd($data);
        foreach ($data as $pemDetails) {
            $sheet->setCellValue('A' . $rows, $pemDetails->nama_lengkap);
            $sheet->setCellValue('B' . $rows, $pemDetails->tahun);
            $sheet->setCellValue('C' . $rows, $pemDetails->pembayaran);
            $sheet->setCellValue('D' . $rows,  $pemDetails->nilai);
            $sheet->setCellValue('E' . $rows,  $pemDetails->metode_pembayaran);
            $sheet->setCellValue('F' . $rows, $pemDetails->status);
            $sheet->setCellValue('G' . $rows, $pemDetails->created_at);
            $rows++;
        }
        $Sheet = $spreadsheet->getActiveSheet();
        $lABC1 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $lABC2 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        for ($I = 0; $I < count($lABC1); $I++) :
            $Sheet->getColumnDimension($lABC1[$I])->setAutoSize(true);
            for ($J = 0; $J < 6; $J++) {
                $Sheet->getColumnDimension($lABC2[$J] . $lABC1[$I])->setAutoSize(true);
            }
        endfor;
        $fileName = "" . request()->user()->nama_lengkap . "";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan ' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save('php://output');


        ob_start();
        $writer->save(public_path('storage/excel/' . $fileName . '.xlsx'));
        ob_end_clean();

        $response =  array(
            'op' => 'ok',
            'file' => '' . $fileName . '.xlsx'
        );
        // dd(response());
        die(json_encode($response));
    }
    public function cetakExcelById(Request $request)
    {

        $data = DB::select("SELECT p.*, u.nama_lengkap, ta.tahun, jp.pembayaran FROM payment p 
        LEFT JOIN users u on u.id=p.user_id LEFT JOIN bulan b on b.id=p.bulan_id LEFT JOIN tagihan t on t.id=p.tagihan_id 
        LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran 
        where t.id = '$request->tagihan_id'");
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER,)
        );
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER,)
        );
        foreach (range('A1', 'G1') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getStyle('A3:G3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('d5d5d5');
        $sheet->setCellValue(
            'A1',
            'LAPORAN KEUANGAN'
        );
        $sheet->setCellValue(
            'A2',
            ' Laporan PADA TANGGAL ' . now() . ''
        );

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A3', 'Nama Lengkap');
        $sheet->setCellValue('B3', 'Tahun');
        $sheet->setCellValue('C3', 'Pembayaran');
        $sheet->setCellValue('D3', 'Nilai');
        $sheet->setCellValue('E3', 'Metode Pembayaran');
        $sheet->setCellValue('F3', 'Status');
        $sheet->setCellValue('G3', 'Dibuat');
        $rows = 4;
        // dd($request->all());
        foreach ($data as $pemDetails) {
            $sheet->setCellValue('A' . $rows, $pemDetails->nama_lengkap);
            $sheet->setCellValue('B' . $rows, $pemDetails->tahun);
            $sheet->setCellValue('C' . $rows, $pemDetails->pembayaran);
            $sheet->setCellValue('D' . $rows,  $pemDetails->nilai);
            $sheet->setCellValue('E' . $rows,  $pemDetails->metode_pembayaran);
            $sheet->setCellValue('F' . $rows, $pemDetails->status);
            $sheet->setCellValue('G' . $rows, $pemDetails->created_at);
            $rows++;
        }
        $Sheet = $spreadsheet->getActiveSheet();
        $lABC1 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $lABC2 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        for ($I = 0; $I < count($lABC1); $I++) :
            $Sheet->getColumnDimension($lABC1[$I])->setAutoSize(true);
            for ($J = 0; $J < 6; $J++) {
                $Sheet->getColumnDimension($lABC2[$J] . $lABC1[$I])->setAutoSize(true);
            }
        endfor;
        $fileName = "" . request()->user()->nis . "";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan ' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save('php://output');


        ob_start();
        $writer->save(public_path('storage/excel/' . $fileName . '.xlsx'));

        // public_path('storage/excel/'.$fileName.'.xlsx') ;
        // $xlsData = ob_get_contents();
        ob_end_clean();

        $response =  array(
            'op' => 'ok',
            'file' => ''.url('/storage/excel').'/' . $fileName . '.xlsx'
        );
        // dd(response());
        die(json_encode($response));

        // dd(response());
        // die(json_encode($response));
    }
    function bulananPdf($id_tagihan)
    {
        $data['date'] = now();
        $data['users'] = DB::select("select s.*, u.nama_lengkap from payment s 
        left join users u on u.id=s.user_id where s.tagihan_id = '$id_tagihan' limit 1");
        $data['bulanan'] = DB::select("select s.*, u.nama_lengkap, ta.tahun, jp.pembayaran, b.nama_bulan 
        from payment s left join users u on u.id=s.user_id left join bulan b on b.id=s.bulan_id 
        left join tagihan t on t.id=s.tagihan_id left join tahun_ajaran ta on ta.id=t.thajaran_id 
        left join jenis_pembayaran jp on jp.id=t.jenis_pembayaran where t.id = '$id_tagihan' order by bulan_id asc");
        $pdf = PDF::loadView('backend.laporan.pdfViewBulanan', $data);
        // $pdf = PDF::loadView('backend.laporan.pdfViewBulanan', compact('invoiceItems', 'invoiceData'));
        return $pdf->download('Bulanan_' . $id_tagihan . '_' . now() . '.pdf');
    }
    function bulananPdfById($id_payment)
    {
        
        $data['date'] = now();
        $data['spp'] = DB::select("select s.*, u.nama_lengkap, ta.tahun, jp.pembayaran, b.nama_bulan from payment s 
        left join users u on u.id=s.user_id left join bulan b on b.id=s.bulan_id left join tagihan t on t.id=s.tagihan_id 
        left join tahun_ajaran ta on ta.id=t.thajaran_id left join jenis_pembayaran jp on jp.id=t.jenis_pembayaran 
        where s.id = '$id_payment' order by bulan_id asc");
        $pdf = PDF::loadView('backend.laporan.pdfViewBulananById', $data);
        // $pdf = PDF::loadView('backend.laporan.pdfViewBulanan', compact('invoiceItems', 'invoiceData'));
        return $pdf->download('Bulanan_' . $id_payment . '_' . now() . '.pdf');
    }
    function lainyaPdf($id_tagihan)
    {
        $users = DB::select("select t.*, u.nama_lengkap from tagihan t 
        left join users u on u.id=t.user_id where t.id = '$id_tagihan'");

        $data['nama_lengkap'] = $users[0]->nama_lengkap;
        // dd($data['users']);
        $data['date'] = now();
        $data['lainya'] = DB::select("select t.*, u.nama_lengkap, ta.tahun, jp.pembayaran, u.alamat, p.order_id, p.pdf_url, p.metode_pembayaran, 
        p.status as status_payment from tagihan t left join users u on t.user_id=u.id left join tahun_ajaran ta on ta.id=t.thajaran_id 
        left join jenis_pembayaran jp on jp.id=t.jenis_pembayaran left join payment p on p.tagihan_id=t.id 
        where t.id = '$id_tagihan' and t.jenis_pembayaran != '1'");
        // dd($data['lainya']);
        $pdf = PDF::loadView('backend.laporan.pdfViewLainya', $data);
        // $pdf = PDF::loadView('backend.laporan.pdfViewBulanan', compact('invoiceItems', 'invoiceData'));
        return $pdf->download('Lainya_' . $id_tagihan . '_' . now() . '.pdf');
    }
}
