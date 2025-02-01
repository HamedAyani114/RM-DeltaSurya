<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        resep_obat_{{ $prescriptions->medical_record[0]->patient->nama }}_{{ $prescriptions->medical_record[0]->patient->id_pasien }}
    </title>

    <link rel="shortcut icon" href="{{ env('APP_ICON') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        td {
            padding: .4rem;
        }
    </style>

</head>

<body>

    <div class="container">
        <section class="data">
            <h1 class="text-center my-4">Resep Obat</h1>

            <div class="info mb-4">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $prescriptions->medical_record[0]->patient->nama }}</td>
                    </tr>
                    <tr>
                        <td>No BPJS</td>
                        <td>:</td>
                        <td>{{ $prescriptions->medical_record[0]->patient->no_bpjs ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ ucwords($prescriptions->medical_record[0]->patient->jenis_kelamin) }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Periksa</td>
                        <td>:</td>
                        <td>{{ ucwords($prescriptions->medical_record[0]->created_at->format('m D Y')) }}</td>
                    </tr>
                </table>
            </div>

            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Aturan Pakai</th>
                </thead>
                <tbody>
                    @foreach ($prescriptions->medicine_recipe as $obat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->jumlah }}</td>
                            <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            <td> {{ $obat->aturan_pakai }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <div class="row justify-content-end mt-5">
            <div class="col-md-6">
                <div class="total float-right mr-5">
                    <strong>Total Harga</strong>
                    <p class="price">Rp
                        {{ number_format($prescriptions->medicine_recipe->sum('harga'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-end mt-5">
            <div class="col-4">
                <div class="role">
                    <p class="role">
                        {{ ucwords(auth()->user()->role) }}
                    </p>
                    <p class="name mt-5">
                        @if (auth()->user()->role === 'apoteker')
                            {{ ucwords(auth()->user()->pharmacist->nama) }}
                        @else
                            {{ ucwords(auth()->user()->username) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

    </div>


    <script>
        window.print()
    </script>
</body>

</html>
