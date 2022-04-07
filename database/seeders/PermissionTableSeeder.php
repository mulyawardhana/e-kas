<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'jkas-list',
            'jkas-create',
            'jkas-edit',
            'jkas-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'klasifikasi-list',
            'klasifikasi-create',
            'klasifikasi-edit',
            'klasifikasi-delete',
            'efilling-list',
            'efilling-create',
            'efilling-edit',
            'efilling-delete',
            'cashbon-list',
            'cashbon-create',
            'cashbon-edit',
            'cashbon-delete',
            'cashopname-list',
            'cashopname-create',
            'cashopname-edit',
            'cashopname-delete',
            'jabatan-list',
            'jabatan-create',
            'jabatan-edit',
            'jabatan-delete',
            'pemeriksa-kas-list',
            'pemeriksa-kas-create',
            'pemeriksa-kas-edit',
            'pemeriksa-kas-delete',
            'pemakaian-list',
            'pemakaian-create',
            'pemakaian-edit',
            'pemakaian-delete',
            'pengisian-penyesuaian',
            'pengisian-list',
            'pengisian-create',
            'pengisian-edit',
            'pengisian-delete',
            'posting-list',
            'posting-create',
            'posting-edit',
            'posting-delete',
            'pertanggungjawaban-list',
            'pertanggungjawaban-create',
            'pertanggungjawaban-edit',
            'pertanggungjawaban-delete',
            'report-operasional-list',
            'report-operasional-create',
            'report-operasional-edit',
            'report-operasional-delete',
            'report-nasional-list',
            'report-nasional-create',
            'report-nasional-edit',
            'report-nasional-delete',
            'report-lpj-list',
            'report-lpj-create',
            'report-lpj-edit',
            'report-lpj-delete',
                'akun-bank-list',
                'akun-bank-create',
                'akun-bank-edit',
                'akun-bank-delete',

         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
