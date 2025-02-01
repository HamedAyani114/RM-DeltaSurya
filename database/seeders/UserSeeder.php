<?php

namespace Database\Seeders;

use App\Models\Poly;
use App\Models\User;
use App\Models\Nurse;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Pharmacist;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'username' => 'Admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'username' => 'Dokter',
                'password' => bcrypt('dokter'),
                'role' => 'dokter',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'username' => 'Apoteker',
                'password' => bcrypt('apoteker'),
                'role' => 'apoteker',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'username' => 'Perawat',
                'password' => bcrypt('perawat'),
                'role' => 'perawat',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        User::insert($users);

        $poli = [
            [
                'id_poli' => 'POL01',
                'nama_poli' => 'Poli Umum',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_poli' => 'POL02',
                'nama_poli' => 'Poli Gigi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_poli' => 'POL03',
                'nama_poli' => 'Poli Kandungan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_poli' => 'POL04',
                'nama_poli' => 'Poli Anak',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_poli' => 'POL05',
                'nama_poli' => 'Poli Mata',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        Poly::insert($poli);

        $doctors = [
            [
                'id_dokter' => 'DO001',
                'id' => 2,
                'id_poli' => 'POL01',
                'nama' => 'Dokter 1',
                'email' => 'dokter1@gmail.com',
                'jenis_kelamin' => 'pria',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Dokter 1 No. 1',
                'tgl_lahir' => '1990-01-01',
                'tempat_lahir' => 'Jakarta',
                'photo' => '',
                'created_at' => now(),
                'updated_at' => now()
            ], 
        ];
        Doctor::insert($doctors);

        $nurses = [
            [
                'id_perawat' => 'PE001',
                'id' => 4,
                'nama' => 'Perawat 1',
                'email' => 'perawat1@gmail.com',
                'jenis_kelamin' => 'wanita',
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Perawat 1 No. 1',
                'tgl_lahir' => '1991-01-01',
                'tempat_lahir' => 'Jakarta',
                'photo' => '',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        Nurse::insert($nurses);

        $pharmacists = [
            [
                'id_apoteker' => 'AP001',
                'id' => 2,
                'nama' => 'Apoteker 1',
                'email' => 'apoteker@gmail.com',
                'jenis_kelamin' => 'pria',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Apoteker 1 No. 1',
                'tgl_lahir' => '1992-01-01',
                'tempat_lahir' => 'Jakarta',
                'photo' => '',  
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        Pharmacist::insert($pharmacists);

        $patiens = [
            [
                'id_pasien' => 'PA001',
                'no_bpjs' => '1234567890123',
                'nama' => 'Pasien 1',
                'jenis_kelamin' => 'pria',
                'tgl_lahir' => '1993-01-01',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Pasien 1 No. 1',
                'no_hp' => '081234567893',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasien' => 'PA002',
                'no_bpjs' => '1234567890124',
                'nama' => 'Pasien 2',
                'jenis_kelamin' => 'wanita',
                'tgl_lahir' => '1994-01-01',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Pasien 2 No. 2',
                'no_hp' => '081234567894',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasien' => 'PA003',
                'no_bpjs' => '1234567890125',
                'nama' => 'Pasien 3',
                'jenis_kelamin' => 'pria',
                'tgl_lahir' => '1995-01-01',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Pasien 3 No. 3',
                'no_hp' => '081234567895',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasien' => 'PA004',
                'no_bpjs' => '1234567890126',
                'nama' => 'Pasien 4',
                'jenis_kelamin' => 'wanita',
                'tgl_lahir' => '1996-01-01',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Pasien 4 No. 4',
                'no_hp' => '081234567896',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasien' => 'PA005',
                'no_bpjs' => '1234567890127',
                'nama' => 'Pasien 5',
                'jenis_kelamin' => 'pria',
                'tgl_lahir' => '1997-01-01',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Pasien 5 No. 5',
                'no_hp' => '081234567897',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasien' => 'PA006',
                'no_bpjs' => '1234567890128',
                'nama' => 'Pasien 6',
                'jenis_kelamin' => 'wanita',
                'tgl_lahir' => '1998-01-01',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Pasien 6 No. 6',
                'no_hp' => '081234567898',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        Patient::insert($patiens);
                
    }
}
