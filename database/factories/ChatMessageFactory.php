<?php

namespace Database\Factories;

use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatMessageFactory extends Factory
{
    protected $model = ChatMessage::class;

    public function definition()
    {
        return [
            'from_id' => 1,
            'to_id' => 2,
            'message' => $this->faker->sentence,
        ];
    }
}
