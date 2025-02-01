<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('patients.index', [
            'pageTitle' => 'Data Pasien',
            'patients' => Patient::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create', [
            'pageTitle' => 'Tambah Pasien',
            'patients' => Patient::latest()->limit(5)->pluck('nama', 'id_pasien')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_bpjs' => ['nullable', 'numeric', 'digits:13', 'unique:patients'],
            'nama' => ['required', 'max:100'],
            'jenis_kelamin' => ['required', 'alpha'],
            'tgl_lahir' => ['required', 'date'],
            'tempat_lahir' => ['required', 'max:50'],
            'no_hp' => ['required', 'numeric', 'unique:patients', 'max_digits:15'],
            'alamat' => ['required'],
        ]);

        // create patients id
        $patientsCount = Patient::count() + 1;
        if ($patientsCount < 10) {
            $code = '00' . $patientsCount;
        } elseif ($patientsCount < 100) {
            $code = '0' . $patientsCount;
        } else {
            $code = '';
        }

        $validatedData['id_pasien'] = 'PA' . $code;

        Patient::create($validatedData);

        Log::info('User ' . auth()->user()->name . ' menambahkan data pasien ' . $validatedData['nama']);

        return redirect()->route('pasien.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $pasien)
    {
        return view('patients.detail', [
            'pageTitle' => $pasien->nama,
            'patient' => $pasien,
            'medRecords' => $pasien->medicalRecord->sortDesc()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $pasien)
    {
        return view('patients.edit', [
            'pageTitle' => $pasien->nama,
            'patient' => $pasien,
            'patients' => Patient::latest()->limit(5)->orderBy('updated_at', 'desc')
                ->pluck('nama', 'id_pasien')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $pasien)
    {
        Log::info('User ' . auth()->user()->name . ' berhasil menghapus data pasien ' . $pasien->nama);
        Patient::where('id_pasien', $pasien->id_pasien)->delete();
        return redirect()->route('pasien.index')->with('success', "Data <strong>$pasien->nama</strong> berhasil dihapus");
    }
}