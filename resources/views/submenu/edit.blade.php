@extends('layouts.back_layout')

@section('js')
    <!-- Include the CKEDITOR library -->
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <!-- Initialize Quill editor -->
    <script>
        $('#summary-ckeditor').ckeditor({
            filebrowserImageBrowseUrl: '/jangan-ke-sini?type=Images',
            filebrowserImageUploadUrl: '/jangan-ke-sini/upload?type=Images&_token=' + $("input[name=_token]").val(),
            filebrowserBrowseUrl: '/jangan-ke-sini?type=Files',
            filebrowserUploadUrl: '/jangan-ke-sini/upload?type=Files&_token=' + $("input[name=_token]").val()
        });
     </script>
@endsection

@section('title')
    Edit Sub Menu {{ $submenu->title }}
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
                            <a href="{{ route('submenus.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                          <form action="{{ route('submenus.update', ['id' => $submenu->id]) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="PUT" name="_method">
                            <div class="form-group">
                                <label for="name">Judul Sub Menu</label>
                                <input type="text" class="form-control" placeholder="Masukkan Judul Sub Menu" value="{{ $submenu->title }}" name="title" id="title" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Pilih Menu</label>
                                <select class="form-control" name="category" id="category" required>
                                    <option value="" disabled>Pilih Menu Dari Sub Menu</option>
                                    @foreach ($categories as $data)
                                    <option value="{{$data->id}}" {{$submenu->category_menu_id == $data->id ? 'selected' : ''}} >{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Create the editor container -->
                            <div class="form-group">
                                <label for="name">Isi Konten Sub Menu</label>
                                <textarea class="form-control" id="summary-ckeditor" name="content">{{ $submenu->content }}</textarea>
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