<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Queue;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\MedicineRecipe;
use App\Models\MedicalPrescription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedicalRecordController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $this->auth = Http::post('http://recruitment.rsdeltasurya.com/api/v1/auth', [
            'email' => 'hamedayani27@gmail.com',
            'password' => '089616087216'
        ])->json();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedMedRecord = $request->validate([
            'id_pasien' => ['required', 'size:5'],
            'id_dokter' => ['required', 'size:5'],
            'id_poli' => ['required', 'size:5'],
            'berat_badan' => ['required', 'numeric', 'max_digits:3'],
            'tinggi_badan' => ['required', 'numeric', 'max_digits:3'],
            'sistole' => ['required', 'numeric', 'max_digits:3'],
            'diastole' => ['required', 'numeric', 'max_digits:3'],
            'gula_darah' => ['required', 'numeric', 'max_digits:3'],
            'heart_rate' => ['required', 'numeric', 'max_digits:3'],
            'respiration_rate' => ['required', 'numeric', 'max_digits:3'],
            'suhu_tubuh' => ['required', 'numeric', 'max_digits:3'],
            'alergi' => ['nullable'],
            'keluhan' => ['required'],
            'diagnosis' => ['required'],
            'terapi' => ['required'],
            'berkas_pemeriksaan' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:2048']
        ]);

        $path = "public/medical_records";
        if ($request->hasFile('berkas_pemeriksaan')) {
            $validatedMedRecord['berkas_pemeriksaan'] = $request->file('berkas_pemeriksaan')->storeAs($path, 'berkas_pemeriksaan_'. $request->id_pasien . "_" . time() . '.' . $request->file('berkas_pemeriksaan')->extension());
        }
        
        
        $validatedMedRecord['tgl_periksa'] = Carbon::now();

        MedicalRecord::create($validatedMedRecord);

        $latest_med_record = MedicalRecord::latest()->first();

        $validatedMedPrescription["id_dokter"] = $request->id_dokter;
        $validatedMedPrescription["id_rekmed"] = $latest_med_record->id_rekmed;

        MedicalPrescription::create($validatedMedPrescription);

        $queue = Queue::where('id_antrian', $request->id_antrian)->first();
        $queue->update([
            'status' => 1
        ]);

        $patient_id = $queue->patient->id_pasien;

        $latest_med_pres = MedicalPrescription::latest()->first();

        for ($i=0; $i < count($request->id_obat); $i++) { 
            $getMedicinePrice = Http::withToken($this->auth['access_token'])
                            ->get('http://recruitment.rsdeltasurya.com/api/v1/medicines/' .
                             explode(',', $request->id_obat[$i])[0] . '/prices')->json();
            
            $latestMedPrice = [];

            foreach ($getMedicinePrice['prices'] as $price) {
                if ($price['end_date']['value'] >= Carbon::now()->format('Y-m-d') || $price['end_date']['value'] == null) {
                    $latestMedPrice = $price['unit_price'];
                }
            }

            $totalPrice = $latestMedPrice * $request->jumlah[$i];

            $validatedMedRecipes = [
                'id_resep' => $latest_med_pres->id_resep,
                'id_obat' => explode(',', $request->id_obat[$i])[0],
                'nama_obat' => explode(',', $request->id_obat[$i])[1],
                'jumlah' => $request->jumlah[$i],
                'aturan_pakai' => $request->aturan_pakai[$i],
                'harga' => $totalPrice
            ];

            MedicineRecipe::create($validatedMedRecipes);
        }

        Log::info('User ' . auth()->user()->username . ' telah menambahkan data rekam medis pasien ' . $queue->patient->nama);

        return redirect()->route('antrian.index')
            ->with('success', 'Pasien dengan nama 
                <strong>' . $queue->patient->nama . "</strong> 
                telah di periksa <a class='btn btn-sm btn-primary text-decoration-none' href='/pasien/$patient_id'>Tampilkan</a>");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $pasien, MedicalRecord $rekam_medis)
    {
        return view('medical_records.detail', [
            'pageTitle' => 'Detail Rekam Medis',
            'medRecord' => $rekam_medis,
            'patient' => $pasien
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $pasien, MedicalRecord $rekam_medis)
    {
        $medicines = Http::withToken($this->auth['access_token'])
        ->get('http://recruitment.rsdeltasurya.com/api/v1/medicines')
        ->json();

        return view('medical_records.edit', [
            'pageTitle' => 'Edit Rekam Medis',
            'medRecord' => $rekam_medis,
            'patient' => $pasien,
            'medicines' => $medicines['medicines'],
            'medicineRecipes' => MedicineRecipe::where('id_resep', $rekam_medis->prescription->id_resep)->get(),
            'prescription' => MedicalPrescription::where('id_rekmed', $rekam_medis->id_rekmed)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalRecord $rekam_medis)
    {
        $validatedMedRecord = $request->validate([

            'berat_badan' => ['required', 'numeric', 'max_digits:3'],
            'tinggi_badan' => ['required', 'numeric', 'max_digits:3'],
            'sistole' => ['required', 'numeric', 'max_digits:3'],
            'diastole' => ['required', 'numeric', 'max_digits:3'],
            'gula_darah' => ['nullable', 'numeric', 'max_digits:3'],
            'heart_rate' => ['required', 'numeric', 'max_digits:3'],
            'respiration_rate' => ['required', 'numeric', 'max_digits:3'],
            'suhu_tubuh' => ['required', 'numeric', 'max_digits:3'],
            'alergi' => ['nullable'],
            'keluhan' => ['required'],
            'diagnosis' => ['required'],
            'terapi' => ['required'],
            'berkas_pemeriksaan' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:2048']
        ]);

        $path = "public/medical_records";

        if ($request->hasFile('berkas_pemeriksaan')) {
            $berkas_pemeriksaan = explode('/', $rekam_medis->berkas_pemeriksaan)[2];
        } else {
            $berkas_pemeriksaan = 'berkas_pemeriksaan_' . $rekam_medis->id_rekmed . '.' . $request->file('berkas_pemeriksaan')->getClientOriginalExtension();
        }
        
        if ($request->hasFile('berkas_pemeriksaan')) {
            $validatedMedRecord['berkas_pemeriksaan'] = $request->file('berkas_pemeriksaan')->storeAs($path, $berkas_pemeriksaan);
        }

        // update query
        // medical record
        $medRecordUpdate = MedicalRecord::where('id_rekmed', $rekam_medis->id_rekmed)->first();
        $medRecordUpdate->fill($validatedMedRecord);
        $changesMedRecord = $medRecordUpdate->getDirty();
        $medRecordUpdate->save();

        // prescription
        $prescriptionUpdate = MedicalPrescription::where('id_resep', $rekam_medis->prescription->id_resep)->first();
        $changesPrescription = $prescriptionUpdate->getDirty();
        $prescriptionUpdate->save();

        // update medicine recipe
        $medRecipe = MedicineRecipe::where('id_resep', $rekam_medis->prescription->id_resep)->get();
        for ($i=0; $i < count($request->id_obat); $i++) {
            $getMedicinePrice = Http::withToken($this->auth['access_token'])
                ->get('http://recruitment.rsdeltasurya.com/api/v1/medicines/' .
                    explode(',', $request->id_obat[$i])[0] . '/prices')->json();

            $latestMedPrice = [];

            foreach ($getMedicinePrice['prices'] as $price) {
                if ($price['end_date']['value'] >= Carbon::now()->format('Y-m-d') || $price['end_date']['value'] == null) {
                    $latestMedPrice = $price['unit_price'];
                }
            }

            $totalPrice = $latestMedPrice * $request->jumlah[$i];

            // update and create new medicine recipe if not exist
            if (isset($medRecipe[$i])) {
                $medRecipe[$i]->update([
                    'id_obat' => explode(',', $request->id_obat[$i])[0],
                    'nama_obat' => explode(',', $request->id_obat[$i])[1],
                    'jumlah' => $request->jumlah[$i],
                    'aturan_pakai' => $request->aturan_pakai[$i],
                    'harga' => $totalPrice
                ]);
            } else {
                MedicineRecipe::create([
                    'id_resep' => $rekam_medis->prescription->id_resep,
                    'id_obat' => explode(',', $request->id_obat[$i])[0],
                    'nama_obat' => explode(',', $request->id_obat[$i])[1],
                    'jumlah' => $request->jumlah[$i],
                    'aturan_pakai' => $request->aturan_pakai[$i],
                    'harga' => $totalPrice
                ]);
            }
        }

        if ($changesMedRecord !== [] || $changesPrescription !== []) {
            Log::info('User ' . auth()->user()->username . ' telah mengubah data rekam medis pasien ' . $rekam_medis->patient->nama);

            return redirect()->route('rekam_medis.show', [$rekam_medis->id_pasien, $rekam_medis->id_rekmed])
                ->with('success', 'Data rekam medis berhasil di update');
        } else {
            Log::info('User ' . auth()->user()->username . ' gagal mengubah data rekam medis pasien ' . $rekam_medis->patient->nama);

            return redirect()->route('rekam_medis.show', [$rekam_medis->id_pasien, $rekam_medis->id_rekmed]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalRecord $rekam_medis)
    {
        MedicalRecord::where('id_rekmed', $rekam_medis->id_rekmed)->delete();
        Log::info('User ' . auth()->user()->username . ' telah menghapus data rekam medis pasien ' . $rekam_medis->patient->nama);
        return redirect()->route('pasien.show', $rekam_medis->id_pasien)->with('success', 'Data berhasil dihapus');
    }

    public function print(MedicalRecord $rekam_medis)
    {
        return view('prints.medical_record', [
            'medRecord' => $rekam_medis
        ]);
    }

    public function printAll(Patient $pasien)
    {
        return view('prints.medical_record_all', [
            'patient' => $pasien,
            'medRecords' => $pasien->medicalRecord
        ]);
    }
}