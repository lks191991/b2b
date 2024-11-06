<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
       $Permissionitems = [
            [
                'name'        => 'Can list Categories',
                'slug'        => 'list.categories',
                'description' => '',
                'model'       => 'Category',
            ],
            [
                'name'        => 'Can Create categories',
                'slug'        => 'create.categories',
                'description' => 'Can create new users',
                'model'       => 'Category',
            ],
            [
                'name'        => 'Can Edit categories',
                'slug'        => 'edit.categories',
                'description' => 'Can edit categories',
                'model'       => 'Category',
            ],
            [
                'name'        => 'Can Delete categories',
                'slug'        => 'delete.categories',
                'description' => 'Can delete categories',
                'model'       => 'Category',
            ],
			[
                'name'        => 'List products',
                'slug'        => 'list.products',
                'description' => 'Can list products',
                'model'       => 'Product',
            ],
			[
                'name'        => 'Can View products',
                'slug'        => 'view.products',
                'description' => '',
                'model'       => 'Product',
            ],
            [
                'name'        => 'Can Create products',
                'slug'        => 'create.products',
                'description' => 'Can create new products',
                'model'       => 'Product',
            ],
            [
                'name'        => 'Can Edit products',
                'slug'        => 'edit.products',
                'description' => 'Can edit products',
                'model'       => 'Product',
            ],
            [
                'name'        => 'Can Delete products',
                'slug'        => 'delete.products',
                'description' => 'Can delete products',
                'model'       => 'Product',
            ],
			[
                'name'        => 'List products',
                'slug'        => 'list.products',
                'description' => 'Can list products',
                'model'       => 'Product',
            ]
			,
			[
                'name'        => 'List product-assign',
                'slug'        => 'assign.products',
                'description' => 'Can list products',
                'model'       => 'Product',
            ]
			,
			[
                'name'        => 'product Assigned ',
                'slug'        => 'assigned.products',
                'description' => 'assigned products',
                'model'       => 'Product',
            ],
			[
                'name'        => 'Can View orders',
                'slug'        => 'view.orders',
                'description' => '',
                'model'       => 'Order',
            ],
            [
                'name'        => 'Can status change orders',
                'slug'        => 'statuschange.orders',
                'description' => '',
                'model'       => 'Order',
            ],
            [
                'name'        => 'List orders',
                'slug'        => 'list.orders',
                'description' => '',
                'model'       => 'Order',
            ],
			 [
                'name'        => 'Can list Companies',
                'slug'        => 'list.companies',
                'description' => '',
                'model'       => 'Company',
            ],
            [
                'name'        => 'Can Create companies',
                'slug'        => 'create.companies',
                'description' => '',
                'model'       => 'Company',
            ],
            [
                'name'        => 'Can Edit companies',
                'slug'        => 'edit.companies',
                'description' => '',
                'model'       => 'Company',
            ],
            [
                'name'        => 'Can Delete companies',
                'slug'        => 'delete.companies',
                'description' => '',
                'model'       => 'Company',
            ],
			[
                'name'        => 'Can list manufactures',
                'slug'        => 'list.manufactures',
                'description' => '',
                'model'       => 'Manufacture',
            ],
            [
                'name'        => 'Can Create manufactures',
                'slug'        => 'create.manufactures',
                'description' => '',
                'model'       => 'Manufacture',
            ],
            [
                'name'        => 'Can Edit manufactures',
                'slug'        => 'edit.manufactures',
                'description' => '',
                'model'       => 'Manufacture',
            ],
            [
                'name'        => 'Can Delete manufactures',
                'slug'        => 'delete.manufactures',
                'description' => '',
                'model'       => 'Manufacture',
            ],
			[
                'name'        => 'Can list projects',
                'slug'        => 'list.projects',
                'description' => '',
                'model'       => 'Project',
            ],
            [
                'name'        => 'Can Create projects',
                'slug'        => 'create.projects',
                'description' => '',
                'model'       => 'Project',
            ],
            [
                'name'        => 'Can Edit projects',
                'slug'        => 'edit.projects',
                'description' => '',
                'model'       => 'Project',
            ],
            [
                'name'        => 'Can Delete projects',
                'slug'        => 'delete.projects',
                'description' => '',
                'model'       => 'Project',
            ],
			[
                'name'        => 'Can list areas',
                'slug'        => 'list.areas',
                'description' => '',
                'model'       => 'Area',
            ],
            [
                'name'        => 'Can Create areas',
                'slug'        => 'create.areas',
                'description' => '',
                'model'       => 'Area',
            ],
            [
                'name'        => 'Can Edit areas',
                'slug'        => 'edit.areas',
                'description' => '',
                'model'       => 'Area',
            ],
            [
                'name'        => 'Can Delete areas',
                'slug'        => 'delete.areas',
                'description' => '',
                'model'       => 'Area',
            ],
			[
                'name'        => 'Can list areas',
                'slug'        => 'list.areas',
                'description' => '',
                'model'       => 'Area',
            ],
            [
                'name'        => 'Can Create areas',
                'slug'        => 'create.areas',
                'description' => '',
                'model'       => 'Area',
            ],
            [
                'name'        => 'Can Edit areas',
                'slug'        => 'edit.areas',
                'description' => '',
                'model'       => 'Area',
            ],
            [
                'name'        => 'Can Delete areas',
                'slug'        => 'delete.areas',
                'description' => '',
                'model'       => 'Area',
            ],
			[
                'name'        => 'Can Delete areas',
                'slug'        => 'delete.areas',
                'description' => '',
                'model'       => 'Area',
            ],
			[
                'name'        => 'List Users',
                'slug'        => 'list.users',
                'description' => '',
                'model'       => 'User',
            ],
            [
                'name'        => 'List Territory',
                'slug'        => 'list.territory',
                'description' => '',
                'model'       => 'User',
            ],
            [
                'name'        => 'List Technicians',
                'slug'        => 'list.technicians',
                'description' => '',
                'model'       => 'User',
            ],
            [
                'name'        => 'Edit Users',
                'slug'        => 'edit.users',
                'description' => '',
                'model'       => 'User',
            ],
			
			
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}
