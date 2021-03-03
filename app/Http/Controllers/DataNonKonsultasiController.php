<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;


use DB;
use Session;
use Carbon\Carbon;

use App\Mail\NonKonsultasiMail;
use App\User;
use App\Mahasiswa;
use App\Dosen;
use App\Non_konsultasi;

class DataNonKonsultasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('revalidate');
    }

    public function daftarnonkonsultasi()
    {
    	if(Session::get('dosen') != null)
        {
        	$dosen = DB::table('users')
        	->join('dosen','dosen.users_username','=','users.username')
        	->where('users.username',Session::get('dosen'))
        	->get();

        	$data_non_konsultasi = DB::table('non_konsultasi')
        	->select('non_konsultasi.*','mahasiswa.namamahasiswa','mahasiswa.nrpmahasiswa')
        	->join('dosen','dosen.npkdosen','=','non_konsultasi.dosen_npkdosen')
			->join('mahasiswa','mahasiswa.nrpmahasiswa','=','non_konsultasi.mahasiswa_nrpmahasiswa')
			->where('dosen.npkdosen', $dosen[0]->npkdosen)
			->get();
			
			$non_konsultasi_berikutnya = DB::table('non_konsultasi')
            ->select('non_konsultasi.tanggalpertemuan','mahasiswa.namamahasiswa','mahasiswa.nrpmahasiswa')
            ->join('mahasiswa','mahasiswa.nrpmahasiswa','=','non_konsultasi.mahasiswa_nrpmahasiswa')
            ->join('dosen','dosen.npkdosen','=', 'non_konsultasi.dosen_npkdosen')
            ->where('non_konsultasi.dosen_npkdosen',$dosen[0]->npkdosen )
            ->where('non_konsultasi.status',0)
            ->wheredate('non_konsultasi.tanggalpertemuan','>=',Carbon::now())
            ->orderBy('non_konsultasi.tanggalpertemuan','ASC')
            ->get();


            $this->ubah_status();
        	return view('data_nonkonsultasi.daftarnonkonsultasi_dosen', compact('data_non_konsultasi','non_konsultasi_berikutnya'));
        }
        else
        {
        	return redirect("/");
        }
    }

    public function tambahnonkonsultasi()
    {
    	if(Session::get('dosen') != null)
        {
            $dosen = DB::table('users')
            ->join('dosen','dosen.users_username','=','users.username')
            ->where('users.username',Session::get('dosen'))
            ->get();

            $mahasiswa = DB::table('mahasiswa')
            ->select('*')
            ->join("dosen","dosen.npkdosen","=","mahasiswa.dosen_npkdosen")
            ->where("dosen.npkdosen",$dosen[0]->npkdosen)
            ->get();

            return view('data_nonkonsultasi.tambahnonkonsultasi_dosen', compact('mahasiswa','dosen'));
        }
        else
        {
            return redirect("/");
        }
    }

    public function tambahnonkonsultasi_proses(Request $request)
    {
    	try
    	{
    		$dosen = DB::table('users')
            ->join('dosen','dosen.users_username','=','users.username')
            ->where('users.username',Session::get('dosen'))
            ->get();

            $tanggalpertemuan= $request->get('tanggal_pertemuan');
            $pesan = $request->get('pesan');
            $mahasiswa = $request->get('mahasiswa');

            $this->validate($request,[
                'mahasiswa' =>'required',
                'tanggal_pertemuan'=>'required|after:today',
                'pesan'=>'required|max:100',
            ]);

			$tambah_nonkonsultasi= Non_konsultasi::insert([
			    'tanggalinput'=> now(),
			    'tanggalpertemuan'=> $tanggalpertemuan,
			    'status'=>0,
			    'pesan'=>$pesan,
			    'mahasiswa_nrpmahasiswa'=>$mahasiswa,
			    'dosen_npkdosen'=>$dosen[0]->npkdosen
			]);


			$data_pengguna= DB::table('mahasiswa')
			->select('mahasiswa.namamahasiswa','mahasiswa.nrpmahasiswa','mahasiswa.email','dosen.npkdosen','dosen.namadosen')
			->join('dosen','dosen.npkdosen','=','mahasiswa.dosen_npkdosen')
			->where('mahasiswa.nrpmahasiswa','=',$mahasiswa)
			->get();

			$data=array();
			foreach ($data_pengguna as $d)
			{
				$data=[
					'judul'=> 'Pengumuman Non-Konsultasi Mahasiswa',
					'nama_mahasiswa'=> $d->namamahasiswa,
					'nrp_mahasiswa'=>$d->nrpmahasiswa,
					'email_mahasiswa'=>$d->email,
					'nama_dosen'=>$d->namadosen,
					'npk_dosen' =>$d->npkdosen,
					'tanggal'=>$tanggalpertemuan,
					'pesan'=>$pesan	
				];
			}
			Mail::to($data['email_mahasiswa'])->send(new NonKonsultasiMail($data));

    		return redirect('dosen/data/nonkonsultasi')->with(['Success' => 'Berhasil Menambahkan Data Non-Konsultasi Mahasiswa ('. $mahasiswa.')']);
    	}
    	catch (QueryException $e)
    	{
    		$message= explode("in C:",$e);

            return redirect('dosen/data/nonkonsultasi/tambah')->with(['Error' => 'Gagal Menambahkan Data Kedalam Database <br> Pesan Kesalahan: '.$message[0]]);
    	}
    }

    public function ubahnonkonsultasi($id)
    {
        if(Session::get('dosen') != null)
        {
            $nonkonsultasi = DB::table("non_konsultasi")
            ->select('mahasiswa.nrpmahasiswa','mahasiswa.namamahasiswa', 'non_konsultasi.*')
            ->join('mahasiswa', 'mahasiswa.nrpmahasiswa', '=', 'non_konsultasi.mahasiswa_nrpmahasiswa')
            ->where('idnonkonsultasi',$id)
            ->get();

            return view('data_nonkonsultasi.ubahnonkonsultasi_dosen',compact('nonkonsultasi'));
        }
        else
        {
            return redirect("/");
        }
    }

    public function ubahnonkonsultasi_proses (Request $request)
    {
    	try
        {
            $this->validate($request,[
                'tanggal_pertemuan'=>'required|after:today',
                'pesan'=>'required|max:100',
            ]);

             $nonkonsultasi = DB::table('non_konsultasi')
            ->where('idnonkonsultasi',$request->get('idnonkonsultasi'))
            ->update([
            	'tanggalpertemuan' => $request->get('tanggal_pertemuan'),
                'pesan' => $request->get('pesan')
            ]);

            $data_pengguna= DB::table('non_konsultasi')
			->select('mahasiswa.namamahasiswa','mahasiswa.nrpmahasiswa','mahasiswa.email','dosen.npkdosen','dosen.namadosen')
			->join('dosen','dosen.npkdosen','=','non_konsultasi.dosen_npkdosen')
			->join('mahasiswa','mahasiswa.nrpmahasiswa','=','non_konsultasi.mahasiswa_nrpmahasiswa')
			->where('non_konsultasi.idnonkonsultasi','=',$request->get('idnonkonsultasi'))
			->get();
			
			$data=array();
			foreach ($data_pengguna as $d)
			{
				$data=[
					'judul'=> 'Re-Pengumuman Non-Konsultasi Mahasiswa',
					'nama_mahasiswa'=> $d->namamahasiswa,
					'nrp_mahasiswa'=>$d->nrpmahasiswa,
					'email_mahasiswa'=>$d->email,
					'nama_dosen'=>$d->namadosen,
					'npk_dosen' =>$d->npkdosen,
					'tanggal'=>$request->get('tanggal_pertemuan'),
					'pesan'=> $request->get('pesan')
				];
			}
			Mail::to($data['email_mahasiswa'])->send(new NonKonsultasiMail($data));

            return redirect('dosen/data/nonkonsultasi')->with(['Success' => 'Berhasil Mengubah Data Non-Konsultasi (ID) '.$request->get('idnonkonsultasi')]);
        }
        catch(QueryException $e)
        {
            $message= explode("in C:",$e);
            
            return redirect("dosen/data/nonkonsultasi/ubah/{$request->get('idnonkonsultasi')}")->with(['Error' => 'Gagal Mengubah Data Non-Konsultasi (ID) '.$request->get('idnonkonsultasi')."<br> Pesan Kesalahan: ".$message[0]]);
        }
    }

    public function hapusnonkonsultasi ($id)
    {
        try
        {
            $hapus_non_konsultasi = DB::table('non_konsultasi')
                ->where('idnonkonsultasi', $id)
                ->delete();

            return redirect('dosen/data/nonkonsultasi')->with(['Success' => 'Berhasil Menghapus Data Non-Konsultasi (ID) '.$id]);
        }

        catch(QueryException $e)
        {
            $message= explode("in C:",$e);

            return redirect("dosen/data/nonkonsultasi")->with(['Error' => 'Gagal Menghapus Data (ID) '.$id."<br> Pesan Kesalahan: ".$message[0]]);
        }
    }

    public function ubah_status()
    {
        if(Session::get('dosen')!=null)
        {
            $dosen = DB::table('users')
        	->join('dosen','dosen.users_username','=','users.username')
        	->where('users.username',Session::get('dosen'))
        	->get();

        	$data_non_konsultasi = DB::table('non_konsultasi')
        	->select('idnonkonsultasi','tanggalpertemuan','non_konsultasi.status')
			->join('dosen','dosen.npkdosen','=','non_konsultasi.dosen_npkdosen')
			->where('non_konsultasi.status',0)
			->where('dosen.npkdosen', $dosen[0]->npkdosen)
			->whereDate('tanggalpertemuan','<=', now())
			->get();

			foreach ($data_non_konsultasi as $d ) 
			{
        		$topik = DB::table('non_konsultasi')
                ->where('idnonkonsultasi', $d->idnonkonsultasi)
                ->update([
                    'status' => 1
                ]);	
			}
        }
        else
        {
            return redirect("/");
        }
    }


     public function daftarnonkonsultasi_mahasiswa()
    {
        if(Session::get('mahasiswa') != null)
        {
            $mahasiswa = DB::table('users')
            ->join('mahasiswa','mahasiswa.users_username','=','users.username')
            ->where('users.username',Session::get('mahasiswa'))
            ->get();

            $data_non_konsultasi = DB::table('non_konsultasi')
            ->select('non_konsultasi.*','dosen.namadosen','dosen.npkdosen','mahasiswa.namamahasiswa','mahasiswa.nrpmahasiswa')
            ->join('dosen','dosen.npkdosen','=','non_konsultasi.dosen_npkdosen')
            ->join('mahasiswa','mahasiswa.nrpmahasiswa','=','non_konsultasi.mahasiswa_nrpmahasiswa')
            ->where('mahasiswa.nrpmahasiswa', $mahasiswa[0]->nrpmahasiswa)
            ->get();

            $non_konsultasi_berikutnya = DB::table('non_konsultasi')
            ->select('non_konsultasi.tanggalpertemuan','dosen.namadosen','dosen.npkdosen')
            ->join('mahasiswa','mahasiswa.nrpmahasiswa','=','non_konsultasi.mahasiswa_nrpmahasiswa')
            ->join('dosen','dosen.npkdosen','=', 'non_konsultasi.dosen_npkdosen')
            ->where('mahasiswa.nrpmahasiswa', $mahasiswa[0]->nrpmahasiswa)
            ->where('non_konsultasi.status',0)
            ->wheredate('non_konsultasi.tanggalpertemuan','>=',Carbon::now())
            ->orderBy('non_konsultasi.tanggalpertemuan','ASC')
            ->get();

            // dd($non_konsultasi_berikutnya);

            return view('data_nonkonsultasi.daftarnonkonsultasi_mahasiswa', compact('data_non_konsultasi','non_konsultasi_berikutnya'));
        }
        else
        {
            return redirect("/");
        }
    }

}
 