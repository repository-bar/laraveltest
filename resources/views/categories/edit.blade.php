@extends('layouts.back_layout')

@section('title')
    Edit Menu {{ $category->title }}
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
                            <a href="{{ route('categories.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                          <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="PUT" name="_method">
                            <div class="form-group">
                                <label for="name">Judul Menu</label>
                                <input type="text" class="form-control" placeholder="Masukkan Judul Menu" value="{{ $category->name }}" name="name" id="name" required>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit" name="submit" value="SIMPAN">Edit</button>
                            <button class="btn btn-secondary" name="reset" value="RESET" type="reset">Reset</button>
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