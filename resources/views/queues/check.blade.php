@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Periksa Pasien</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('rekam_medis.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- hidden input --}}
                        <input type="hidden" name="id_pasien" value="{{ $queue->patient->id_pasien }}">
                        <input type="hidden" name="id_poli" value="{{ $queue->poly->id_poli }}">
                        <input type="hidden" name="id_antrian" value="{{ $queue->id_antrian }}">

                        @if (auth()->user()->role === 'dokter')
                            <input type="hidden" name="id_dokter" value="{{ auth()->user()->doctor->id_dokter }}">
                        @endif

                        <div class="row">
                            <div class="col-6">
                                <table cellpadding="5">
                                    <tbody>
                                        <tr>
                                            <td>ID Pasien</td>
                                            <td>:</td>
                                            <td>{{ $queue->patient->id_pasien }}</td>
                                        </tr>
                                        <tr>
                                            <td>ID Antrian</td>
                                            <td>:</td>
                                            <td>{{ $queue->id_antrian }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Dokter</td>
                                            <td>:</td>
                                            <td>
                                                @if (auth()->user()->role === 'dokter')
                                                    {{ auth()->user()->doctor->nama }}
                                                @else
                                                    <select name="id_dokter" id="doctor-select"
                                                        class="form-control @error('id_dokter') is-invalid @enderror" required>
                                                        <option value="">Pilih dokter</option>
                                                        @foreach ($doctors as $id => $doctor)
                                                            <option value="{{ $id }}"
                                                                {{ old('id_dokter') ? 'selected' : '' }}>
                                                                {{ $id . ' - ' . $doctor }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                @error('id_dokter')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <table cellpadding="5">
                                    <tbody>
                                        <tr>
                                            <td>Nama Pasien</td>
                                            <td>:</td>
                                            <td>{{ $queue->patient->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal / Jam</td>
                                            <td>:</td>
                                            <td>{{ now()->format('d M y / H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Poli</td>
                                            <td>:</td>
                                            <td>{{ $queue->poly->nama_poli }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="berat_badan">Berat Badan (kg)</label>
                                    <input type="number" class="form-control @error('berat_badan') is-invalid @enderror"
                                        placeholder="Berat Badan" id="berat_badan" name="berat_badan"
                                        value="{{ old('berat_badan') }}" min="0" required>
                                    @error('berat_badan')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                    <input type="number" class="form-control @error('tinggi_badan') is-invalid @enderror"
                                        placeholder="Tinggi Badan" id="tinggi_badan" name="tinggi_badan"
                                        value="{{ old('tinggi_badan') }}" min="0" required>
                                    @error('tinggi_badan')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sistole">Sistole (mmHg)</label>
                                    <input type="number" class="form-control @error('sistole') is-invalid @enderror"
                                        placeholder="Sistole" id="sistole" name="sistole" value="{{ old('sistole') }}" min="0" required>
                                    @error('sistole')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="diastole">Diastole (mmHg)</label>
                                    <input type="number" class="form-control @error('diastole') is-invalid @enderror"
                                        placeholder="Diastole" id="diastole" name="diastole"
                                        value="{{ old('diastole') }}" min="0" required>
                                    @error('diastole')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            {{-- gula darah --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gula_darah">Gula Darah (mg/dL)</label>
                                    <input type="number" class="form-control @error('gula_darah') is-invalid @enderror"
                                        placeholder="Gula Darah" id="gula_darah" name="gula_darah"
                                        value="{{ old('gula_darah') }}" min="0" required>
                                    @error('gula_darah')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="heart_rate">Heart Rate (bpm)</label>
                                    <input type="number" class="form-control @error('heart_rate') is-invalid @enderror"
                                        placeholder="Heart Rate" id="heart_rate" name="heart_rate"
                                        value="{{ old('heart_rate') }}" min="0" required>
                                    @error('heart_rate')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="respiration_rate">Respiratory Rate (bpm)</label>
                                    <input type="number" class="form-control @error('respiration_rate') is-invalid @enderror"
                                        placeholder="Respiratory Rate" id="respiration_rate" name="respiration_rate"
                                        value="{{ old('respiration_rate') }}" min="0" required>
                                    @error('respiration_rate')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="suhu_tubuh">Suhu (°C)</label>
                                    <input type="number" class="form-control @error('suhu_tubuh') is-invalid @enderror"
                                        placeholder="suhu_tubuh" id="suhu_tubuh" name="suhu_tubuh" value="{{ old('suhu_tubuh') }}" min="0" required>
                                    @error('suhu_tubuh')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="alergi">Alergi</label>
                                    <input type="text" class="form-control @error('alergi') is-invalid @enderror"
                                        name="alergi" id="alergi" placeholder="Alergi" value="{{ old('alergi') }}">
                                    @error('alergi')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="keluhan">Keluhan</label>
                                    <textarea name="keluhan" id="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3"
                                        placeholder="Keluhan pasien" required>{{ old('keluhan') }}</textarea>
                                    @error('keluhan')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="diagnosis">Diagnosis</label>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3"
                                        placeholder="Diagnosis" required>{{ old('diagnosis') }}</textarea>
                                    @error('diagnosis')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="terapi">Terapi</label>
                                    <textarea name="terapi" id="terapi" class="form-control @error('terapi') is-invalid @enderror" rows="3"
                                        placeholder="Terapi" required>{{ old('terapi') }}</textarea>
                                    @error('terapi')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                {{-- input file --}}
                                <div class="form-group">
                                    <label class="form-label" for="berkas_pemeriksaan">File Pemeriksaan (Opsional)</label>
                                    <input type="file" class="form-control-file @error('berkas_pemeriksaan') is-invalid @enderror"
                                        name="berkas_pemeriksaan" id="berkas_pemeriksaan" value="{{ old('berkas_pemeriksaan') }}"
                                        accept=".jpg, .jpeg, .png, .pdf">
                                    @error('berkas_pemeriksaan')
                                    <p class="invalid-feedback">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                    <small class="text-muted">File harus berformat .jpg, .jpeg, .png, .pdf</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Resep Obat</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="id_obat">Pilih Obat</label>
                                            <select name="id_obat[]" id="medicine-select"
                                                class="form-control @error('id_obat') is-invalid @enderror" required>
                                                <option disabled selected value="">Pilih Obat</option>    
                                                @foreach ($medicines as $medicine)
                                                    <option value="{{ $medicine['id'] }},{{ $medicine['name'] }}"
                                                        {{ old('id_obat') ? 'selected' : '' }}>
                                                        {{ $medicine['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_obat')
                                                <p class="invalid-feedback">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" name="jumlah[]" id="jumlah"
                                            class="form-control @error('jumlah') is-invalid @enderror"
                                            placeholder="Jumlah" value="" required>
                                        @error('jumlah')
                                            <p class="invalid-feedback">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-5">
                                        <label for="aturan_pakai">Aturan Pakai</label>
                                        <input id="aturan_pakai" type="text" name="aturan_pakai[]"
                                            class="form-control @error('aturan_pakai') is-invalid @enderror"
                                            value="" required>
                                        @error('aturan_pakai')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>

                                <div id="additional-medicines"></div>
                                                                
                                <div class="form-group d-flex justify-content-end">
                                    <button type="button" class="btn btn-sm btn-primary mr-2" id="add-medicine">
                                        <i class="fa-solid fa-plus me-1"></i>
                                        Tambah Obat
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" id="remove-medicine">
                                        <i class="fa-solid fa-minus me-1"></i>
                                        Hapus Obat
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('antrian.index') }}" class="btn btn-sm btn-info">
                                        <i class="fa-solid fa-circle-xmark mr-1"></i>
                                        Kembali
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-sm btn-info float-right">
                                        <i class="fa-solid fa-check mr-1"></i>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
    <script>
        $(document).ready(function() {
            $('#doctor-select').select2();
        });

        $(document).ready(function() {
            $('#medicine-select').select2();
        });
    </script>

    <script>
            $(document).ready(function() {
                    let medicineSelect = $('#medicine-select').html();
                    let additionalMedicines = $('#additional-medicines');
                    let addMedicine = $('#add-medicine');
        
                    let medicineCount = 1;
        
                    addMedicine.click(function() {
                        medicineCount++;
                        let newMedicine = `
                            <div class="row" id="medicine-${medicineCount}">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label for="id_obat">Pilih Obat</label>
                                        <select name="id_obat[]" id="medicine-select"
                                            class="form-control @error('id_obat') is-invalid @enderror" required>
                                            ${medicineSelect}
                                        </select>
                                        @error('id_obat')
                                            <p class="invalid-feedback">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-2">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah[]" id="jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror " required
                                        placeholder="Jumlah"
                                        value="">
                                    @error('jumlah')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-5">
                                    <label for="aturan_pakai">Aturan Pakai</label>
                                    <input id="aturan_pakai" type="text" name="aturan_pakai[]"
                                        class="form-control @error('aturan_pakai') is-invalid @enderror" required
                                        value="">
                                    @error('aturan_pakai')
                                    <p class="invalid-feedback">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                        `;
                        additionalMedicines.append(newMedicine);
                    });
                });
        </script>

        <script>
            $(document).ready(function() {
                let removeMedicine = $('#remove-medicine');
                let additionalMedicines = $('#additional-medicines');
        
                removeMedicine.click(function() {
                    let lastMedicine = $('#additional-medicines').children().last();
                    lastMedicine.remove();
                });
            });
        </script>
@endsection
