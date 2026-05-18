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
                'parent' => 'home',
                'label' => 'Statistics 1 - On-time arrival',
                'description' => 'Shown in the first row of the main statistics on the home page.',
                'slug' => 'hero-stat-ontime',
                'type'=> 'html',
                'value' => '<span>On-time arrival</span>
                                <strong>98%</strong>',
            ],
            [
                'parent' => 'home',
                'label' => 'Statistics 2 - 5-star reviews',
                'description' => 'Shown in the second row of the main statistics on the home page.',
                'slug' => 'hero-stat-reviews',
                'type'=> 'html',
                'value' => ' <span>5-star reviews</span>
                                <strong>4.9/5</strong>',
            ],
            [
                'parent' => 'home',
                'label' => 'Statistics 3 - Moves Completed',
                'description' => 'Shown in the second row of the hero statistics panel.',
                'slug' => 'hero-stat-moves',
                'type'=> 'html',
                'value' => '<span>Moves Completed</span>
                <strong>10,000+</strong>',
            ],
            [

                'parent' => 'home',
                'label' => 'Website Title (Main)',
                'description' => 'Shown on the home page, as well as any tabs in the users browser.',
                'slug' => 'website-title-main',
                'type' => 'html',
                'value' => 'Move done right,<br><span class="accent">any time of day.</span>',
            ],
            [
                'parent' => 'home',
                'label' => 'Main page description',
                'description' => 'Shown on the homepage, under the main website title',
                'slug' => 'main-page-description',
                'type' => 'text',
                'value' => 'Trusted local removals and storage solutions. Get a fast online quote and book your move in minutes.
                No hold music, no guesswork.',
            ],

            [
                'parent' => 'home',
                'label' => 'Services (Title)',
                'description' => 'Shown on the home page in the services section',
                'slug' => 'services-title',
                'type'=> 'text',
                'value' =>  'Our Services',
            ],
            [
                'parent' => 'home',
                'label' => 'Services (Subtitle)',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'services-subtitle',
                'type'=> 'text',
                'value' => 'Whatever your move looks it, we have a solution to fit.'
            ],
            [
                'parent' => 'home',
                'label' => 'Relocation (Card)',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'removal',
                'type'=> 'html',
                'value' => ' <span class="service-tag">Removals</span>
                        <h3>Relocation</h3>
                        <p>Full-service home and apartment moves, planned and executed by trained crews.</p>',
            ],
            [
                'parent' => 'home',
                'label' => 'Storage (Card)',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'storage',
                'type'=> 'html',
                'value' => '<span class="service-tag">Storage</span>
                        <h3>Storage Solutions</h3>
                        <p>Short and long-term secure storage when you need extra time between properties.</p>',
            ],
            [
                'parent' => 'home',
                'label' => ' Furniture (Card)',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'furniture',
                'type'=> 'html',
                'value' => '<span class="service-tag">Furniture</span>
                        <h3>Furniture &amp; Item Removal</h3>
                        <p>Single items, large furniture, or full clear-outs, we handle the heavy lifting.</p>',

            ],
            [
                'parent' => 'home',
                'label' => 'Transport (Card)',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'transport',
                'type'=> 'html',
                'value' => '<span class="service-tag">Transport</span>
                        <h3>Moving Your Belongings</h3>
                        <p>Careful handling of your possessions from packing to delivery, every step covered.</p>',

            ],
            [
                'parent' => 'home',
                'label' => 'Booking (Title)',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'booking-title',
                'type'=> 'text',
                'value' =>'Booking is Simple',
            ],
            [
                'parent' => 'home',
                'label' => 'Booking (Subtitle)',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'booking-subtitle',
                'type'=> 'text',
                'value' => 'Three straightforward steps from quote to move-in day.',
            ],
            [
                'parent' => 'home',
                'label' => 'First Step Booking Card',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'first-booking-card',
                'type'=> 'html',
                'value' => '<h3>Request a quote</h3>
                        <p>Tell us about your move with our quick online form. No phone calls needed.</p>',
            ],

            [
                'parent' => 'home',
                'label' => 'Second Step Booking Card',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'second-booking-card',
                'type'=> 'html',
                'value' => '<h3>Confirm your booking</h3>
                        <p>We confirm date, time, crew size and pricing all in writing, no surprises.</p>',
            ],
            [
                'parent' => 'home',
                'label' => 'Third Step Booking Card',
                'description' => 'Shown on the home page in the services section ',
                'slug' => 'third-booking-card',
                'type'=> 'html',
                'value'=> '<h3>Move with ease</h3>
                        <p>Our team arrives on time, handles the work, and gets you settled in stress-free.</p>',
            ],
            [
                'parent' => 'global',
                'label' => 'Logo (Navigation Bar)',
                'description' => 'Shown in the centre of the home page, and also in the top corner of all administration pages.',
                'slug' => 'logo',
                'type' => 'image',
                'value' => 'company-logo.png',
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
                'label' => 'Subtitle (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'subtitle-footer',
                'type'=> 'text',
                'value' => 'Most quotes returned within the same day.',
            ],
            [
                'parent' => 'global',
                'label' => 'Company name (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'company-name-footer',
                'type'=> 'html',
                'value' => '<h3 class="mh-footer-brand mb-0">Moving House 24/7</h3>',
            ],
            [
                    'parent' => 'global',
                    'label' => 'Company description (Footer)',
                    'description' => 'Shown in the footer of every pages.',
                    'slug' => 'company-description-footer',
                    'type'=> 'html',
                    'value' => ' <p class="mh-footer-text mb-0">
                        Reliable removals &amp; storage across Victoria, any time of day.
                    </p>',
            ],
            [
                'parent' => 'global',
                'label' => 'Service Description (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'description-footer',
                'type'=> 'html',
                'value' => '<h4 class="mh-footer-heading">Trust</h4>
                    <p class="mh-footer-text mb-0">
                        Fully insured, professionally trained crews. Transparent quotes, no hidden fees.
                    </p>',
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
                'label' => 'Address (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'address-footer',
                'type' => 'text',
                'value' => 'Victoria, Australia',
            ],
            [
                'parent' => 'global',
                'label' => 'Logo (Footer)',
                'description' => 'Shown in the footer of every pages.',
                'slug' => 'logo-footer',
                'type'=> 'image',
                'value' => 'company-logo.png',
            ],
        ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
