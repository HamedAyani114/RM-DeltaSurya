@extends('layouts.app')

@section('content')
    @can('onlyPharmacist')
        @if ($prescriptionCount > 0)
            <div class="alert alert-info">
                <i class="fa-solid fa-bell mr-1"></i>
                Anda memiliki {{ $prescriptionCount }} resep yang perlu disiapkan
            </div>
        @endif
    @endcan
    @can('onlyDoctor')
        @if ($queueCount > 0)
            <div class="alert alert-info">
                <i class="fa-solid fa-bell mr-1"></i>
                Anda memiliki {{ $queueCount }} pasien untuk diperiksa
            </div>
        @endif
    @endcan
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $patientCount }}</h3>

                    <p>Pasien Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <a href="{{ route('pasien.index') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        @can('Admin')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $doctorCount }}</h3>

                        <p>Dokter</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <a href="{{ route('dokter.index') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $nurseCount }}</h3>
                        <p>Perawat</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-nurse"></i>
                    </div>
                    <a href="{{ route('perawat.index') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pharmacistCount }}</h3>
                        <p>Apoteker</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-nurse"></i>
                    </div>
                    <a href="{{ route('apoteker.index') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-arrow-right"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Antrian</span>
                    <span class="info-box-number">{{ $queueCount }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-notes-medical"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Poli</span>
                    <span class="info-box-number">{{ $polyCount }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-pills"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Obat</span>
                    <span class="info-box-number">{{ $medicineCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Antrian Hari Ini</h3>
                </div>
                <div class="card-body p-0" style="display: block;">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pasien</th>
                                    <th>Poli Tujuan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Jam Masuk</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($queues->count() === 0)
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada antrian hari ini</td>
                                    </tr>
                                @endif
                                @foreach ($queues as $queue)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $queue->patient->nama }}</td>
                                        <td>{{ $queue->poly->nama_poli }}</td>
                                        <td>{{ $queue->created_at->format('d M Y') }}</td>
                                        <td>{{ $queue->created_at->format('H:i') }}</td>
                                        <td>{!! $queue->status
                                            ? '<span class="badge badge-success">Sudah Diperiksa</span>'
                                            : '<span class="badge badge-secondary">Belum Diperiksa</span>' !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @can('AdminDoctorNurse')
                    <div class="card-footer clearfix" style="display: block;">
                        <a href="{{ route('antrian.index') }}" class="btn btn-sm btn-primary">Lihat Semua
                            Antrian</a>
                    </div>
                @endcan
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Antrian Resep</h3>
                </div>
                <div class="card-body p-0" style="display: block;">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pasien</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($prescriptions->count() === 0)
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada antrian hari ini</td>
                                    </tr>
                                @endif
                                @foreach ($prescriptions as $prescription)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $prescription->medical_record[0]->patient->nama }}</td>
                                        <td>{!! $prescription->status === 'selesai'
                                            ? '<span class="badge badge-success">Selesai</span>'
                                            : '<span class="badge badge-secondary">Menunggu</span>' !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @can('AdminPharmacist')
                    <div class="card-footer clearfix" style="display: block;">
                        <a href="{{ route('resep-obat.index') }}" class="btn btn-sm btn-primary">Lihat Semua
                            Resep</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
