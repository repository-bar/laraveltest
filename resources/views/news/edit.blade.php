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
    Sunting Berita : {{ $news->title }}
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
                            <a href="{{ route('news.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                          <form action="{{ route('news.update', ['id' => $news->id]) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="PUT" name="_method">
                            <div class="form-group">
                                <label for="name">Judul Berita</label>
                                <input type="text" class="form-control" placeholder="Masukkan Judul Berita" value="{{ $news->title }}" name="title" id="title" required>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Gambar Preview</label>
                                <br>
                                @if ($news->image)
                                    <img src="{{asset('storage/'.$news->image)}}" width="120px" class="mb-3" />
                                    <br>
                                @else
                                    Tidak ada gambar
                                @endif
                                <input type="file" class="form-control-file" id="image" name="image">
                                <br>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
                            </div>
                            <!-- Create the editor container -->
                            <div class="form-group">
                                <label for="name">Isi Konten Berita</label>
                                <textarea class="form-control" id="summary-ckeditor" name="content">{{ $news->content }}</textarea>
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