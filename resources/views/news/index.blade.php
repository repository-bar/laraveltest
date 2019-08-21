@extends('layouts.back_layout')

@section('title')
    Daftar Konten Berita
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
                        <div class="col-md-7">
                          <form action="{{route('news.index')}}">
                            <div class="input-group mb-3">
                              <input value="{{Request::get('keyword')}}" name="keyword" class="form-control col-md-10" type="text" placeholder="Cari berita berdasarkan nama" />
                              <div class="input-group-append">
                                <input type="submit" value="Cari" class="btn btn-primary">
                              </div>
                              <a href="{{route('news.trash')}}" class="btn btn-danger ml-3">Lihat Tong Sampah</a>            
                            </div>
                          </form>
                        </div>
                        <div class="col-md-5">
                            <a href="{{route('news.create')}}" class="btn btn-success float-right">Tulis Berita</a>            
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
                            <th scope="col"><b>Judul Berita</b></th>
                            <th scope="col"><b>Slug</b></th>
                            <th scope="col"><b>Penulis</b></th>
                            <th scope="col"><b>Status</b></th>
                            <th scope="col"><b>Aksi</b></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $data)
                            <tr>
                                <th scope="row">{{ $data->title }}</th>
                                <td>{{ $data->slug}}</td>
                                <td>{{ $data->name}}</td>
                                <td><span class="badge badge-pill badge-primary">{{ $data->status }}</span></td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="{{route('news.edit', ['id' => $data->id])}}">
                                      Edit
                                    </a>
                                    <form onsubmit="return confirm('Yakin ingin menghapus berita ini?')" class="d-inline" action="{{route('news.destroy', ['id' => $data->id])}}" method="POST">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="_method" value="DELETE">
                                      <input type="submit" value="Hapus" class="btn btn-danger btn-sm">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      </div>
                      {{$news->links()}}
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