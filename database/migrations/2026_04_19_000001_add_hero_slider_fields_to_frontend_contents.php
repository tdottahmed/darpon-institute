<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\FrontendContent;

return new class extends Migration
{
    public function up(): void
    {
        $items = [
            ['key' => 'hero_mode', 'type' => 'text',  'value' => ['en' => 'image', 'bn' => 'image']],
            ['key' => 'slider_image_1', 'type' => 'image', 'value' => ['en' => '', 'bn' => '']],
            ['key' => 'slider_image_2', 'type' => 'image', 'value' => ['en' => '', 'bn' => '']],
            ['key' => 'slider_image_3', 'type' => 'image', 'value' => ['en' => '', 'bn' => '']],
            ['key' => 'slider_image_4', 'type' => 'image', 'value' => ['en' => '', 'bn' => '']],
            ['key' => 'slider_image_5', 'type' => 'image', 'value' => ['en' => '', 'bn' => '']],
        ];

        foreach ($items as $item) {
            FrontendContent::firstOrCreate(
                ['section' => 'hero', 'key' => $item['key']],
                ['type' => $item['type'], 'value' => $item['value']]
            );
        }
    }

    public function down(): void
    {
        FrontendContent::where('section', 'hero')
            ->whereIn('key', ['hero_mode', 'slider_image_1', 'slider_image_2', 'slider_image_3', 'slider_image_4', 'slider_image_5'])
            ->delete();
    }
};
