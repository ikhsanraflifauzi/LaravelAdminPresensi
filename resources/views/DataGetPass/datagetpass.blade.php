@extends('Dashboard.home')

@section('Datagetpass')
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
                <h4 class="mb-3 mb-md-0"> Data GetPass</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                            data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date"
                        data-input>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-xl-12 grid-margin stretch-card">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0"> Filter tanggal</h6>
                            <div class="dropdown mb-2">
                                <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </a>
                            </div>
                        </div>
                        <form class="forms-sample" method="GET" action="/filterGetPass">
                            @csrf
                            <div class="row mb-3">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">tanggal awal</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" id="nip" placeholder="tanggal awal" required="required" value="{{ old('Tanggal') }}" name="sdate">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">tanggal akhir</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" id="name" autocomplete="off" placeholder="tanggal akhir" required="required" value="{{ old('Tanggal') }}" name="edate">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-7">
                                    <button type="submit" class="btn btn-primary" id="showDialogBtn">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-12 grid-margin stretch-card">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0"> Data GetPass</h6>
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
                                        <th class="pt-0">Tanggal</th>
                                        <th class="pt-0">Perihal</th>
                                        <th class="pt-0">jam keluar</th>
                                        <th class="pt-0">Jam kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $document)
                                           @foreach ($document['GetPass'] as $getpass )
                                           <tr>
                                             <td>{{$document['NIP']}}</td>
                                             <td>{{$document['Name']}}</td>
                                             <td> @if (isset($document['jabatan']))
                                                {{$documnet['jabatan']}}
                                            @endif</td>
                                            <td> @if (isset($documnet['prodi']))
                                                {{$document['prodi']}}
                                            @endif</td>
                                             <td>{{ \Carbon\Carbon::parse($getpass['Tanggal'])->format('d M Y') }}</td>
                                             <td>
                                                 @if (isset($getpass['GetPass']['Alasan']))
                                                     {{$getpass['GetPass']['Alasan']}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if (isset($getpass['GetPass']['Tanggal']))
                                                     {{\Carbon\Carbon::parse($getpass['GetPass']['Tanggal'])->format('H:i::s')}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if (isset($getpass['GetBack']['Tanggal']))
                                                     {{ \Carbon\Carbon::parse($getpass['GetBack']['Tanggal'])->format('H:i:s') }}
                                                 @endif
                                             </td>
                                         </tr>

                                           @endforeach

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
