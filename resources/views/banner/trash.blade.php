@extends('layouts.back_layout')

@section('title')
    Daftar Trash Foto Banner
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
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <form action="{{route('banners.index')}}">
                            <div class="input-group mb-3">
                              <input value="{{Request::get('keyword')}}" name="keyword" class="form-control col-md-10" type="text" placeholder="Cari banner berdasarkan nama" />
                              <div class="input-group-append">
                                <input type="submit" value="Cari" class="btn btn-primary">
                              </div>
                              <a href="{{route('banners.index')}}" class="btn btn-primary ml-3">List Foto Banner</a>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('banners.create')}}" class="btn btn-success float-right">Tambah Foto Banner</a>            
                        </div>
                      </div>
                        @if (session('status'))
                            <div class="alert alert-success">
                              {{session('status')}}
                            </div>
                        @endif
                      <div class="table-responsive mt-4"> 
                      <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><b>Judul Banner</b></th>
                                <th scope="col"><b>Foto</b></th>
                                <th scope="col"><b>Aksi</b></th>
                              </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $data)
                            <tr>
                                <th scope="row">{{ $data->title }}</th>
                                <td>
                                    @if($data->image)
                                    <img src="{{ Storage::url($data->image) }}" width="70px"/>
                                    @else
                                        N/A
                                    @endif    
                                </td>
                                <td>
                                  <form method="POST" action="{{route('banners.restore', ['id' => $data->id])}}" class="d-inline">
                                    @csrf 
                                    <input type="submit" value="Restore" class="btn btn-success btn-sm"/>
                                  </form>
                                  <form method="POST" action="{{route('banners.delete-permanent', ['id' => $data->id])}}" class="d-inline" onsubmit="return confirm('Hapus foto banner secara permanen?')">
                                    @csrf 
                                    <input type="hidden" name="_method" value="DELETE">
                                  <input type="submit" value="Hapus" class="btn btn-danger btn-sm">
                                </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      </div>
                      {{$banners->links()}}
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