@extends('layouts.back_layout')

@section('js')
    {{-- Nothing --}}
@endsection

@section('title')
    Tambah Foto Banner
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
            <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>

            <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                      <div class="card">
                        <div class="card-header">
                            <a href="{{ route('banners.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
                        </div>
                        <div class="card-body">
                        @if(session('status'))
                          <div class="alert alert-success">
                                {{ session('status') }}
                          </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                          <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Judul Banner</label>
                                <input type="text" class="form-control" placeholder="Masukkan Judul Banner" value="{{ old('title') }}" name="title" id="title" required>
                            </div>
                            <!-- Create the editor container -->
                            <div class="form-group">
                                <label for="name">Deskripsi Singkat</label>
                                <input type="text" class="form-control" placeholder="Masukkan Deskripsi Singkat" value="{{ old('desc') }}" name="desc" id="desc" maxlength="200" required>
                                <small class="text-muted">Maksimal 200 Karakter</small>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Gambar Banner</label>
                                <input type="file" class="form-control-file" id="image" name="image" required>
                                <small class="text-muted">Ukuran Maksimal 2MB. Dimensi gambar yang proporsional sebaiknya berukuran 1350px * 512px</small>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" name="save_action" value="PUBLISH">Publikasi</button>
                            <button class="btn btn-secondary" name="save_action" value="DRAFT">Simpan Draft</button>
                        </form>
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