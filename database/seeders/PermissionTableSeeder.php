<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

            'invoices',
            'invoices list',
            'paid invoices',
            'unpaid invoices',
            'part of paid invoices',
            'invoices archive',

            'reports',
            'invoices reports',
            'customers reports',

            'users',
            'users list',
            'users permission',

            'sections and products',
            'sections',
            'products',

            'options',

            'create invoices',
            'remove invoices',
            'edit invoices',
            'details invoices',
            'update status',
            'archived invoice',
            'print invoice',

            'paid status',
            'attachment',
            'add attachment',
            'remove attachment',

            'create user',
            'edit user',
            'remove user',

            'show permission',
            'create permission',
            'edit permission',
            'remove permission',

            'create product',
            'edit product',
            'remove product',

            'create section',
            'edit section',
            'remove section',

            'profile',
            'edit information',
            'messages',
            'sitting',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
