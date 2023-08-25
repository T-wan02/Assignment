<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'User One',
            'email' => 'userone@gmail.com',
            'password' => Hash::make('password')
        ]);

        // Employee
        Employee::create([
            'name' => 'Employee One',
            'email' => 'employeeone@gmail.com',
            'phone_number' => '09123456789',
            'job_title' => 'Developer'
        ]);
        Employee::create([
            'name' => 'Employee Two',
            'email' => 'employeetwo@gmail.com',
            'phone_number' => '09123456789',
            'job_title' => 'Developer'
        ]);
        Employee::create([
            'name' => 'Employee Three',
            'email' => 'employeethree@gmail.com',
            'phone_number' => '09123456789',
            'job_title' => 'Developer'
        ]);
        Employee::create([
            'name' => 'Employee Four',
            'email' => 'employeefour@gmail.com',
            'phone_number' => '09123456789',
            'job_title' => 'Developer'
        ]);
    }
}
