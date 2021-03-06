<!--Wajib untuk inisialisasi file views/layouts/appadmin-->
@extends('layouts.appdosen')

@push('styles')
  <!-- Untuk menambahkan style baru -->
  <style type="text/css">
  body{
    margin:0;
    padding: 0;
    background:#262626;
  }
  .rating{
    position: absolute;
    margin-left: 70px;
    margin-top: 5px;
    transform: translate(-50%, -50%) rotateY(180deg);
    display: flex;

  }
  .rating input{
    display: none;
  }
  .rating label{
    display: block;
    cursor: pointer;
    width: 30px;
    /*background: #ccc;*/
  }
  .rating label:before{
    content:'\f005';
    font-family: fontAwesome;
    position: relative;
    display: block;
    font-size: 25px;
    color: #101010;
  }
  .rating label:after{
    content:'\f005';
    font-family: fontAwesome;
    position: absolute;
    display: block;
    font-size: 25px;
    color: #fffa00;
    top:0;
    opacity: 0;
    transition: .5s;
    text-shadow: 0 2px 5px rgba(0,0,0,.5);
  }
  .rating label:hover:after,
  .rating label:hover ~ label:after,
  .rating input:checked ~ label:after
  {
    opacity: 1;
  }
  </style>

  <!-- SweetAlert2 -->
<link rel="stylesheet" href="{{url('asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<!-- Toastr -->
<link rel="stylesheet" href="{{url('asset/plugins/toastr/toastr.min.css')}}">
@endpush

<!-- Isi dari yield -->
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Rangkuman Kondisi Mahasiswa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('dosen')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('dosen/data/konsultasi/tambah ')}}">Tambah Data Terjadwal</a></li>
              <li class="breadcrumb-item active">Rangkuman Kondisi Mahasiswa</li>
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{$konsultasi_mhs[0]->namamahasiswa}} ({{$konsultasi_mhs[0]->nrpmahasiswa}})</h3>
          </div>  
          <div class="card-body">

            <table class="table table-bordered table-striped">
              <thead>
                <tr> 
                  <th width="1%">No.</th>
                  <th width="1%">Tanggal Konsultasi</th>
                  <th width="1%">Tahun Akademik</th>
                  <th width="1%">Topik</th>
                  <th width="1%">Materi Konsultasi</th>
                  <th width="1%">Permasalahan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($konsultasi_mhs as $no => $k)
                <tr>
                  <td>{{$no+1}}</td>
                  <td>{{$k->tanggalkonsultasi}}</td>
                  <td>{{$k->semester}} {{$k->tahun}}</td>
                  <td>{{$k->namatopik}}</td>
                  <td>{{$k->permasalahan}}</td>
                  <td>{{$k->solusi}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <br>
            <p style="font-size: 12px">
              Keterangan: <br>
              Data konsutasi diambil dari 5 (lima) data konsultasi dosen wali terakhir
            </p>
            <br>

            <div class="float-sm-right">
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#rating_{{$konsultasi_mhs[0]->nrpmahasiswa}}">
              Berikutnya</a>
            </div>  
          </div>
        </div>

        @foreach($konsultasi_mhs as $d)
        <div id="rating_{{$d->nrpmahasiswa}}" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                <h4 class="modal-title">Rating Mahasiswa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- body modal -->
              <form action="{{url('dosen/data/rating/prosestambah/'.$d->nrpmahasiswa)}}" role="form" method="post">
                {{ csrf_field() }}

                <div class="modal-body">
                  <p style="text-align: center;text-transform: uppercase;"><b>{{$d->namamahasiswa}} - {{$d->nrpmahasiswa}}</b></p>

                  <div class="alert alert-danger alert-block">
                    <label style="font-weight: bold;font-family: times-new-roman">Informasi Durasi Konsultasi</label>
                    <br>
                    <p style="font-family: times-new-roman; font-size: 16px;">{{$durasi}}</p>
                  </div>
                 

                  <!--UNTUK RATING -->
                  <p>
                    1. Manfaat dari hasil konsultasi dosen wali: 
                    <a href="#" class="fas fa-info-circle float-right toastrDefaultInfo_manfaat"></a>
                  </p>
                  <div class="rating">
                    <input type="radio" name="star_manfaatkonsultasi" id="star5_manfaatkonsultasi" value="5"><label for="star5_manfaatkonsultasi"></label>
                    <input type="radio" name="star_manfaatkonsultasi" id="star4_manfaatkonsultasi" value="4"><label for="star4_manfaatkonsultasi"></label>
                    <input type="radio" name="star_manfaatkonsultasi" id="star3_manfaatkonsultasi" value="3"><label for="star3_manfaatkonsultasi"></label>
                    <input type="radio" name="star_manfaatkonsultasi" id="star2_manfaatkonsultasi" value="2"><label for="star2_manfaatkonsultasi"></label>
                    <input type="radio" name="star_manfaatkonsultasi" id="star1_manfaatkonsultasi" value="1"><label for="star1_manfaatkonsultasi"></label>
                  </div>
                  <br>
                  <p>
                    2. Sifat mahasiswa selama melakukan konsultasi dosen wali: 
                    <a href="#" class="fas fa-info-circle float-right toastrDefaultInfo_sifat"></a>
                  </p>
                  <div class="rating">
                    <input type="radio" name="star_sifatkonsultasi" id="star5_sifatkonsultasi" value="5"><label for="star5_sifatkonsultasi"></label>
                    <input type="radio" name="star_sifatkonsultasi" id="star4_sifatkonsultasi" value="4"><label for="star4_sifatkonsultasi"></label>
                    <input type="radio" name="star_sifatkonsultasi" id="star3_sifatkonsultasi" value="3"><label for="star3_sifatkonsultasi"></label>
                    <input type="radio" name="star_sifatkonsultasi" id="star2_sifatkonsultasi" value="2"><label for="star2_sifatkonsultasi"></label>
                    <input type="radio" name="star_sifatkonsultasi" id="star1_sifatkonsultasi" value="1"><label for="star1_sifatkonsultasi"></label>
                  </div>
                  <br>
                  <p>
                    3. Interaksi/keaktifan mahasiswa selama konsultasi dosen wali: 
                    <a href="#" class="fas fa-info-circle float-right toastrDefaultInfo_interaksi"></a>
                  </p>
                  <div class="rating">
                    <input type="radio" name="star_interaksi" id="star5_interaksi" value="5"><label for="star5_interaksi"></label>
                    <input type="radio" name="star_interaksi" id="star4_interaksi" value="4"><label for="star4_interaksi"></label>
                    <input type="radio" name="star_interaksi" id="star3_interaksi" value="3"><label for="star3_interaksi"></label>
                    <input type="radio" name="star_interaksi" id="star2_interaksi" value="2"><label for="star2_interaksi"></label>
                    <input type="radio" name="star_interaksi" id="star1_interaksi" value="1"><label for="star1_interaksi"></label>
                  </div>
                  <br>
                  <p>
                    4. Pencapaian yang berhasil dicapai oleh mahasiswa: 
                    <a href="#" class="fas fa-info-circle float-right toastrDefaultInfo_pencapaian"></a>
                  </p>
                  <div class="rating">
                    <input type="radio" name="star_pencapaian" id="star5_pencapaian" value="5"><label for="star5_pencapaian"></label>
                    <input type="radio" name="star_pencapaian" id="star4_pencapaian" value="4"><label for="star4_pencapaian"></label>
                    <input type="radio" name="star_pencapaian" id="star3_pencapaian" value="3"><label for="star3_pencapaian"></label>
                    <input type="radio" name="star_pencapaian" id="star2_pencapaian" value="2"><label for="star2_pencapaian"></label>
                    <input type="radio" name="star_pencapaian" id="star1_pencapaian" value="1"><label for="star1_pencapaian"></label>
                  </div>

                  <br><br>
                  <p style="text-align: center;">Terima kasih, <br> atas penilaian yang diberikan :)</p>
                </div>

                
                <!-- footer modal -->
                <div class="modal-footer">
                  <a href="{{url('dosen/data/konsultasi')}}" class="btn btn-default">Skip</a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endforeach

      </div>
    </section>
