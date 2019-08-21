@extends('layouts.back_layout')

@section('title')
    Ubah Akun Admin
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
                    <div class="col-12 col-md-8 col-lg-8">
                      <div class="card">
                        <div class="card-header">
                            <a href="{{ route('users.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                          <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="PUT" name="_method">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" value="{{$user->name}}" placeholder="Nama Lengkap" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Gambar Profil</label>
                                <br>
                                @if ($user->avatar)
                                    <img src="{{asset('storage/'.$user->avatar)}}" width="120px" class="mb-3" />
                                    <br>
                                @else
                                    Tidak ada gambar
                                @endif
                                <input type="file" class="form-control-file" id="avatar" name="avatar">
                                <br>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
                            </div>
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control" disabled value="{{$user->email}}" placeholder="user@mail.com" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Kata Sandi</label>
                                <input type="password" class="form-control" placeholder="Kosongkan Jika Tidak Dirubah" name="password" id="password">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                          <button class="btn btn-primary mr-1" type="submit">Submit</button>
                          <button class="btn btn-secondary" type="reset">Reset</button>
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