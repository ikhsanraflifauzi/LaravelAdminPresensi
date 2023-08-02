@extends('Dashboard.home')

@section('DataPresensi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-A4w5s/N0LtxrNClGYw4A0tETI2RNapiIx72Mr8j2z8WZO0kQVhq4Ld2J9U2bO6w7" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
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
                <h4 class="mb-3 mb-md-0"> Data Presensi</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                            data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date"
                        data-input>

            </div>
            <button type="button" class="btn btn-primary" id="showDialogBtn">Show Dialog</button>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12 grid-margin stretch-card">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0"> Data Presensi</h6>
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
                                        <th class="pt-0">Check in</th>
                                        <th class="pt-0">Status</th>
                                        <th class="pt-0">Check out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                       @foreach ($data as $document)
                                           @foreach ($document['presensi'] as $presensi )
                                           <tr>
                                             <td>{{$document['NIP']}}</td>
                                             <td>{{$document['Name']}}</td>
                                             <td> @if (isset($document['jabatan']))
                                                {{$document['jabatan']}}
                                            @endif</td>
                                            <td> @if (isset($document['prodi']))
                                                {{$document['prodi']}}
                                            @endif</td>
                                             <td>{{ \Carbon\Carbon::parse($presensi['tanggal'])->format('d M Y') }}</td>
                                             <td>
                                                 @if (isset($presensi['check in']['tanggal']))
                                                     {{ \Carbon\Carbon::parse($presensi['check in']['tanggal'])->format('H:i:s') }}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if (isset($presensi['check in']['status']))
                                                     {{$presensi['check in']['status']}}
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

                            <script>

                                document.addEventListener("DOMContentLoaded", function () {
                                    const datepickers = document.querySelectorAll(".datepicker");
                                    datepickers.forEach(function (datepicker) {
                                        new Datepicker(datepicker, {
                                            format: "yyyy-mm-dd",
                                            autoHide: true,
                                        });
                                    });
                                });
                            </script>
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-T5P0fjRb7qbp8FkW/52RA2t3UuKO0t3RJyj4N2XtlI6ZwoeaF1WZtf+qVuBDVXpH" crossorigin="anonymous"></script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
