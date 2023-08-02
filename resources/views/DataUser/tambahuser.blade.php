@extends('Dashboard.home')

@section('DataUser')
    <nav class="navbar">
        <a href="#" class="sidebar-toggler">
            <i data-feather="menu"></i>
        </a>
        <div class="navbar-content">
            <!--SS-->
            <ul class="navbar-nav">
                <!--as-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="profile">
                    </a>
                    <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                        <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                            <div class="mb-3">
                                <img class="wd-80 ht-80 rounded-circle" src="https://via.placeholder.com/80x80"
                                    alt="">
                            </div>
                            <div class="text-center">
                                <p class="tx-16 fw-bolder">Amiah Burton</p>
                                <p class="tx-12 text-muted">amiahburton@gmail.com</p>
                            </div>
                        </div>
                        <ul class="list-unstyled p-1">

                            <li class="dropdown-item py-2">
                                <a href="javascript:;" class="text-body ms-0">
                                    <i class="me-2 icon-md" data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0"> Tambah user</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">

                <br>
                <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                            data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date"
                        data-input>
                </div>
                <a href="/datauser">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Data User') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="main-wrapper">
            <div class="page-wrapper full-page">
                <div class="page-content d-flex align-items-center justify-content-center">

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <h6 class="card-title"></h6>

                                <form class="forms-sample", method="POST", action="{{route('adduser')}}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nip"
                                                placeholder="NIP" required = 'required' value="{{old('nip')}}" name="nip">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name"
                                                autocomplete="off" placeholder="Nama" required = 'required' value="{{old("name")}}" name="name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email"
                                                placeholder="E-mail" required = 'required' value="{{old("email")}}" name="email">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputPassword2"
                                            class="col-sm-3 col-form-label">Role</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="role"
                                                autocomplete="off" placeholder="Role" required = 'required' value="{{old("role")}}" name="role">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputPassword2"
                                            class="col-sm-3 col-form-label">jabatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="jabatan"
                                                autocomplete="off" placeholder="jabatan" required = 'required' value="{{old("jabatan")}}" name="jabatan">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputPassword2"
                                            class="col-sm-3 col-form-label">Prodi</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="prodi"
                                                autocomplete="off" placeholder="prodi" required = 'required' value="{{old("prodi")}}" name="prodi">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary me-2" value="submit">Submit</button>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
