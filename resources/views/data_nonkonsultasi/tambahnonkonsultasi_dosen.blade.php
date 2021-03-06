<!--Wajib untuk inisialisasi file views/layouts/appadmin-->
@extends('layouts.appdosen')

@push('styles')
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('../../asset/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('../../asset/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endpush

<!-- Isi dari yield -->
@section('content')
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Tambah Data Konsultasi Tidak Terjadwal</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('dosen')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('dosen/data/nonkonsultasi')}}">Daftar Tidak Terjadwal</a></li>
              <li class="breadcrumb-item active">Tambah Data Tidak Terjadwal</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Input Data Konsultasi Tidak Terjadwal</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">

                <form method="GET" name="formfilter" action="{{url('dosen/data/nonkonsultasi/tampilkanfilter')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="form-group float-sm-right">
                    <i class="fas fa-filter fa-xs"> Filter Data Mahasiswa (Tahun angkatan) </i>

                    <select class="btn btn-primary btn-xs dropdown-toggle" name="filterAngkatan" data-toggle="dropdown" id="filterAngkatan" onchange="formfilter.submit();">
                      <option value="">-- Pilih Tahun Angkatan --</option>
                      @foreach($angkatan as $a)
                        <option value="{{$a->idtahunakademik}}">{{$a->tahun}}</option>
                      @endforeach
                    </select>
                    <p style="font-size: 13px; margin-top: 10px;font-weight: bold;color: red; ">
                    @if(!empty($info))
                      @foreach($info as $i)
                       Menampilkan Data Mahasiswa Angkatan {{$i->tahun}}
                      @endforeach
                    @else
                      Tidak ada filter data
                    @endif
                    </p>
                  </div>
                </form>
                <br><br>

                <form action="{{url('dosen/data/nonkonsultasi/prosestambah')}}" role="form" method="post">
                  {{ csrf_field() }}

                  @if (count($errors) > 0)
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  @if (\Session::has('Error'))
                    <div class="alert alert-danger alert-block">
                      <ul>
                          <li>{!! \Session::get('Error') !!}</li>
                      </ul>
                    </div>
                  @endif

                  <div class="form-group">
                    <label for="exampleInputMahasiswa">Mahasiswa</label>
                    <br>
                    <select class="btn btn-primary dropdown-toggle" name="mahasiswa" data-toggle="dropdown" id="exampleInputMahasiswa">        
                      <option value="">Pilih Mahasiswa</option>
                      @foreach($mahasiswa as $m)
                        <option value="{{$m->nrpmahasiswa}}">{{$m->nrpmahasiswa}} - {{$m->namamahasiswa}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputTanggalPertemuan">Tanggal Pertemuan</label>
                    <input type="date" name="tanggal_pertemuan" class="form-control" id="exampleInputTanggalPertemuan" >
                  </div>
                 
                  <div class="form-group">
                    <label for="exampleInputPesan">Pesan</label>
                     <textarea class="form-control" name="pesan" id="exampleInputPesan" rows="3" placeholder="Enter Pesan"></textarea>
                  </div>

                  <p style="font-family: times-new-roman; font-size: 13px; font-weight: bold;color: red;">
                    *Keterangan: <br>
                    Untuk pesan private yang diinputkan dalam menu "Konsultasi tidak terjadwal" akan dikirim <br> melalui aplikasi whatsApp. 
                  </p>
                  
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary" >Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@push('scripts')
<script src="{{url('../../asset/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('../../asset/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- jquery-validation -->
<script src="{{url('../../asset/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{url('../../asset/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('../../asset/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('../../asset/dist/js/demo.js')}}"></script>

@endpush
