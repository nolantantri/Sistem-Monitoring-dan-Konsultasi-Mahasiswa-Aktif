<!--Wajib untuk inisialisasi file views/layouts/appadmin-->
@extends('layouts.appadmin')

@push('styles')
  <!-- Untuk menambahkan style baru -->
@endpush

<!-- Isi dari yield -->
@section('content')
    
   

    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Daftar Konsultasi Dosen Wali</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
              <li class="breadcrumb-item active">Daftar Konsultasi Dosen Wali</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (\Session::has('Success'))
      <div class="alert alert-success alert-block">
        <ul>
            <li>{!! \Session::get('Success') !!}</li>
        </ul>
      </div>
    @endif

    
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <a href="{{ url('admin/master/konsultasi/tambah') }}" class="btn btn-primary" role="button">Tambah Data</a>
        <br><br>

        <form method="GET" action="{{url('admin/master/konsultasi/prosescari')}}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="_token" value="{{csrf_token() }}"> 
          
          <label for="exampleInputPencarian">Pencarian Data: </label>

          <div class="form-group">
            
            <select class="btn btn-primary dropdown-toggle btn-sm" name="pencarian" id="pencarian" data-toggle="dropdown">
              <option value="tanggal">Tanggal</option>
              <option value="topik">Topik Konsultasi</option>
              <option value="namadosen">Nama Dosen</option>
              <option value="namamahasiswa">Nama Mahasiswa</option>
              <option value="tahunakademik">Tahun Akademik</option>
            </select>

             <input type="text" name="keyword" id="keyword" placeholder="Enter Keyword">

            <button type="submit" class="btn btn-light"><i class="fas fa-search"></i></button>

            <div id="konsultasiList"></div>
          
          </div>

        </form>
        
        <!-- Small boxes (Stat box) -->
        <table class="table table-bordered table-striped">
          <thead>
            <tr> 
              <th width="1%">No.</th>
              <th width="1%">Tanggal</th>
              <th width="1%">Topik</th>
              <th width="1%">Dosen</th>
              <th width="1%">Mahasiswa</th>
              <th width="1%">Tahun Akademik</th>
              <th width="1%">Detail</th>
              <th width="1%">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($konsultasi as $no => $k)
            <tr>
              <td>{{$no+1}}</td>
              <td>{{$k->tanggalkonsultasi}}</td>
              <td>{{$k->namatopik}}</td>
              <td>{{$k->npkdosen}} - {{$k->namadosen}}</td>
              <td>{{$k->nrpmahasiswa}} - {{$k->namamahasiswa}}</td>
              <td>{{$k->semester}} {{$k->tahun}}</td>
              <td>
                <a href="{{url('admin/master/konsultasi/detail_konsultasi/'.$k->idkonsultasi)}}" class="fas fa-eye" data-toggle="modal" data-target="#detailKonsultasi_{{$k->idkonsultasi}}"></a>
              </td>
              <td>
                <a href="{{url('admin/master/konsultasi/ubah/'.$k->idkonsultasi)}}" class="btn btn-warning">Ubah</a>
                
                <form method="get" action="{{url('admin/master/konsultasi/hapus/'.$k->idkonsultasi)}}">
                  <input type="hidden" name="idtopik" value="{{$k->topik_idtopikkonsultasi}}">
                  <button type="submmit" class="btn btn-danger">Hapus</button>
                </form>
               
              </td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
          <br/>
        Halaman : {{$konsultasi->currentPage()}} <br/>
        Jumlah Data : {{$konsultasi->total()}} <br/>
        Data Per Halaman : {{$konsultasi->perPage()}} <br/>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->

        <!-- Modal -->
        @foreach($konsultasi as $d)
          <div id="detailKonsultasi_{{$d->idkonsultasi}}" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- konten modal-->
              <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                  <h4 class="modal-title">Detail Konsultasi</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- body modal -->
                <div class="modal-body">
                  <p><b>{{$d->namatopik}}</b></p>
                  <table class="table table-bordered table-hover">
                    <tr>
                     <th>Tanggal</th>
                     <td>{{$d->tanggalkonsultasi}}</td>
                    </tr>
                    <tr>
                     <th>Permasalahan</th>
                     <td>{{$d->permasalahan}}</td>
                    </tr>
                    <tr>
                     <th>Solusi:</th>
                     <td>{{$d->solusi}}</td>
                    </tr>
                    <tr>
                     <th>Konsultasi Berikutnya:</th>
                     <td>{{$d->konsultasiselanjutnya}}</td>
                    </tr>
                    <tr>
                    @if($d->konfirmasi == 0)
                      <th>Status Konfirmasi:</th>
                      <td>Belum Disetujui</td>
                    @else
                      <th>Status Konfirmasi:</th>
                      <td>Disetujui</td>
                    @endif
                    </tr>
                    <tr>
                     <th>Tahun akademik:</th>
                     <td>{{$d->semester}} {{$d->tahun}}</td>
                    </tr>
                    <tr>
                  </table>
                </div>
                <!-- footer modal -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        @endforeach


    </section>

@endsection
 
@push('scripts')
<script>
$(document).ready(function(){

 $('#keyword').keyup(function(){ 
        var query = $(this).val();

        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         var pencarian = document.getElementById("pencarian").value;
         $.ajax({
          url:"{{ route('masterkonsultasi.fetch') }}",
          method:"POST",
          data:{query:query,_token:_token, jenis:pencarian},
          success:function(data){
            $('#konsultasiList').fadeIn();  
              $('#konsultasiList').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#keyword').val($(this).text());  
        $('#konsultasiList').fadeOut();  
    });  

});
</script>
@endpush