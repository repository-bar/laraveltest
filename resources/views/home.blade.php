@extends('layouts.back_layout')

@section('title')
    Dashboard
@endsection

@section('content')
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('layouts.back_nav')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
    
            @include('layouts.back_topbar')

            <!-- Begin Page Content -->
            <div class="container-fluid">
    
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Selamat Datang di Panel Admin</h1>
            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Admin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$user}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Berita</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$news}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

            </div> 
            
            <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Peta Pengunjung</div>
                            <a href="https://info.flagcounter.com/aymC"><img src="https://s11.flagcounter.com/map/aymC/size_s/txt_000000/border_CCCCCC/pageviews_1/viewers_Pengunjung/flags_0/" alt="Flag Counter" border="0" class="img-fluid" style="width:100%"></a>
                        </div>
                        </div>
                    </div>
                    </div>
                    </div>
    
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-md-4 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Flag Counter</div>
                                <a href="http://s01.flagcounter.com/more/ULE"><img src="https://s01.flagcounter.com/countxl/ULE/bg_FFFFFF/txt_000000/border_CCCCCC/columns_3/maxflags_12/viewers_Pengunjung/labels_1/pageviews_1/flags_0/percent_0/" alt="Flag Counter" class="img-fluid" style="width:100%" border="0"></a>
                        </div>
                        </div>
                    </div>
                    </div>
                    </div>
    
                </div> 

            </div>
            <!-- /.container-fluid -->
    
        </div>
        <!-- End of Main Content -->
    
        <!-- Footer -->
        @include('layouts.back_footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
    
</div>
<!-- End of Page Wrapper -->
@endsection
