@extends('Dashboard.home')

@section('DataPresensi')
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
                <h4 class="mb-3 mb-md-10"></h4>
            </div>

            <div class="d-flex align-items-center flex-wrap text-nowrap mb-2">
                <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                            data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date"
                        data-input>

                </div>
            </div>

            </div>
            <div class="row">
                <div class="col-1 col-xl-12 grid-margin stretch-card">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                                <h6 class="card-title mb-0"> Data Presensi</h6>
                                <div class="row mb-3">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <button type="submit" class="btn btn-info " id="showDialogBtn" data-toggle="modal" data-target="#myModal">Filter</button>
                                        <button onclick="window.location='{{ route('presensiExcel') }}'" class="btn btn-success">Excel</button>
                                        <button onclick="window.location='{{ route('presensiPdf') }}'" class="btn btn-danger">PDF</button>
                                      </div>
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
                                            <th class="pt-0">Check in</th>
                                            <th class="pt-0">Status</th>
                                            <th class="pt-0">Check out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $document)
                                            @foreach ($document['presensi'] as $presensi)
                                                <tr>
                                                    <td>{{ $document['NIP'] }}</td>
                                                    <td>{{ $document['Name'] }}</td>
                                                    <td>
                                                        @if (isset($document['jabatan']))
                                                            {{ $document['jabatan'] }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($document['prodi']))
                                                            {{ $document['prodi'] }}
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($presensi['tanggal'])->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        @if (isset($presensi['check in']['tanggal']))
                                                            {{ \Carbon\Carbon::parse($presensi['check in']['tanggal'])->format('H:i:s') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($presensi['check in']['status']))
                                                            {{ $presensi['check in']['status'] }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($presensi['check out']['tanggal']))
                                                            {{ \Carbon\Carbon::parse($presensi['check out']['tanggal'])->format('H:i:s') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Filter data</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="forms-sample" method="GET" action="/filterpresensi">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">tanggal awal</label>
                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="nip" placeholder="tanggal awal"
                                                value="{{ old('tanggal') }}" name="sdate">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">tanggal akhir</label>
                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="name" autocomplete="off"
                                                placeholder="tanggal akhir" value="{{ old('tanggal') }}" name="edate">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-9 offset-sm-7">
                                            <button type="submit" class="btn btn-primary" id="showDialogBtn">Filter</button>
                                        </div>
                                    </div>
                                </form>
                                <form class="forms-sample" method="GET" action="/prodifilter">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Prodi</label>
                                        <div class="col-sm-5">
                                            <select class="form-select" name="prodi" id="prodi">
                                                @foreach ($prodi as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-9 offset-sm-7">
                                            <button type="submit" class="btn btn-primary" id="showDialogBtn">Filter</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary">Simpan Perubahan</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
