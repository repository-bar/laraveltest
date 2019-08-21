@extends('layouts.back_layout')

@section('title')
    Daftar Akun Admin
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
                          <form action="{{route('users.index')}}">
                            <div class="input-group mb-3">
                              <input value="{{Request::get('keyword')}}" name="keyword" class="form-control col-md-10" type="text" placeholder="Cari akun berdasarkan nama" />
                              <div class="input-group-append">
                                <input type="submit" value="Cari" class="btn btn-primary">
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('users.create')}}" class="btn btn-success float-right">Tambah Akun</a>            
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
                            <th scope="col"><b>Nama</b></th>
                            <th scope="col"><b>Email</b></th>
                            <th scope="col"><b>Avatar</b></th>
                            <th scope="col"><b>Aksi</b></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->name }}</th>
                                <td>{{ $user->email}}</td>
                                <td>
                                    @if($user->avatar)
                                    {{-- <img src="{{ asset('storage/'.$user->avatar) }}" width="70px" /> --}}
                                    <img src="{{ Storage::url($user->avatar) }}" width="70px"/>
                                    @else
                                        N/A
                                    @endif    
                                </td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="{{route('users.edit', ['id' => $user->id])}}">
                                      Edit
                                    </a>
                                    <form onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?')" class="d-inline" action="{{route('users.destroy', ['id' => $user->id])}}" method="POST">
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
                      {{$users->links()}}
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