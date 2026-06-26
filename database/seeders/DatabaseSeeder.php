<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Departments
        $departments = [
            ['name' => 'Computer Science', 'code' => 'CSC', 'description' => 'Department of Computer Science'],
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'Department of Information Technology'],
            ['name' => 'Cyber Security', 'code' => 'CYB', 'description' => 'Department of Cyber Security'],
            ['name' => 'Software Engineering', 'code' => 'SWE', 'description' => 'Department of Software Engineering'],
            ['name' => 'Data Science', 'code' => 'DSC', 'description' => 'Department of Data Science'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Seed Categories
        $categories = [
            ['name' => 'Journal Article', 'slug' => 'journal-article', 'description' => 'Peer-reviewed journal articles'],
            ['name' => 'Conference Paper', 'slug' => 'conference-paper', 'description' => 'Conference proceedings and papers'],
            ['name' => 'Final Year Project', 'slug' => 'final-year-project', 'description' => 'Undergraduate final year projects'],
            ['name' => 'Thesis', 'slug' => 'thesis', 'description' => 'Postgraduate theses and dissertations'],
            ['name' => 'Technical Report', 'slug' => 'technical-report', 'description' => 'Technical and research reports'],
            ['name' => 'Book Chapter', 'slug' => 'book-chapter', 'description' => 'Chapters in edited books'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Seed Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@lasu.edu.ng',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'department_id' => 1,
        ]);
    }
}
