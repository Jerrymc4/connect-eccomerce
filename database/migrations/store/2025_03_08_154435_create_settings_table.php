<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Category of settings (e.g., 'theme', 'payment', 'shipping', 'notifications')
            $table->string('group')->index();
            
            // Setting key
            $table->string('key');
            
            // Setting value - can be any type
            $table->json('value')->nullable();
            
            // For easy filtering of multiple related settings
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            
            // For ordering settings in admin panels
            $table->integer('order')->default(0);
            
            // Timestamps
            $table->timestamps();
            
            // Make the combination of group + key unique
            $table->unique(['group', 'key']);
        });
        
        // Add default settings on first migration
        $this->seedDefaultSettings();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
    
    /**
     * Seed default settings.
     */
    private function seedDefaultSettings(): void
    {
        $settings = [
            // Theme settings
            [
                'group' => 'theme',
                'key' => 'name',
                'value' => json_encode('default'),
                'display_name' => 'Theme',
                'description' => 'Current theme template',
                'order' => 1
            ],
            [
                'group' => 'theme',
                'key' => 'primary_color',
                'value' => json_encode('#3490dc'),
                'display_name' => 'Primary Color',
                'description' => 'Main brand color',
                'order' => 2
            ],
            [
                'group' => 'theme',
                'key' => 'secondary_color',
                'value' => json_encode('#ffed4a'),
                'display_name' => 'Secondary Color',
                'description' => 'Accent color for highlights',
                'order' => 3
            ],
            [
                'group' => 'theme',
                'key' => 'font_family',
                'value' => json_encode('Inter, sans-serif'),
                'display_name' => 'Font Family',
                'description' => 'Main font for the store',
                'order' => 4
            ],
            [
                'group' => 'theme',
                'key' => 'button_style',
                'value' => json_encode('rounded'),
                'display_name' => 'Button Style',
                'description' => 'Button corner style (rounded, sharp)',
                'order' => 5
            ],
            [
                'group' => 'theme',
                'key' => 'layout',
                'value' => json_encode('standard'),
                'display_name' => 'Layout',
                'description' => 'Store layout style',
                'order' => 6
            ],
            
            // General store settings
            [
                'group' => 'store',
                'key' => 'show_footer',
                'value' => json_encode(true),
                'display_name' => 'Show Footer',
                'description' => 'Display the footer section',
                'order' => 1
            ],
            [
                'group' => 'store',
                'key' => 'footer_text',
                'value' => json_encode(''),
                'display_name' => 'Footer Text',
                'description' => 'Custom text for footer',
                'order' => 2
            ],
            [
                'group' => 'store',
                'key' => 'show_social_media',
                'value' => json_encode(true),
                'display_name' => 'Show Social Media',
                'description' => 'Display social media links',
                'order' => 3
            ],
            [
                'group' => 'store',
                'key' => 'social_media_links',
                'value' => json_encode([
                    'facebook' => '',
                    'twitter' => '',
                    'instagram' => '',
                    'youtube' => '',
                ]),
                'display_name' => 'Social Media Links',
                'description' => 'Social media profile URLs',
                'order' => 4
            ],
            
            // Payment settings
            [
                'group' => 'payment',
                'key' => 'currency',
                'value' => json_encode('USD'),
                'display_name' => 'Currency',
                'description' => 'Store currency',
                'order' => 1
            ],
            [
                'group' => 'payment',
                'key' => 'currency_symbol',
                'value' => json_encode('$'),
                'display_name' => 'Currency Symbol',
                'description' => 'Currency symbol for display',
                'order' => 2
            ],
            
            // Regional settings
            [
                'group' => 'regional',
                'key' => 'timezone',
                'value' => json_encode('UTC'),
                'display_name' => 'Timezone',
                'description' => 'Store timezone',
                'order' => 1
            ],
        ];
        
        // Insert default settings
        DB::table('settings')->insert($settings);
    }
};
