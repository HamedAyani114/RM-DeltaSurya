@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="waiting-prescriptions-tab" data-toggle="pill"
                                href="#waiting-prescriptions" role="tab" aria-controls="waiting-prescriptions"
                                aria-selected="true">Menunggu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="done-prescriptions-tab" data-toggle="pill" href="#done-prescriptions"
                                role="tab" aria-controls="done-prescriptions" aria-selected="false">Selesai</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabContent">
                        {{-- waiting prescription --}}
                        <div class="tab-pane fade active show" id="waiting-prescriptions" role="tabpanel"
                            aria-labelledby="waiting-prescriptions-tab">
                            <div id="waiting_prescriptions_table_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <div class="row">
                                    <div class="col-sm-12">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-check mr-1"></i>
                                                {!! session('success') !!}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <table id="waiting_prescriptions_table"
                                            class="table table-bordered table-striped dataTable dtr-inline"
                                            aria-describedby="waiting_prescriptions_table_info">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Nama Pasien</th>
                                                    <th>Poli</th>
                                                    <th>Tanggal Diperiksa</th>
                                                    <th>Status</th>
                                                    <th style="width: 200px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (array_filter($prescriptions->toArray(), function ($waiting) {
                                                    // $collect = collect($waiting);
                                                    return $waiting['status'] === 'selesai' > 0;
                                                }))
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tidak ada resep menunggu
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($medRecords as $medRecord)
                                                        @if ($medRecord->prescription->status === 'menunggu')
                                                            <tr>
                                                                <td>{{ $loop->iteration }}.</td>
                                                                <td>{{ $medRecord->patient->nama }}</td>
                                                                <td>{{ $medRecord->poly->nama_poli }}</td>
                                                                <td>{{ $medRecord->created_at->format('d M Y') }}</td>
                                                                <td>
                                                                    <span class="badge bg-secondary">Menunggu</span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('print.prescriptions.show', $medRecord->prescription->id_resep) }}"
                                                                        class="btn btn-sm btn-info">
                                                                        <i class="fa-solid fa-print"></i>
                                                                        Siapkan Resep Obat
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- done prescription --}}
                        <div class="tab-pane fade active" id="done-prescriptions" role="tabpanel"
                            aria-labelledby="done-prescriptions-tab">
                            <div id="done_prescriptions_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-check mr-1"></i>
                                                {!! session('success') !!}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <table id="done_prescriptions_table"
                                            class="table table-bordered table-striped dataTable dtr-inline"
                                            aria-describedby="done_prescriptions_table_info">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Nama Pasien</th>
                                                    <th>Poli</th>
                                                    <th>Tanggal Diperiksa</th>
                                                    <th>Status</th>
                                                    <th style="width: 200px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($medRecords as $medRecord)
                                                    @if ($medRecord->prescription->status === 'selesai')
                                                        <tr>
                                                            <td>{{ $loop->iteration }}.</td>
                                                            <td>{{ $medRecord->patient->nama }}</td>
                                                            <td>{{ $medRecord->poly->nama_poli }}</td>
                                                            <td>{{ $medRecord->created_at->format('d M Y') }}</td>
                                                            <td>
                                                                <span class="badge bg-success">Selesai</span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('print.prescriptions.show', $medRecord->prescription->id_resep) }}"
                                                                    class="btn btn-sm btn-info">
                                                                    <i class="fa-solid fa-print"></i>
                                                                    Siapkan Resep Obat
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
