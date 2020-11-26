<!--Wajib untuk inisialisasi file views/layouts/appadmin-->
@extends('layouts.appdosen')

@push('styles')
  <!-- Untuk menambahkan style baru -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
@endpush

<!-- Isi dari yield -->
@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Dosen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('dosen/')}}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$mahasiswa}}</h3>

                <p>Total Mahasiswa Wali</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-people"></i>
              </div>
              <a href="{{url('dosen/data/mahasiswa')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$hukuman}}</h3>

                <p>Total Hukuman</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-cog"></i>
              </div>
              <a href="{{url('admin/master/mahasiswa')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$konsultasi}}</h3>

                <p>Total Konsultasi</p>
              </div>
              <div class="icon">
                <i class="ion ion-archive"></i>
              </div>
              <a href="{{url('admin/master/matakuliah')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$konsultasi_berikutnya}}</h3>

                <p>Konsultasi Berikutnya </p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-alarm"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Grafik Indeks Prestasi Mahasiswa</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>

          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Total Konsultasi Mahasiswa</h3>
              </div>
              <div class="card-body">
                
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  <br>
                  <p style="font-size: 11px;">
                    Keterangan:
                    <br>
                    <a href="#" class="btn btn-primary btn-sm"></a> 
                    Total seluruh layanan konsultasi dosen wali dalam setiap bulan.
                    <br>
                    <a href="#" class="btn btn-secondary btn-sm"></a> 
                    Total layanan konsultasi dosen wali saat ini (3 bulan).
                  </p>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
         
          <!-- right col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
         <!-- ISI HALAMAN -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


@push('scripts')
<!-- Untuk Menambahkan script baru -->
<script>
  $(function () {
    //Total seluruh konsultasi per bulan
    var nama_bulan= new Array();
    var total= new Array();

    @foreach($total_konsultasi as $t)
      nama_bulan.push('{{$t->bulan}}');
      total.push({{$t->total}});
    @endforeach

    //Total seluruh konsultasi bulan ini
    var nama_bulan_sekarang = new Array();
    var total_sekarang = new Array();

    @foreach($total_konsultasi_sekarang as $ts)
      nama_bulan_sekarang.push('{{$ts->bulan}}');
      total_sekarang.push({{$ts->total}});
    @endforeach
    
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    var areaChartData = {
      labels  : nama_bulan,
      datasets: [
        {
          label               : 'Konsultasi Per Bulan',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : true,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : total
        },
        {
          label               : 'Konsultasi Saat Ini',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : true,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : total_sekarang
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart  = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })
  })


  

   $(function () {
    
    var totalmahasiswa_ips = new Array();
    @foreach($results_ips as $ips)
      totalmahasiswa_ips.push({{$ips->total}});    
    @endforeach

    var totalmahasiswa_ipk = new Array();
    @foreach($results_ipk as $ipk)
      totalmahasiswa_ipk.push({{$ipk->total}});    
    @endforeach

    var totalmahasiswa_ipkm = new Array();
    @foreach($results_ipkm as $ipkm)
      totalmahasiswa_ipkm.push({{$ipkm->total}});    
    @endforeach


    var barChartCanvas = $('#barChart1').get(0).getContext('2d')
    var barChartData = {
      labels  : ["0 - 2","3 - 4"],
      datasets: [
        {
          label               : 'Total Mahasiswa (IPS) ',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : true,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : totalmahasiswa_ips
        },
        {
          label               : 'Total Mahasiswa (IPK) ',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : totalmahasiswa_ipk
        },
        {
          label               : 'Total Mahasiswa (IPKm) ',
          backgroundColor     : 'rgb(64, 224, 208)',
          borderColor         : 'rgb(64, 224, 208)',
          pointRadius         : false,
          pointColor          : 'rgb(64, 224, 208)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgb(220,220,220)',
          data                : totalmahasiswa_ipkm
        },
      
      
       
      ],
    }

    var barChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var barChart       = new Chart(barChartCanvas, { 
      type: 'bar',
      data: barChartData, 
      options: barChartOptions
    })
  })

   
</script>
@endpush