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
                <h4 class="mb-3 mb-md-0"> Data User</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">

                <br>
                <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                            data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date"
                        data-input>
                </div>
                <a href="/tambahuser">
                    <button type="submit" class="btn btn-success">
                        {{ __('Tambah User') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12 grid-margin stretch-card">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0"> Data User</h6>
                            <div class="dropdown mb-2">
                                <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">NIP</th>
                                        <th class="pt-0">Nama</th>
                                        <th class="pt-0">Jabatan</th>
                                        <th class="pt-0">Prodi</th>
                                        <th class="pt-0">email</th>
                                        <th class="pt-0">role</th>
                                        <th class="pt-0">action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Users as $userData)
                                        <tr>
                                            <td>{{ $userData->data()['NIP'] }}</td>
                                            <td>{{ $userData->data()['Name'] }}</td>
                                            <td> @if (isset($userData->data()['jabatan']))
                                                {{$userData->data()['jabatan']}}
                                            @endif</td>
                                            <td> @if (isset($userData->data()['prodi']))
                                                {{$userData->data()['prodi']}}
                                            @endif</td>
                                            <td>{{ $userData->data()['email'] }}</td>
                                            <td>{{ $userData->data()['role'] }}</td>
                                            <td> <a href="/delete-employee/{{$userData->data()['Uid']}}">
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('delete') }}
                                                </button>
                                            </a></td>
                                            <td> <a href="/edit-user/{{$userData->data()['Uid']}}">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Update') }}
                                                </button>
                                            </a></td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
