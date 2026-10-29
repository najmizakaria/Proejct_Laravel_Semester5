<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // Demo credentials must never be provisioned outside a local/test environment.
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        foreach ([
            ['name' => 'Bookstore Admin', 'email' => 'admin@bookstore.test', 'is_admin' => true],
            ['name' => 'Bookstore Reader', 'email' => 'reader@bookstore.test', 'is_admin' => false],
        ] as $attributes) {
            // Preserve existing accounts, passwords, and privileges when this seeder is rerun.
            if (! User::where('email', $attributes['email'])->exists()) {
                $user = new User;
                $user->name = $attributes['name'];
                $user->email = $attributes['email'];
                $user->is_admin = $attributes['is_admin'];
                $user->password = Hash::make('Bookstore@123');
                $user->save();
            }
        }
    }
}
