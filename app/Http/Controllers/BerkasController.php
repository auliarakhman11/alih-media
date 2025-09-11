<?php

namespace App\Http\Controllers;

use App\Models\AksesProses;
use App\Models\Berkas;
use App\Models\History;
use App\Models\JenisHak;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Proses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BerkasController extends Controller
{
    public function index(){

        return view('berkas.index',[
            'title' => 'Input Berkas',
            'kecamatan' => Kecamatan::all(),
            'kelurahan' => Kelurahan::all(),
            'jenis_hak' => JenisHak::all(),
        ]);
    }

    public function getKelurahan($kecamatan_id){
        if ($kecamatan_id == 0) {
            $dt_kelurahan = Kelurahan::all();
        }else{
            $dt_kelurahan = Kelurahan::where('kecamatan_id',$kecamatan_id)->get();
        }
        
            echo '<option value="">Pilih kelurahan</option>';
        foreach ($dt_kelurahan as $d) {
            echo '<option value="'.$d->id.'|'.$d->kecamatan_id.'">'.$d->nm_kelurahan.' ('.$d->kecamatan->nm_kecamatan.')</option>';
        }

    }

    public function addBerkas(Request $request){

        $cek = Berkas::where('no_hak',sprintf("%05d", $request->no_hak))->where('kecamatan_id',$request->kecamatan_id)->where('kelurahan_id',$request->kelurahan_id)->where('jenis_hak_id',$request->jenis_hak_id)->where('selesai','!=',2)->first();

        if ($cek) {
            return false;
        } else {

            if($request->hasFile('file_name')){
                $name_file = strtoupper(Str::random(5)).date('Ymd');
                $extension = $request->file('file_name')->extension();
                $file_name = $name_file.'.'.$extension;
                $request->file('file_name')->move('scan/',$file_name);
            }else{
                $file_name = null;
            }

            $berkas = Berkas::create([
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'jenis_hak_id' => $request->jenis_hak_id,
                'no_hak' => sprintf("%05d", $request->no_hak),
                'nm_pemohon' => $request->nm_pemohon,
                'percepatan' => 0,
                'no_peta' => $request->no_peta,
                'tahun_peta' => $request->tahun_peta,
                'jenis_peta_id' => $request->jenis_peta_id,
                'nib' => $request->nib,
                'file_name' => $file_name
            ]);
            
    
            History::create([
            
                'berkas_id' => $berkas->id,
                'proses_id' => 1,
                'dari' => Auth::id(),
                'user_id' => 32,
                'selesai' => date('Y-m-d H:i:s'),
            ]);

            History::create([
            
                'berkas_id' => $berkas->id,
                'proses_id' => 2,
                'dari' => Auth::id(),
            ]);
    
            return true;
        }
        

        
    }

    public function listBerkas(){
        return view('berkas.list_berkas',[
            'title' => 'Daftar Berkas',
        ]);
    }

    public function getListBerkas()
    {
        // $pengajuan = Berkas::query()->select('berkas.*')->selectRaw("dt_berkas.tanggal, dt_berkas.asal_berkas, dt_induk.ket_induk, dt_induk.induk_selesai")
        // ->leftJoin(
        //     DB::raw("(SELECT berkas.id, DATE_FORMAT(berkas.updated_at, '%d-%m-%Y') as tanggal, users.name as asal_berkas FROM berkas LEFT JOIN users ON berkas.dari = users.id GROUP BY id) dt_berkas"), 
        //         'berkas.id', '=', 'dt_berkas.id'
        // )
        // ->leftJoin(
        //     DB::raw("(SELECT berkas.id, berkas.selesai as induk_selesai, CONCAT('Alih media induk ',jenis_hak.nm_hak,' ',berkas.no_hak) as ket_induk FROM berkas LEFT JOIN jenis_hak ON berkas.jenis_hak_id = jenis_hak.id GROUP BY id) dt_induk"), 
        //         'berkas.induk_id', '=', 'dt_induk.id'
        // )
        // ->where('user_id',Auth::id())->where('buka_validasi_bt',1)->where('buka_validasi_su',1)->where('selesai',0)->orderBy('percepatan','DESC')->orderBy('id','ASC')->with(['kecamatan','kelurahan','proses','jenis_hak','dari']);

        $pengajuan = History::select('history.proses_id','history.berkas_id','history.id','history.ket','history.user_id','history.dari')->selectRaw("dt_berkas.nm_kecamatan,dt_berkas.nm_kelurahan, dt_berkas.dt_hak, dt_berkas.no_hak, dt_berkas.dt_peta, dt_berkas.nib, dt_berkas.nm_pemohon, dt_berkas.tanggal, dt_berkas.percepatan, dt_berkas.file_name, dt_berkas.lama_tgl, dt_induk.ket_induk, dt_induk.induk_selesai")
        ->leftJoin(
            DB::raw("(SELECT berkas.*, nm_kecamatan, nm_kelurahan, CONCAT(DATE_FORMAT(berkas.created_at, '%d-%m-%Y'),'<br>',IF(berkas.ket IS NOT NULL, berkas.ket,'')) as tanggal, CONCAT(kode_hak,'-',no_hak) as dt_hak, CONCAT(nm_jenis_peta,'-',no_peta,'-',tahun_peta) as dt_peta, datediff(current_date(), berkas.created_at) as lama_tgl FROM berkas 
            LEFT JOIN kecamatan ON berkas.kecamatan_id = kecamatan.id
            LEFT JOIN kelurahan ON berkas.kelurahan_id = kelurahan.id
            LEFT JOIN jenis_hak ON berkas.jenis_hak_id = jenis_hak.id
            LEFT JOIN jenis_peta ON berkas.jenis_peta_id = jenis_peta.id
            GROUP BY id) dt_berkas"), 
                'history.berkas_id', '=', 'dt_berkas.id'
        )
        ->leftJoin(
            DB::raw("(SELECT berkas.id, berkas.selesai as induk_selesai, CONCAT('Alih media induk ',jenis_hak.nm_hak,' ',berkas.no_hak) as ket_induk FROM berkas LEFT JOIN jenis_hak ON berkas.jenis_hak_id = jenis_hak.id GROUP BY id) dt_induk"), 
                'dt_berkas.induk_id', '=', 'dt_induk.id'
        )
        ->whereIn('history.proses_id',Session::get('aksesProses'))
        ->where(function($query){
            $query->where('history.user_id',Auth::id())->orWhere('history.user_id',0);
        })
        ->where('history.selesai',null)->groupBy('history.berkas_id')->groupBy('history.proses_id')->orderBy('user_id','DESC')->orderBy('berkas_id','ASC')->with(['proses','user']);

        return datatables()->of($pengajuan)
                        ->addColumn('action', function($data){
                            $proses_id = $data->proses_id;
                            
                            $button = '';

                            // if ($data->proses_id == 6) {
                            //     if ($data->induk_selesai == '') {
                            //         $button .= '<button class="btn btn-xs btn-primary kirim mt-2 mr-2"  berkas_id="'.$data->berkas_id .'" history_id="'.$data->id .'" jenis="'.$data->proses->jenis .'" proses_id="'.$proses_id.'" ><i class="bx bx-send"></i></button>';
    
                            //         if ($data->proses->kembali) {
                            //             $button .= '<br>';
                            //             $button .= '<button data-bs-toggle="modal" data-bs-target="#modal_kembali" class="btn btn-xs btn-warning kembali mt-2 mr-2"  berkas_id="'.$data->berkas_id .'" history_id="'.$data->id .'" ><i class="bx bx-reset"></i></button>';
                            //         }
                            //     }else {
                            //         if ($data->induk_selesai == 0) {
                            //             $button .= '<span class="text-danger" style="font-size: 10px;;">'.$data->ket_induk.'</span>';
                            //         } else {
                            //             $button .= '<button class="btn btn-xs btn-primary kirim mt-2 mr-2"  berkas_id="'.$data->berkas_id .'" history_id="'.$data->id .'" jenis="'.$data->proses->jenis .'" proses_id="'.$proses_id.'" ><i class="bx bx-send"></i></button>';
                            //         }
                                    
                                    
                            //     }
                            // }elseif($data->proses_id == 7){
                            //     $button .= '<button data-bs-toggle="modal" data-bs-target="#modal_nibel" class="btn btn-xs btn-primary nibel mt-2 mr-2"  berkas_id="'.$data->berkas_id .'" history_id="'.$data->id .'" jenis="'.$data->proses->jenis .'" proses_id="'.$proses_id.'" ><i class="bx bx-send"></i></button>';
                            // }else{
                            //     $button .= '<button class="btn btn-xs btn-primary kirim mt-2 mr-2"  berkas_id="'.$data->berkas_id .'" history_id="'.$data->id .'" jenis="'.$data->proses->jenis .'" proses_id="'.$proses_id.'" ><i class="bx bx-send"></i></button>';
                            // }

                            $button .= '<button class="btn btn-xs btn-primary kirim mt-2 mr-2"  berkas_id="'.$data->berkas_id .'" history_id="'.$data->id .'" jenis="'.$data->proses->jenis .'" proses_id="'.$proses_id.'" ><i class="bx bx-send"></i></button>';


                            $button .= '<br>';
                            $button .= '<button data-bs-toggle="modal" data-bs-target="#modal_keterangan" class="btn btn-xs btn-success keterangan mt-2 mr-2" berkas_id="'.$data->berkas_id .'" history_id="'.$data->id .'" ><i class="bx bxs-message-dots"></i></button>';

                            if ($data->file_name != NULL) {
                                $button .= '<br>';
                            $button .= '<button data-bs-toggle="modal" data-bs-target="#modal_upload" class="btn btn-xs btn-info file_name mt-2 mr-2"  file_name="'.$data->file_name .'" ><i class="bx bxs-file-find"></i></button>';
                            }

                            if ($data->user_id == 0) {
                                $button .= '<br>';
                                $button .= '<button class="btn btn-xs btn-secondary kunci mt-2 mr-2"  history_id="'.$data->id .'" ><i class="bx bxs-lock-open-alt"></i></button>';
                            }else{
                                $button .= '<br>';
                                $button .= '<button class="btn btn-xs btn-warning buka_kunci mt-2 mr-2"  history_id="'.$data->id .'" ><i class="bx bxs-lock" ></i></button>';
                            }

                            
                            return $button;
                            
                        })

                        ->setRowClass(function ($data) {
                            return $data->lama_tgl > 7 ? 'blink' : '';
                        })
                        
                        ->rawColumns(['tanggal','action'])                        
                        ->addIndexColumn()
                        ->make(true);
    }

    public function exportExcel(){
        $berkas = History::select('history.proses_id','history.berkas_id','history.id','history.ket','history.user_id')->selectRaw("dt_berkas.nm_kecamatan,dt_berkas.nm_kelurahan, dt_berkas.kode_hak, dt_berkas.no_hak, dt_berkas.dt_peta, dt_berkas.nib, dt_berkas.nm_pemohon, dt_berkas.tanggal, dt_berkas.percepatan, dt_berkas.file_name, dt_berkas.lama_tgl")
        ->leftJoin(
            DB::raw("(SELECT berkas.*, nm_kecamatan, nm_kelurahan, DATE_FORMAT(berkas.created_at, '%d-%m-%Y') as tanggal,kode_hak, CONCAT(nm_jenis_peta,'-',no_peta,'-',tahun_peta) as dt_peta, datediff(current_date(), berkas.created_at) as lama_tgl FROM berkas 
            LEFT JOIN kecamatan ON berkas.kecamatan_id = kecamatan.id
            LEFT JOIN kelurahan ON berkas.kelurahan_id = kelurahan.id
            LEFT JOIN jenis_hak ON berkas.jenis_hak_id = jenis_hak.id
            LEFT JOIN jenis_peta ON berkas.jenis_peta_id = jenis_peta.id
            GROUP BY id) dt_berkas"), 
                'history.berkas_id', '=', 'dt_berkas.id'
        )
        ->whereIn('history.proses_id',Session::get('aksesProses'))
        ->where(function($query){
            $query->where('history.user_id',Auth::id())->orWhere('history.user_id',0);
        })
        ->where('history.selesai',null)->groupBy('history.berkas_id')->groupBy('history.proses_id')->orderBy('user_id','DESC')->orderBy('berkas_id','ASC')->with('proses')->get();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Alih Media');
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'No');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'Kecamatan');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'Kelurahan');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Hak');
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'No Hak');
        $spreadsheet->getActiveSheet()->setCellValue('F1', 'Data SU');
        $spreadsheet->getActiveSheet()->setCellValue('G1', 'NIB');
        $spreadsheet->getActiveSheet()->setCellValue('H1', 'Proses');
        $spreadsheet->getActiveSheet()->setCellValue('I1', 'Tanggal');
        $spreadsheet->getActiveSheet()->setCellValue('J1', 'Keterangan');

        $style = array(
            'font' => array(
                'size' => 12
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        $spreadsheet->getActiveSheet()->getStyle('A1:J1')->applyFromArray($style);


        $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setWrapText(true);


        $kolom = 2;
        $i = 1;
        foreach ($berkas as $d) {
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, $i++);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $kolom, $d->nm_kecamatan);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $kolom, $d->nm_kelurahan);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $kolom, $d->kode_hak);
            $spreadsheet->getActiveSheet()->setCellValue('E' . $kolom, $d->no_hak);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $kolom, $d->dt_peta);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $kolom, $d->nib);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $kolom, $d->proses->nm_proses);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $kolom, $d->tanggal);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, $d->ket);

            $kolom++;
        }

        $batas = $kolom - 1;

            $border_collom = array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                )
            );
        
        $spreadsheet->getActiveSheet()->getStyle('A1:J' . $batas)->applyFromArray($border_collom);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Alih Media.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }

    

    // public function getKirim($proses_id,$history_id){
    //     // $dt_proses = Proses::where('id',$proses_id)->first();
    //     // if ($proses_id == 8 || $proses_id > 3) {
    //     //     $user = [];
    //     // }else{
    //     //     $user = AksesProses::select()->leftJoin()->where('proses_id',$proses_id+1)
    //     // }

    //     // if ($proses_id > 3) {
    //     //     $proses = 'Pencarian dan Upload BT dan SU';
    //     // }else{
    //     //     $proses = $dt_proses->nm_prose;
    //     // }

    //     if ($proses_id < 3) {
    //         $jenis = 1;
    //     }elseif ($proses_id = 3) {
    //         # code...
    //     }
    //     else {
    //         # code...
    //     }
        


         
        
    //     return view('berkas.get_kirim',[
    //         'user' => $user,
    //         'proses' => $proses,
    //     ]);
    // }

    // public function krimBerkas($jenis,$history_id,$berkas_id,$proses_id){

    //     if ($jenis == 1) {
    //         History::where('id',$history_id)->update([
    //             'selesai' => date('Y-m-d H:i:s'),
    //             'user_id' => Auth::id(),
    //         ]);
    //         $cek = History::where('berkas_id',$berkas_id)->where('selesai',null)->first();

    //         if (!$cek) {
    //             History::create([
        
    //                 'berkas_id' => $berkas_id,
    //                 'proses_id' => 3,
    //                 'dari' => Auth::id(),
    //                 'user_id' => 28,
    //             ]);
    //         }

    //     } elseif ($jenis == 2) {
    //         History::where('id',$history_id)->update([
    //             'selesai' => date('Y-m-d H:i:s')
    //         ]);

    //         History::create([
        
    //             'berkas_id' => $berkas_id,
    //             'proses_id' => 4,
    //             'dari' => Auth::id(),
    //         ]);

    //         History::create([
        
    //             'berkas_id' => $berkas_id,
    //             'proses_id' => 6,
    //             'dari' => Auth::id(),
    //         ]);
    //     } elseif ($jenis == 3) {
    //         History::where('id',$history_id)->update([
    //             'selesai' => date('Y-m-d H:i:s'),
    //             'user_id' => Auth::id(),
    //         ]);

    //         History::create([
        
    //             'berkas_id' => $berkas_id,
    //             'proses_id' => $proses_id + 1,
    //             'dari' => Auth::id(),
    //         ]);
    //     }elseif ($jenis == 4) {
    //         History::where('id',$history_id)->update([
    //             'selesai' => date('Y-m-d H:i:s'),
    //             'user_id' => Auth::id(),
    //         ]);
    //         $cek = History::where('berkas_id',$berkas_id)->where('selesai',null)->first();

    //         if (!$cek) {
    //             History::create([
        
    //                 'berkas_id' => $berkas_id,
    //                 'proses_id' => 8,
    //                 'dari' => Auth::id(),
    //                 'user_id' => Auth::id(),
    //                 'selesai' => date('Y-m-d H:i:s')
    //             ]);

    //             $dt_berkas = Berkas::where('id',$berkas_id)->first();
    //             File::delete('scan/'.$dt_berkas->file_name);

    //             Berkas::where('id',$berkas_id)->update([
    //                 'selesai' => 1,
    //                 'file_name' => null,
    //             ]);

                
    //         }
    //     }else {
    //         return true;
    //     }
        
    // }
    
    public function krimBerkas($jenis,$history_id,$berkas_id,$proses_id){

        if ($jenis == 1) {
            History::where('id',$history_id)->update([
                'selesai' => date('Y-m-d H:i:s'),
                'user_id' => Auth::id(),
            ]);
            $cek = History::where('berkas_id',$berkas_id)->where('selesai',null)->first();

            if (!$cek) {
                History::create([
        
                    'berkas_id' => $berkas_id,
                    'proses_id' => 3,
                    'dari' => Auth::id(),
                    'user_id' => 28,
                ]);
            }

        } elseif ($jenis == 2) {
            History::where('id',$history_id)->update([
                'selesai' => date('Y-m-d H:i:s')
            ]);

            History::create([
        
                'berkas_id' => $berkas_id,
                'proses_id' => 4,
                'dari' => Auth::id(),
            ]);

            History::create([
        
                'berkas_id' => $berkas_id,
                'proses_id' => 6,
                'dari' => Auth::id(),
            ]);
        } elseif ($jenis == 3) {
            History::where('id',$history_id)->update([
                'selesai' => date('Y-m-d H:i:s'),
                'user_id' => Auth::id(),
            ]);

            $cek = History::where('berkas_id',$berkas_id)->where('selesai',null)->first();

            if (!$cek) {
                History::create([
        
                    'berkas_id' => $berkas_id,
                    'proses_id' => 7,
                    'dari' => Auth::id(),
                    'user_id' => 29,
                    // 'selesai' => date('Y-m-d H:i:s')
                ]);

                
            }

            // History::create([
        
            //     'berkas_id' => $berkas_id,
            //     'proses_id' => $proses_id + 1,
            //     'dari' => Auth::id(),
            // ]);
        }elseif($jenis == 6){
            History::where('id',$history_id)->update([
                'selesai' => date('Y-m-d H:i:s'),
                'user_id' => Auth::id(),
            ]);

            History::create([
        
                'berkas_id' => $berkas_id,
                'proses_id' => 8,
                'dari' => Auth::id(),
                'user_id' => Auth::id(),
                'selesai' => date('Y-m-d H:i:s')
            ]);

            Berkas::where('id',$berkas_id)->update([
                'selesai' => 1
            ]);
        }
        // elseif ($jenis == 4) {
        //     History::where('id',$history_id)->update([
        //         'selesai' => date('Y-m-d H:i:s'),
        //         'user_id' => Auth::id(),
        //     ]);
        //     $cek = History::where('berkas_id',$berkas_id)->where('selesai',null)->first();

        //     if (!$cek) {
        //         History::create([
        
        //             'berkas_id' => $berkas_id,
        //             'proses_id' => 8,
        //             'dari' => Auth::id(),
        //             'user_id' => Auth::id(),
        //             'selesai' => date('Y-m-d H:i:s')
        //         ]);

        //         $dt_berkas = Berkas::where('id',$berkas_id)->first();
        //         File::delete('scan/'.$dt_berkas->file_name);

        //         Berkas::where('id',$berkas_id)->update([
        //             'selesai' => 1,
        //             'file_name' => null,
        //         ]);

                
        //     }
        // }
        else {
            return true;
        }
        
    }

    public function pengesahanBt(Request $request){
        History::where('id',$request->history_id)->update([
            'selesai' => date('Y-m-d H:i:s'),
            'user_id' => Auth::id(),
        ]);

        Berkas::where('id',$request->berkas_id)->update([
            'nibel' => $request->nibel,
        ]);

        $cek = History::where('berkas_id',$request->berkas_id)->where('selesai',null)->first();

        if (!$cek) {
            History::create([
    
                'berkas_id' => $request->berkas_id,
                'proses_id' => 8,
                'dari' => Auth::id(),
                'user_id' => Auth::id(),
                'selesai' => date('Y-m-d H:i:s')
            ]);

            Berkas::where('id',$request->berkas_id)->update([
                'selesai' => 1
            ]);
        }
    }

    public function getKembali($berkas_id){
        
        
        return view('berkas.get_kembali',[
            'jenis_hak' => JenisHak::all(),
            'berkas' => Berkas::where('id',$berkas_id)->first(),
            'berkas_id' => $berkas_id,
        ]);
    }


    public function kembaliBerkas(Request $request){

        $cek = Berkas::where('no_hak',sprintf("%05d", $request->no_hak))->where('kecamatan_id',$request->kecamatan_id)->where('kelurahan_id',$request->kelurahan_id)->where('jenis_hak_id',$request->jenis_hak_id)->first();

        if ($cek) {
            Berkas::where('id',$request->berkas_id)->update([
                'induk_id' => $cek->id,
            ]);

            return false;
        } else {
            $berkas = Berkas::create([
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'jenis_hak_id' => $request->jenis_hak_id,
                'proses_id' => 1,
                'no_hak' => sprintf("%05d", $request->no_hak),
                'percepatan' => $request->percepatan ? $request->percepatan : 0,
                'ket' => $request->ket,
                'no_peta' => $request->no_peta,
                'tahun_peta' => $request->tahun_peta,
                'jenis_peta_id' => $request->jenis_peta_id,
                'nib' => $request->nib,
            ]);
    
            History::create([
                
                'berkas_id' => $berkas->id,
                'proses_id' => 1,
                'dari' => Auth::id(),
            ]);
    
            History::create([
            
                'berkas_id' => $berkas->id,
                'proses_id' => 2,
                'dari' => Auth::id(),
            ]);
    
            Berkas::where('id',$request->berkas_id)->update([
                'induk_id' => $berkas->id,
            ]);
    
            return true;
        }
        

    }

    public function bukaValidasi(){
        return view('berkas.buka_validasi',[
            'title' => 'Daftar Berkas',
        ]);
    }

    public function getListBukaValidasi()
    {

        $seksi_id = Auth::user()->seksi_id;
        if ($seksi_id == 2) {
            $pengajuan = Berkas::query()->select('berkas.*')->selectRaw("dt_berkas.tanggal, dt_berkas.asal_berkas, 2 as seksi_id")
            ->leftJoin(
                DB::raw("(SELECT berkas.id, DATE_FORMAT(berkas.updated_at, '%d-%m-%Y') as tanggal, users.name as asal_berkas FROM berkas LEFT JOIN users ON berkas.dari = users.id GROUP BY id) dt_berkas"), 
                    'berkas.id', '=', 'dt_berkas.id'
            )->where('buka_validasi_bt',0,Auth::id())->orderBy('percepatan','DESC')->orderBy('id','ASC')->with(['kecamatan','kelurahan','proses','jenis_hak','dari']);
        } else {
            $pengajuan = Berkas::query()->select('berkas.*')->selectRaw("dt_berkas.tanggal, dt_berkas.asal_berkas, 3 as seksi_id")
            ->leftJoin(
                DB::raw("(SELECT berkas.id, DATE_FORMAT(berkas.updated_at, '%d-%m-%Y') as tanggal, users.name as asal_berkas FROM berkas LEFT JOIN users ON berkas.dari = users.id GROUP BY id) dt_berkas"), 
                    'berkas.id', '=', 'dt_berkas.id'
            )->where('buka_validasi_su',0,Auth::id())->orderBy('percepatan','DESC')->orderBy('id','ASC')->with(['kecamatan','kelurahan','proses','jenis_hak','dari']);
        }
        

        return datatables()->of($pengajuan)
                        ->addColumn('action', function($data){

                            $button = '';
                            
                            $button .= '<button type="button" class="btn btn-xs btn-primary buka"  berkas_id="'.$data->id .'" seksi_id="'.$data->seksi_id .'" ><i class="bx bxs-lock"></i></button>';

                            

                            return $button;
                            
                        })

                        ->setRowClass(function ($data) {
                            return $data->percepatan ? 'blink' : '';
                        })
                        
                        ->rawColumns(['tanggal','action'])                        
                        ->addIndexColumn()
                        ->make(true);
    }

    public function bukaValidasiBerkas($berkas_id, $seksi_id){
        if ($seksi_id == 2) {
            Berkas::where('id',$berkas_id)->update([
                'buka_validasi_bt' => 1,
                'user_id' => Auth::id()
            ]);
        }else{
            Berkas::where('id',$berkas_id)->update([
                'buka_validasi_su' => 1,
                'user_id' => Auth::id()
            ]);
        }

        $cek = Berkas::where('id',$berkas_id)->where('buka_validasi_bt',1)->where('buka_validasi_su',1)->first();

        if ($cek) {
            Berkas::where('id',$berkas_id)->update([
                'proses_id' => 2,
                'dari' => Auth::id(),
                'user_id' => 28,
            ]);

            $history = History::where('berkas_id',$berkas_id)->orderBy('id','DESC')->first();

            History::where('id',$history->id)->update([
                'selesai' => date('Y-m-d H:i:s')
            ]);

            History::create([
            
                'berkas_id' => $berkas_id,
                'proses_id' => 2,
                'dari' => Auth::id(),
                'user_id' => 28,
            ]);
        }

        return true;

    }

    public function getKeterangan($berkas_id, $history_id){
        return view('berkas.get_keterangan',[
            'dt_history' => History::where('id',$history_id)->first(),
            'dt_berkas' => History::where('berkas_id',$berkas_id)->where('ket','!=',null)->where('id','!=',$history_id)->get(),
            'berkas_id' => $berkas_id,
            'history_id' => $history_id
        ])->render();
    }


    public function keteranganBerkas(Request $request){
        History::where('id',$request->history_id)->update([
            'ket' => $request->ket,
            'user_ket' => Auth::id()
        ]);
        
        return true;
    }

    public function kunciBerkas($history_id){
        History::where('id',$history_id)->update([
            'user_id' => Auth::id()
        ]);

        return true;
    }

    public function bukaBerkas($history_id){
        History::where('id',$history_id)->update([
            'user_id' => 0
        ]);

        return true;
    }
    
    // public function import(){
        
    //     return view('berkas.import',[
    //         'title' => 'import'
    //     ]);

    // }
    
    // public function importDataSU(Request $request)
    // {
    //     $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    //     $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
        
    //     $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    //     $numrow = 1;

        
    //         foreach ($sheet as $row) {

    //             if ($row['A'] == "" &&  $row['B'] == "" &&  $row['C'] == "" &&  $row['D'] == "" &&  $row['E'] == "" &&  $row['F'] == "" &&  $row['G'] == "" &&  $row['H'] == "" )
    //                 continue;

    //             // $datetime = DateTime::createFromFormat('Y-m-d', $row['A']);
    //             if ($numrow > 1) {

    //                 Berkas::where('kelurahan_id',$row['A'])->where('jenis_hak_id',$row['C'])->where('no_hak',sprintf("%05d",$row['D']))->update([
    //                     'jenis_peta_id' => $row['E'],
    //                     'no_peta' => $row['F'],
    //                     'tahun_peta' => $row['G'],
    //                     'nib' => $row['H'],
    //                 ]);
    //             }
    //             $numrow++; // Tambah 1 setiap kali looping
    //         }

    //         return redirect(route('import'))->with('success','Berkas berhasil diimport');

    // }


}
