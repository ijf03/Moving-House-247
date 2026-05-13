<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * ContentBlocks seed.
 */
class ContentBlocksSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'parent' => 'global',
                'label' => 'Website Title (Main)',
                'description' => 'Shown on the home page, as well as any tabs in the users browser.',
                'slug' => 'website-title-main',
                'type' => 'text',
                'value' => 'Move done right,',
            ],
            [
                'parent' => 'global',
                'label' => 'Website Title (Accent)',
                'description' => 'Shown on the home page, as well as any tabs in the users browser.',
                'slug' => 'website-title-accent',
                'type' => 'text',
                'value' => 'any time of day.',
            ],
            [
                'parent' => 'global',
                'label' => 'Logo (Navigation Bar)',
                'description' => 'Shown in the centre of the home page, and also in the top corner of all administration pages.',
                'slug' => 'logo',
                'type' => 'image',
            ],
            [
                'parent' => 'global',
                'label' => 'Main Title (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'title-footer',
                'type' => 'text',
                'value' => 'Get your free quote today',
            ],
            [
            'parent' => 'global',
            'label' => 'Phone Number (Footer)',
            'description' => 'Shown in the footer of every pages.',
            'slug' => 'phone-contact-footer',
            'type' => 'text',
                'value' => '0412 345 678',
            ],
            [
                'parent' => 'global',
                'label' => 'Email (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'email-contact-footer',
                'type' => 'text',
                'value' => 'hello@movinghouse247.com.au',
            ],
            [
                'parent' => 'global',
                'label' => 'Logo (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'logo-footer',
                'type'=> 'image',
            ],

            [
                'parent' => 'home',
                'label' => 'Home Page Content',
                'description' => 'The main content shown in the centre of the home page.',
                'slug' => 'home-content',
                'type' => 'html',
                'value' => '<p>Example app showcasing the <code>ugie-cake/cakephp-content-blocks</code> plugin.</p>',
            ]
        ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
