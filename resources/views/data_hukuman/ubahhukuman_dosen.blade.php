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
            <h1>Ubah Data Hukuman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('dosen')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('dosen/data/hukuman')}}">Daftar Hukuman</a></li>
              <li class="breadcrumb-item active">Ubah Data Hukuman</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Input Data Hukuman</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('dosen/data/hukuman/detail/ubahproses')}}" role="form" method="post">
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
               @foreach($hukuman as $h)
                <div class="card-body">
                  <input type="hidden" name="mahasiswa" value="{{$h->nrpmahasiswa}}">
                  <input type="hidden" name="idhukuman" value="{{$h->idhukuman}}">

	            	  <div class="form-group">
	                	<label for="exampleInputMahasiswa">Mahasiswa</label>
	                	<p>{{$h->namamahasiswa}} - {{$h->nrpmahasiswa}} </p>
	              	</div>

                  <div class="form-group">
                    <label for="exampleInputKategori">Kategori Hukuman</label>
                    <br>
                    <select class="btn btn-primary dropdown-toggle" name="kategori" data-toggle="dropdown" id="kategori">
                      @if($h->kategori == 'ringan')
                      <option value="ringan" selected>Kategori Ringan</option>
                      <option value="sedang">Kategori Sedang</option>
                      <option value="berat">Kategori Berat</option>
                      @elseif($h->kategori == 'sedang')
                      <option value="sedang" selected>Kategori Sedang</option>
                      <option value="ringan">Kategori Ringan</option>
                      <option value="berat">Kategori Berat</option>
                      @else
                      <option value="berat" selected>Kategori Berat</option>
                      <option value="ringan">Kategori Ringan</option>
                      <option value="sedang">Kategori Sedang</option>
                      @endif
                    </select>
                  </div>
                 
                  <div class="form-group">
                    <label for="exampleInputHukuman">Hukuman</label>
                    <input type="text" name="hukuman" class="form-control" id="hukuman" placeholder="Enter Hukuman" value="{{$h->namahukuman}}" >

                    <div id="hukumanList" class="float-md-right" ></div>
                  </div>
                 
                	<div class="form-group">
                    	<label for="exampleInputKeterangan">Keterangan</label>
                     	<textarea class="form-control" name="keterangan" id="exampleInputKeterangan" rows="3" placeholder="Enter Keterangan">{{$h->keterangan}}</textarea>
                	</div>
                  
	              	<!-- /.card-body -->
	              	<div class="card-footer">
	                	<button type="submit" class="btn btn-primary">Submit</button>
	              	</div>
                </div>
                @endforeach
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

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

<script>
  $(document).ready(function(){

  $('#hukuman').keyup(function(){ 
    var query = $(this).val();

    if(query != '')
    {
      var _token = $('input[name="_token"]').val();
      var kategori = document.getElementById("kategori").value;

      $.ajax({
        url:"{{ route('datahukuman.fetch') }}",
        method:"POST",
        data:{query:query,_token:_token, jenis:kategori},
        success:function(data){
          $('#hukumanList').fadeIn();  
          $('#hukumanList').html(data);
        }
      });
    }
  });
  
  $(document).on('click', 'li', function(){  
    $('#hukuman').val($(this).text());  
    $('#hukumanList').fadeOut();
  }); 

});
</script>
@endpush
