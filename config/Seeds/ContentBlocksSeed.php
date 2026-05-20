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
                    'parent' => 'Home Page Main Content',
                    'label' => 'Website Title (Main)',
                    'description' => 'Shown on the home page as the main title',
                    'slug' => 'website-title-main',
                    'type' => 'text',
                    'value' => 'Move done right,',
            ],
            [
                    'parent' => 'Home Page Main Content',
                    'label' => 'Website Title (Coloured)',
                    'description' => 'Shown on the home page as the main title (coloured)',
                    'slug' => 'website-title-main-coloured',
                    'type' => 'text',
                    'value' => 'any time of day.',
            ],
            [
                    'parent' => 'Home Page Main Content',
                    'label' => 'Main page description',
                    'description' => 'Shown on the homepage, under the main website title',
                    'slug' => 'main-page-description',
                    'type' => 'text',
                    'value' => 'Trusted local removals and storage solutions. Get a fast online quote and book your move in minutes.
                No hold music, no guesswork.',
            ],
            [
                'parent' => 'Home Page Statistics',
                'label' => 'Statistics 1 - On-time arrival',
                'description' => 'Shown in the first row of the main statistics on the home page.',
                'slug' => 'hero-stat-first',
                'type'=> 'text',
                'value' => '98%',
            ],
            [
                'parent' => 'Home Page Statistics',
                'label' => 'Statistics 1 Label - On-time arrival',
                'description' => 'Shown in the first row of the main statistics on the home page.',
                'slug' => 'hero-label-first',
                'type'=> 'text',
                'value' => 'On-time arrival',
            ],
            [
                'parent' => 'Home Page Statistics',
                'label' => 'Statistics 2 - 5-star reviews',
                'description' => 'Shown in the second row of the main statistics on the home page.',
                'slug' => 'hero-stat-second',
                'type'=> 'text',
                'value' => '4.9/5',
            ],
            [
                'parent' => 'Home Page Statistics',
                'label' => 'Statistics 2 Label -5-star reviews',
                'description' => 'Shown in the second row of the main statistics on the home page.',
                'slug' => 'hero-label-second',
                'type'=> 'text',
                'value' => '5-star reviews',
            ],
            [
                'parent' => 'Home Page Statistics',
                'label' => 'Statistics 3 - Moves Completed',
                'description' => 'Shown in the third row of the main statistics on the home page.',
                'slug' => 'hero-stat-third',
                'type'=> 'text',
                'value' => '10,000+',
            ],
            [
                'parent' => 'Home Page Statistics',
                'label' => 'Statistics 3 Label - Moves Completed',
                'description' => 'Shown in the third row of the main statistics on the home page.',
                'slug' => 'hero-label-third',
                'type'=> 'text',
                'value' => 'Moves Completed',
            ],

            [
                'parent' => 'Services (Home)',
                'label' => 'Services (Title)',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'services-title',
                'type'=> 'text',
                'value' =>  'Our Services',
            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Services (Subtitle)',
                'description' => 'Shown on the home page under the service title in the services section ',
                'slug' => 'services-subtitle',
                'type'=> 'text',
                'value' => 'Whatever your move looks it, we have a solution to fit.'
            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Relocation Service Tag Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'removal-tag',
                'type'=> 'text',
                'value' => 'Removals',
            ],

            [
                'parent' => 'Services (Home)',
                'label' => 'Relocation Service Name Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'removal-name',
                'type'=> 'text',
                'value' => 'Relocation',
            ],
            [
                'parent' => 'Services (Home)',
                'label' => ' Relocation Service Description Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'removal-description',
                'type'=> 'text',
                'value' => 'Full-service home and apartment moves, planned and executed by trained crews.',
            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Transport Service Tag Card',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'transport-tag',
                'type'=> 'text',
                'value' => 'Transport',

            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Transport Service Name Card',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'transport-name',
                'type'=> 'text',
                'value' => 'Moving Your Belongings',

            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Transport Service Description Card',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'transport-description',
                'type'=> 'text',
                'value' => 'Careful handling of your possessions from packing to delivery, every step covered.',

            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Storage Service Tag Card',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'storage-tag',
                'type'=> 'text',
                'value' => 'Storage',
            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Storage Service Name Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'storage-name',
                'type'=> 'text',
                'value' => 'Storage Solutions',
            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Storage Service Description Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'storage-description',
                'type'=> 'text',
                'value' => 'Short and long-term secure storage when you need extra time between properties.',
            ],

            [
                'parent' => 'Services (Home)',
                'label' => 'Furniture Service Tag Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'furniture-tag',
                'type'=> 'text',
                'value' => 'Furniture',
            ],
            [
                'parent' => 'Services (Home)',
                'label' => 'Furniture Service Name Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'furniture-name',
                'type'=> 'text',
                'value' => 'Furniture &amp; Item Removal',
            ],

            [
                'parent' => 'Services (Home)',
                'label' => 'Furniture Service Description Card',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'furniture-description',
                'type'=> 'text',
                'value' => 'Single items, large furniture, or full clear-outs, we handle the heavy lifting.',
            ],
            [
                'parent' => 'Booking (Home)',
                'label' => 'Booking (Title)',
                'description' => 'Shown on the home page in the booking section ',
                'slug' => 'booking-title',
                'type'=> 'text',
                'value' =>'Booking is Simple',
            ],
            [
                'parent' => 'Booking (Home)',
                'label' => 'Booking (Subtitle)',
                'description' => 'Shown on the home page in the booking section ',
                'slug' => 'booking-subtitle',
                'type'=> 'text',
                'value' => 'Three straightforward steps from quote to move-in day.',
            ],
            [
                'parent' => 'Booking (Home)',
                'label' => 'First Step Booking Title Card',
                'description' => 'Shown on the home page in the booking section',
                'slug' => 'first-booking-title-card',
                'type'=> 'text',
                'value' => 'Request a quote',
            ],
            [
                'parent' => 'Booking (Home)',
                'label' => 'First Step Booking Description Card',
                'description' => 'Shown on the home page in the booking section',
                'slug' => 'first-booking-description-card',
                'type'=> 'text',
                'value' => 'Tell us about your move with our quick online form. No phone calls needed',
            ],
            [
                'parent' => 'Booking (Home)',
                'label' => 'Second Step Booking Title Card',
                'description' => 'Shown on the home page in the booking section ',
                'slug' => 'second-booking-title-card',
                'type'=> 'text',
                'value' => 'Confirm your booking',
            ],

            [
                'parent' => 'Booking (Home)',
                'label' => 'Second Step Booking Description Card',
                'description' => 'Shown on the home page in the booking section ',
                'slug' => 'second-booking-description-card',
                'type'=> 'text',
                'value' => 'We confirm date, time, crew size and pricing all in writing, no surprises.',
            ],
            [
                'parent' => 'Booking (Home)',
                'label' => 'Third Step Booking Title Card',
                'description' => 'Shown on the home page in the booking section ',
                'slug' => 'third-booking-title-card',
                'type'=> 'text',
                'value'=> 'Move with ease',
            ],
            [
                'parent' => 'Booking (Home)',
                'label' => 'Third Step Booking Description Card',
                'description' => 'Shown on the home page in the booking section ',
                'slug' => 'third-booking-description-card',
                'type'=> 'text',
                'value' => 'Our team arrives on time, handles the work, and gets you settled in stress-free.',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Logo (Navigation Bar)',
                'description' => 'Shown in the navigation bar for staff and customer',
                'slug' => 'logo',
                'type' => 'image',
                'value' => 'company-logo.png',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Main Title (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'title-footer',
                'type' => 'text',
                'value' => 'Get your free quote today',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Subtitle (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'subtitle-footer',
                'type'=> 'text',
                'value' => 'Most quotes returned within the same day.',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Company name (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'company-name-footer',
                'type'=> 'text',
                'value' => 'Moving House 24/7',
            ],
            [
                    'parent' => 'Footer',
                    'label' => 'Company description (Footer)',
                    'description' => 'Shown in the footer of every pages for staff and customer.',
                    'slug' => 'company-description-footer',
                    'type'=> 'text',
                    'value' => 'Reliable removals &amp; storage across Victoria, any time of day.',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Title service description (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'title-service-description-footer',
                'type'=> 'text',
                'value' => 'Trust',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Service Description (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'service-description-footer',
                'type'=> 'text',
                'value' => 'Fully insured, professionally trained crews. Transparent quotes, no hidden fees.',
            ],
            [
            'parent' => 'Footer',
            'label' => 'Phone Number (Footer)',
            'description' => 'Shown in the footer of every pages for staff and customer.',
            'slug' => 'phone-contact-footer',
            'type' => 'text',
                'value' => '0412 345 678',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Email (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'email-contact-footer',
                'type' => 'text',
                'value' => 'hello@movinghouse247.com.au',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Address (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'address-footer',
                'type' => 'text',
                'value' => 'Victoria, Australia',
            ],
            [
                'parent' => 'Footer',
                'label' => 'Logo (Footer)',
                'description' => 'Shown in the footer of every pages for staff and customer.',
                'slug' => 'logo-footer',
                'type'=> 'image',
                'value' => 'company-logo.png',
            ],
        ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
