<?php
$this->assign('title', 'Moving House 24/7');
?>

<main class="landing-page">
    <section class="hero py-5">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-4 fw-bold">Fast, reliable removals across Melbourne</h1>
                <h2 class="h4 mb-3">Moving made simple, safe, and stress-free</h2>
                <p class="lead mx-auto" style="max-width: 750px;">
                    From small apartment moves to full house relocations,
                    Moving House 24/7 helps you move with confidence. Get a
                    fast quote, choose a time that suits you, and let our
                    experienced team handle the heavy lifting.
                </p>

                <div class="hero-buttons d-flex justify-content-center gap-3 flex-wrap mt-4">
                    <?= $this->Html->link(
                        'Book Your Move!',
                        ['controller' => 'ContactForms', 'action' => 'add'],
                        ['class' => 'btn btn-primary btn-lg']
                    ) ?>
                    <a class="btn btn-outline-secondary btn-lg" href="#">View Services</a>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">How It Works</h2>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 card-title">1. Request a quote</h3>
                            <p class="card-text">
                                Tell us where you’re moving from, where you’re going,
                                and your preferred date.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 card-title">2. Confirm your booking</h3>
                            <p class="card-text">
                                We’ll provide a clear quote and help lock in a moving
                                time that suits you.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 card-title">3. Move with ease</h3>
                            <p class="card-text">
                                Our team arrives ready to pack, lift, transport, and
                                deliver your items safely.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
