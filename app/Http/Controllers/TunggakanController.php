<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TunggakanController extends Controller
{
    public function view()
    {
        $data['title'] = "Tunggakan";
        $data['siswa'] = DB::select("select * from users where role = '2'");

        return view('backend.tunggakan.view', $data);
    }

    public function load_data(Request $request)
    {
        // dd($request->)
        // $and = "";

        $data = DB::select("SELECT z.*, z.tagihan - z.bayar AS tunggakan FROM (
            SELECT t.user_id, u.nama_lengkap, ta.tahun, jp.pembayaran,
            CASE
                WHEN t.jenis_pembayaran = 1 THEN t.nilai * 12
                ELSE t.nilai
                END AS tagihan, SUM(IFNULL(p.nilai, 0)) AS bayar
            FROM tagihan t
            LEFT JOIN payment p on p.tagihan_id=t.id
            LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id
            LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran
            INNER JOIN users u on u.id = t.user_id
            GROUP BY t.user_id, jp.pembayaran, ta.tahun, t.jenis_pembayaran, t.nilai
            ) z
            WHERE z.user_id = '$request->user_id' ORDER BY tunggakan DESC");
        // dd($data);
        echo json_encode($data);
    }
    function cetakTunggakan(Request $request)
    {


        $data = DB::select("SELECT z.*, z.tagihan - z.bayar AS tunggakan FROM (
            SELECT t.user_id, u.nama_lengkap, ta.tahun, jp.pembayaran,
            CASE
                WHEN t.jenis_pembayaran = 1 THEN t.nilai * 12
                ELSE t.nilai
                END AS tagihan, SUM(IFNULL(p.nilai, 0)) AS bayar
            FROM tagihan t
            LEFT JOIN payment p on p.tagihan_id=t.id
            LEFT JOIN tahun_ajaran ta on ta.id=t.thajaran_id
            LEFT JOIN jenis_pembayaran jp on jp.id=t.jenis_pembayaran
            INNER JOIN users u on u.id = t.user_id
            GROUP BY t.user_id, jp.pembayaran, ta.tahun, t.jenis_pembayaran, t.nilai
            ) z
            WHERE z.user_id = '$request->user_id' ORDER BY tunggakan DESC");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER,)
        );
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER,)
        );
        foreach (range('A1', 'D1') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getStyle('A3:D3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('d5d5d5');
        $sheet->setCellValue(
            'A1',
            'LAPORAN TUNGGAKAN'
        );
        $sheet->setCellValue(
            'A2',
            ' Laporan PADA TANGGAL ' . now() . ''
        );

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A3', 'Nama Lengkap');
        $sheet->setCellValue('B3', 'Tahun');
        $sheet->setCellValue('C3', 'Pembayaran');
        $sheet->setCellValue('D3', 'Tagihan');
        $rows = 4;
        // dd($request->all());
        foreach ($data as $pemDetails) {
            $sheet->setCellValue('A' . $rows, $pemDetails->nama_lengkap);
            $sheet->setCellValue('B' . $rows, $pemDetails->tahun);
            $sheet->setCellValue('C' . $rows, $pemDetails->pembayaran);
            $sheet->setCellValue('D' . $rows,  $pemDetails->tagihan);
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
            'file' => '' . url('/storage/excel') . '/' . $fileName . '.xlsx'
        );
        // dd(response());
        die(json_encode($response));

        // dd(response());
        // die(json_encode($response));
    }
}

