<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Contact::factory(50)->create();
    }
}
