<!--Wajib untuk inisialisasi file views/layouts/appadmin-->
@extends('layouts.appmahasiswa')

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
            <h1 class="m-0 text-dark">Daftar Data Konsultasi Tidak Terjadwal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('mahasiswa')}}">Home</a></li>
              <li class="breadcrumb-item active">Daftar Data Tidak Terjadwal</li>
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
         @if(!empty($non_konsultasi_berikutnya))
          <div class="alert alert-primary">
            <p style="font-weight: bold">Informasi Jadwal Konsultasi Tidak Terjadwal: </p>
            @foreach($non_konsultasi_berikutnya as $no => $n)
            ({{$no+1}}). Tanggal {{$n->tanggalpertemuan}}, anda harus menemui Bapak/Ibu {{$n->namadosen}} ({{$n->npkdosen}}).
            <br>
            @endforeach
          </div>
        @endif

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Konsultasi Tidak Terjadwal</h3>
          </div>  
          <div class="card-body">
            <table id="tabel_nonkonsultasi" class="table table-bordered table-striped">
              <thead>
                <tr> 
                  <th width="1%">No.</th>
                  <th width="1%">Tanggal Input</th>
                  <th width="1%">Tanggal Pertemuan</th>
                  <th width="1%">Status</th>
                  <th width="1%">Dosen</th>
                  <th width="1%">Isi Pesan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data_non_konsultasi as $no => $dn)
                <tr>
                  <td>{{$no+1}}</td>
                  <td>{{$dn->tanggalinput}}</td>
                  <td>{{$dn->tanggalpertemuan}}</td>
                  <td>
                    @if($dn->status == "0")
                    <i class="btn btn-danger btn-sm"> Dalam proses...</i>
                    @else
                    <i class="btn btn-success btn-sm"> Selesai</i>
                    @endif
                  </td>
                  <td>{{$dn->namadosen}} {{$dn->npkdosen}}</td>
                  <td>{{$dn->pesan}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>  
          </div>
        </div>


   
       
      </div>
    </section>
@endsection
 
@push('scripts')
<script>
  $(function () {
    $('#tabel_nonkonsultasi').DataTable({
      "dom": '<"pull-right"f><"pull-left"l>tip'
    });
  });
</script>
@endpush