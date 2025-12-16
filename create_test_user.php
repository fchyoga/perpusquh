<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $user = User::firstOrCreate(
        ['nim' => '12345'],
        [
            'name' => 'Mahasiswa Test',
            'username' => '12345',
            'email' => '12345@student.com',
            'password' => Hash::make('12345'),
            'role' => 'member',
            'prodi' => 'TI',
            'jurusan' => 'Informatika',
            'semester' => '1'
        ]
    );
    echo "User created/retrieved successfully: " . $user->name . "\n";
} catch (\Exception $e) {
    echo "Error creating user: " . $e->getMessage() . "\n";
}
