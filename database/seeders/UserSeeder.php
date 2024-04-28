<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roleAuthor = Role::findByName('Author');
        $roleAdmin = Role::findByName('Admin');

        $response = Http::get('https://jsonplaceholder.typicode.com/users');
        $users = $response->json();

        foreach ($users as $user) {
            $newUser = User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'address' => json_encode($user['address']),
                'phone' => $user['phone'],
                'website' => $user['website'],
                'company' => json_encode($user['company']),
            ]);

            $newUser->assignRole($roleAuthor);
        }

        $adminUser = User::create([
            'name' => 'Osmar Liera',
            'username' => 'osmarlg',
            'email' => 'osmarlg@apiblog.com',
            'password' => Hash::make('password'),
            'address' => '{"street": "Kulas Light","suite": "Apt. 556","city": "Gwenborough","zipcode": "92998-3874","geo": {"lat": "-37.3159","lng": "81.1496"}}',
            'phone' => '6151559659',
            'website' => 'surcode.com.mx',
            'company' => '{"name":"SurCode","catchPhrase": "Proactive didactic","bs": "synergize scalable supply-chains"}'
        ]);

        $adminUser->assignRole($roleAdmin);
    }
}
