<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ChatMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chat_messages')->insert([
            [
                'from_id' => 1,
                'to_id' => 2,
                'message' => 'Hello, how are you doing today?',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'from_id' => 2,
                'to_id' => 1,
                'message' => 'I am doing well, thank you for asking!',
                'created_at' => Carbon::now()->subDays(2)->addHours(1),
                'updated_at' => Carbon::now()->subDays(2)->addHours(1),
            ],
            [
                'from_id' => 1,
                'to_id' => 2,
                'message' => 'That\'s great to hear! Do you have any updates on the project?',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'from_id' => 2,
                'to_id' => 1,
                'message' => 'Yes, we\'ve completed the first phase and moving to the next one.',
                'created_at' => Carbon::now()->subDays(1)->addHours(2),
                'updated_at' => Carbon::now()->subDays(1)->addHours(2),
            ],
        ]);
    }
}
