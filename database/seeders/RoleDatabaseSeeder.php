<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $roles = [
            ['name' => 'super-admin', 'display_name' => 'Super-admin','group' =>'system'],
            ['name' => 'admin', 'display_name' => 'Admin','group' =>'system'],
            ['name' => 'employee', 'display_name' => 'Employee','group' =>'system'],
            ['name' => 'manager', 'display_name' => 'Manager','group' =>'system'],
            ['name' => 'user', 'display_name' => 'User','group' =>'system'],
        ];

        foreach ($roles as $role) {
           Role::updateOrCreate($role);
        }

        $superAdmin = User::whereEmail('admin@gmail.com')->first();

        if(!$superAdmin)
        {
            $superAdmin = User::factory()->create(['email' => 'admin@gmail.com']);
        }
        $superAdmin->assignRole('super-admin');


        $permissions = [
            ['name' => 'create-user', 'display_name' => 'create user','group' =>'User'],
            ['name' => 'store-user', 'display_name' => 'store user','group' =>'User'],
            ['name' => 'show-user', 'display_name' => 'show user','group' =>'User'],
            ['name' => 'delete-user', 'display_name' => 'delete user','group' =>'User'],

            ['name' => 'create-role', 'display_name' => 'create role','group' =>'Role'],
            ['name' => 'store-role', 'display_name' => 'store role','group' =>'Role'],
            ['name' => 'show-role', 'display_name' => 'show role','group' =>'Role'],
            ['name' => 'delete-role', 'display_name' => 'delete role','group' =>'Role'],

            ['name' => 'create-product', 'display_name' => 'create product','group' =>'Product'],
            ['name' => 'store-product', 'display_name' => 'store product','group' =>'Product'],
            ['name' => 'show-product', 'display_name' => 'show product','group' =>'Product'],
            ['name' => 'delete-product', 'display_name' => 'delete product','group' =>'Product'],

            ['name' => 'create-category', 'display_name' => 'create category','group' =>'Category'],
            ['name' => 'store-category', 'display_name' => 'store category','group' =>'Category'],
            ['name' => 'show-category', 'display_name' => 'show category','group' =>'Category'],
            ['name' => 'delete-category', 'display_name' => 'delete category','group' =>'Category'],

            ['name' => 'create-coupon', 'display_name' => 'create coupon','group' =>'Coupon'],
            ['name' => 'store-coupon', 'display_name' => 'store coupon','group' =>'Coupon'],
            ['name' => 'show-coupon', 'display_name' => 'show coupon','group' =>'Coupon'],
            ['name' => 'delete-coupon', 'display_name' => 'delete coupon','group' =>'Coupon'],

            ['name' => 'list-order', 'display_name' => 'list order','group' =>'orders'],
            ['name' => 'update-order-status', 'display_name' => 'Update order status','group' =>'orders'],
        ];

        foreach ($permissions as $item) {
            Permission::updateOrCreate($item);
         }
        
    }
}
