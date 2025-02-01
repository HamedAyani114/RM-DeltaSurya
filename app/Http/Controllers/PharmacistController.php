<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PharmacistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pharmacists.index', [
            'pageTitle' => 'Data Apoteker',
            'pharmacists' => Pharmacist::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pharmacists.create', [
            'pageTitle' => 'Tambah Apoteker',
            'pharmacists' => Pharmacist::latest()->limit(5)->pluck('nama', 'id_apoteker')
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
        // data validation
        $validatedData = $request->validate([
            'nama' => ['required', 'max:100'],
            'email' => ['nullable', 'email:dns', 'unique:pharmacists', 'max:50'],
            'jenis_kelamin' => ['required'],
            'no_hp' => ['required', 'numeric', 'unique:pharmacists', 'max_digits:15'],
            'tgl_lahir' => ['nullable', 'date'],
            'tempat_lahir' => ['nullable', 'max:50'],
            'alamat' => ['nullable', 'max:255'],
            'username' => ['required', 'unique:users', 'max:255'],
            'password' => ['required', 'min:5']
        ]);

        // create pharmacist id
        $pharmacistCount = Pharmacist::count() + 1;
        if($pharmacistCount < 10) {
            $code = '00' . $pharmacistCount;
        }
        elseif($pharmacistCount < 100) {
            $code = '0' . $pharmacistCount;
        }else {
            $code = '';
        }

        $validatedData['id_apoteker'] = 'AP' . $code;

        // create user first, and get the user id for pharmacist
        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'apoteker'
        ]);
        $user_id = User::where('username', $request->username)->pluck('id');
        $validatedData['id'] = $user_id[0];

        // store pharmacist data
        Pharmacist::create($validatedData);

        Log::info('User ' . auth()->user()->name . ' menambahkan data apoteker ' . $validatedData['nama']);

        return redirect()->route('apoteker.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function show(Pharmacist $apoteker)
    {
        return view('pharmacists.detail', [
            'pageTitle' => $apoteker->nama,
            'pharmacist' => $apoteker
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function edit(Pharmacist $pharmacist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pharmacist $apoteker)
    {
        // if request photo is true
        // return var_dump($request->photo);
        if($request->photo) {
            $validatedData = $request->validate([
                'photo' => ['nullable', 'image', 'file', 'max:1024']
            ]);

            $validatedData['photo'] = $request->file('photo')->store('user-photo');
            Pharmacist::where('id_apoteker', $apoteker->id_apoteker)->update($validatedData);
            
            return back()->with('success', 'Foto berhasil di update');
        }

        // data validation
        $rules = [
            'nama' => ['required', 'max:100'],
            'jenis_kelamin' => ['required'],
            'tgl_lahir' => ['nullable', 'date'],
            'tempat_lahir' => ['nullable', 'max:50'],
            'alamat' => ['nullable', 'max:255'],
        ];

        // rules if request number, email is equal pharmacist
        if($request->no_hp !== $apoteker->no_hp) {
            $rules['no_hp'] = ['required', 'numeric', 'unique:pharmacists', 'max_digits:15'];
        }

        if($request->email !== $apoteker->email) {
            $rules['email'] = ['nullable', 'email:dns', 'unique:pharmacists', 'max:50'];
        }

        $validatedData = $request->validate($rules);

        // update
        Pharmacist::where('id_apoteker', $apoteker->id_apoteker)
                ->update($validatedData);
        
        Log::info('User ' . auth()->user()->name . ' mengubah data apoteker ' . $apoteker->nama);

        return back()->with('success', 'Data berhasil di update')
                ->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacist $apoteker)
    {
        Log::info('User ' . auth()->user()->name . ' telah menghapus data apoteker ' . $apoteker->nama);
        Pharmacist::where('id_apoteker', $apoteker->id_apoteker)->delete();
        User::where('id', $apoteker->user->id)->delete();
        return redirect()->route('apoteker.index')->with('success', "Data <strong>$apoteker->nama</strong> berhasil dihapus");
    }
}
