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
            <h1>Ubah Data Konsultasi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('dosen')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('dosen/data/konsultasi')}}">Daftar Terjadwal</a></li>
              <li class="breadcrumb-item active">Ubah Data Terjadwal</li>
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
                <h3 class="card-title">Form Input Data Konsultasi</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start --> 
              <form action="{{url('dosen/data/konsultasi/ubahproses')}}" role="form" method="post">
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
                
                @foreach($datakonsultasi as $d)
                <div class="card-body">
                	<input type="hidden" name="idtopik" value="{{$d->idtopikkonsultasi}}">
                  	<input type="hidden" name="idkonsultasi" value="{{$d->idkonsultasi}}">
                  

              		<div class="form-group">
              			<label for="exampleInputMahasiswa">Identitas Mahasiswa</label>
              			<br>
                		{{$d->namamahasiswa}} ({{$d->nrpmahasiswa}})
              		</div>

              		<div class="form-group">
		                <label for="exampleInputTopik">Topik Konsultasi</label>
		                <input type="text" name="topik_konsultasi" class="form-control" id="exampleInputTopik" placeholder="Enter Topik" value="{{$d->namatopik}}">
             		</div>
                 
                  	<div class="form-group">
                    	<label for="exampleInputPermasalahan">Materi Konsultasi</label>
                      <input type="text" name="permasalahan" class="form-control" id="exampleInputPermasalahan" placeholder="Enter Materi Konsultasi" value="{{$d->permasalahan}}">
                  	</div>

                  	<div class="form-group">
                   		<label for="exampleInputSolusi">Keterangan</label>
                       <textarea class="form-control" name="solusi" id="exampleInputSolusi" rows="3" placeholder="Enter Keterangan">{{$d->solusi}}</textarea>
                  	</div>

                  	<div class="form-group">
                    	<label for="exampleInputKonsultasiSelanjutnya">Konsultasi Selanjutnya</label>
                    	<input type="date" name="konsultasi_selanjutnya" class="form-control" id="exampleInputKonsultasiSelanjutnya" value="{{$d->konsultasiselanjutnya}}" >
                  	</div>

                  	<div class="form-group">
                    	<label for="exampleInputSemester">Semester</label>
                      <p>{{$d->semester}}</p>
                  	</div>

                  	<div class="form-group">
                    	<label for="exampleInputTahunAkademik">Tahun Akademik</label>
                    	<p>{{$d->tahun}}</p>
                  	</div>
                </div>
                @endforeach
                
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
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