@endsection
 
@push('scripts')
<!-- <script type="text/javascript">
  $('input[type=radio]').on('change', function() {
    $(this).closest("form").submit();
});
</script> -->

<!-- SweetAlert2 -->
<script src="{{url('asset/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{url('asset/plugins/toastr/toastr.min.js')}}"></script>
<script>
  $(function () {
    $('.toastrDefaultInfo_manfaat').click(function() {
      toastr.info('Keterangan: <br>'+ 
                  '- Bintang 1: Konsultasi yang <b>sangat tidak bermanfaat</b>. <br>'+
                  '- Bintang 2: Konsultasi yang <b>tidak bermanfaat</b>. <br>'+
                  '- Bintang 3: Konsultasi yang <b>cukup bermanfaat</b>. <br>'+
                  '- Bintang 4: Konsultasi yang <b>bermanfaat</b>. <br>'+
                  '- Bintang 5: Konsultasi yang <b>sangat bermanfaat</b>. <br>') 
    });

    $('.toastrDefaultInfo_sifat').click(function() {
      toastr.info('Keterangan: <br>'+
                  '- Bintang 1: Mahasiswa dalam konsultasi <b>sangat tidak sopan</b>. <br>'+
                  '- Bintang 2: Mahasiswa dalam konsultasi <b>tidak sopan</b>. <br>'+
                  '- Bintang 3: Mahasiswa dalam konsultasi <b>cukup sopan</b>. <br>'+
                  '- Bintang 4: Mahasiswa dalam konsultasi <b>sopan</b>. <br>'+
                  '- Bintang 5: Mahasiswa dalam konsultasi <b>sangat sopan</b>. <br>') 
    });

    $('.toastrDefaultInfo_interaksi').click(function() {
      toastr.info('Keterangan: <br>'+
                  '- Bintang 1: Mahasiswa <b>sangat kurang berinteraksi</b> saat konsultasi. <br>'+
                  '- Bintang 2: Mahasiswa <b>kurang berinteraksi</b> saat konsultasi. <br>'+
                  '- Bintang 3: Mahasiswa <b>cukup berinteraksi</b> saat konsultasi. <br>'+
                  '- Bintang 4: Mahasiswa <b>berinteraksi</b> saat konsultasi. <br>'+
                  '- Bintang 5: Mahasiswa <b>sangat berinteraksi</b> saat konsultasi. <br>') 
    });

    $('.toastrDefaultInfo_pencapaian').click(function() {
      toastr.info('Keterangan: <br>'+
                  '- Bintang 1: Mahasiswa <b>sangat kurang mencapai</b> target yang ditentukan. <br>'+
                  '- Bintang 2: Mahasiswa <b>kurang mencapai</b> target yang ditentukan. <br>'+
                  '- Bintang 3: Mahasiswa <b>cukup mencapai</b> target yang ditentukan. <br>'+
                  '- Bintang 4: Mahasiswa <b>mencapai</b> target yang ditentukan. <br>'+
                  '- Bintang 5: Mahasiswa <b>sangat mencapai</b> target yang ditentukan. <br>') 
    });

  });
</script>
@endpush