<!DOCTYPE html>
<html>

<head>
    <style>
        #customers {
            color: #000;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            line-height: normal;
            font-weight: 300;
            border-collapse: collapse;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 4px;
            font-weight: 400;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            background-color: #17a2b8;
            color: white;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
    </style>
</head>

<body>

    <table id="customers">
        <table>
            </head>

            <body>
                <center>
                    <div style="width: 700px;">
                        <img mg style="position: absolute; margin-left: 5px; width: 65px; margin-top: 3px; "
                            class="img-responsive img" src="" alt="">
                        <h1 style="font-size: 19px;">Data GetPass staff dan Dosen Politeknik Enjinering Indorama</h1>
                        <center>
                            <br>
                            <br>
                            <table id="customers">
                                </br>
                                <tr>
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
                                </tr>
                                @foreach ($data as $document)
                                        @foreach ($document['GetPass'] as $getpass)
                                            <tr>
                                                <td>{{ $document['NIP'] }}</td>
                                                <td>{{ $document['Name'] }}</td>
                                                <td>
                                                    @if (isset($document['jabatan']))
                                                        {{ $document['jabatan'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($documnet['prodi']))
                                                        {{ $document['prodi'] }}
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($getpass['Tanggal'])->format('d M Y') }}</td>
                                                <td>
                                                    @if (isset($getpass['GetPass']['Alasan']))
                                                        {{ $getpass['GetPass']['Alasan'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($getpass['GetPass']['Tanggal']))
                                                        {{ \Carbon\Carbon::parse($getpass['GetPass']['Tanggal'])->format('H:i::s') }}
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

                            </table>

            </body>

</html>
