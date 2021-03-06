<!--Wajib untuk inisialisasi file views/layouts/appadmin-->
@extends('layouts.appadmin')

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
            <h1>Tambah Data Matakuliah</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('admin/master/matakuliah')}}">Daftar Matakuliah</a></li>
              <li class="breadcrumb-item active">Tambah Data Matakuliah</li>
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
                <h3 class="card-title">Form Input Data Matakuliah</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('admin/master/matakuliah/prosestambah')}}" role="form" method="post">
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
               
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputKodeMatakuliah">Kode Matakuliah</label>
                    <input type="text" name="kodematakuliah" class="form-control" id="exampleInputKodeMatakuliah" placeholder="Enter Kode Matakuliah">
                  </div>
                
                  <div class="form-group">
                    <label for="exampleInputNamaMatakuliah">Nama Matakuliah</label>
                    <input type="text" name="namamatakuliah" class="form-control" id="exampleInputNamaMatakuliah" placeholder="Enter Nama Matakuliah">
                  </div>
                 
                  <div class="form-group">
                    <label for="exampleInputTotalSKS">Total SKS</label>
                    <input type="number" name="totalsks" class="form-control" id="exampleInputTotalSKS" value="1" min="1" max="10">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputTotalPertemuan">Total Pertemuan</label>
                    <input type="number" name="totalpertemuan" class="form-control" id="exampleInputTotalPertemuan" value="1" min="1" max="5">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputNisbi">Nisbi Minimal</label>
                    <br>
                    <select class="btn btn-primary dropdown-toggle" name="nisbi" data-toggle="dropdown" id="exampleInputNisbi">
                      <option value="">-- Pilih Nisbi --</option>
                      <option value="A">A</option>
                      <option value="AB">AB</option>
                      <option value="B">B</option>
                      <option value="BC">BC</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputSemester">Semester</label>
                    <br>
                    <select class="btn btn-primary dropdown-toggle" name="semester" data-toggle="dropdown" id="exampleInputSemester">
                      <option value="">-- Pilih Semester --</option>
                       @foreach($semester as $s)
                        <option value="{{$s->idsemester}}">{{$s->semester}}</option>
                       @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputTahunAkademik">Tahun Akademik</label>
                    <br>
                    <select class="btn btn-primary dropdown-toggle" name="tahunakademik" data-toggle="dropdown" id="exampleInputTahunAkademik">
                      <option value="">-- Pilih Tahun Akademik --</option>
                       @foreach($tahun_akademik as $t)
                        <option value="{{$t->idtahunakademik}}">{{$t->tahun}}</option>
                       @endforeach
                    </select>
                  </div>


                </div>
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
