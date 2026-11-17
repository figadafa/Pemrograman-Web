<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(3, true),
            'category' => fake()->randomElement(['Anime', 'Drama', 'Manga', 'Light Novel']),
            'creator' => fake()->name(),
            'year' => fake()->numberBetween(1990, 2025),
        ];
    }

    public function anime(): static
    {
        return $this->state(fn () => [
            'category' => 'Anime',
            'studio' => fake()->company(),
        ]);
    }

    public function drama(): static
    {
        return $this->state(fn () => [
            'category' => 'Drama',
            'country' => fake()->country(),
            'duration_minutes' => fake()->numberBetween(20, 90),
        ]);
    }

    public function manga(): static
    {
        return $this->state(fn () => [
            'category' => 'Manga',
            'genre' => fake()->word(),
            'total_chapters' => fake()->numberBetween(10, 1000),
        ]);
    }

    public function lightNovel(): static
    {
        return $this->state(fn () => [
            'category' => 'Light Novel',
            'total_chapters' => fake()->numberBetween(10, 300),
            'total_volumes' => fake()->numberBetween(1, 30),
        ]);
    }
}
