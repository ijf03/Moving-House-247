<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoicesFixture
 */
class InvoicesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'invoice_id' => 1,
                'booking_id' => 1,
                'customer_id' => 1,
                'stripe_invoice_id' => 'Lorem ipsum dolor sit amet',
                'invoice_url' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor sit amet',
                'subtotal_cents' => 1,
                'total_cents' => 1,
                'sent_at' => '2026-04-19 06:58:52',
                'paid_at' => '2026-04-19 06:58:52',
                'created' => '2026-04-19 06:58:52',
                'modified' => '2026-04-19 06:58:52',
            ],
        ];
        parent::init();
    }
}
