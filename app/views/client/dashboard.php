<?php Slave::section('shared.userheader', 'TraderDesk | Dashboard') ?>

    <main>
        <nav class="greetings">
            <h3>Welcome, <?=ucwords($data->user->username)?>!</h3>
            <a href="<?=SITE_URL?>user-deposit">Deposits</a>
            <a href="withdrawalinfo.html">Withdrawal Info</a>
        </nav>
        <section class="banner">
            <div class="banner-box">
                <img src="icons/depo.png" alt="deposited" width="64px" height="64px">
                <div class="text">
                    <h3>Deposited</h3>
                    <p>$0</p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/pend.png" alt="profit" width="64px" height="64px">
                <div class="text">
                    <h3>Profit</h3>
                    <p>$0</p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/balance.svg" alt="balance" width="64px" height="64px">
                <div class="text">
                    <h3>Balance</h3>
                    <p>0</p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/Total.svg" alt="total" width="64px" height="64px">
                <div class="text">
                    <h3>Total Packages</h3>
                    <p>0</p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/active.svg" alt="active" width="64px" height="64px">
                <div class="text">
                    <h3>Active Packages</h3>
                    <p>0</p>
                </div>
            </div>
        </section>

        <section class="graph">    
            <section class="price-box">
                <div class="box">
                    <div class="text-container">
                        <h3>Deposits</h3>
                        <h2>$0</h2>
                    </div>
                    <div class="cta">
                        <div class="dollar">
                            <h2>&dollar;</h2>
                        </div>
                        <button>Deposit</button>
                    </div>
                </div>
        
                <div class="box">
                    <div class="text-container">
                        <h3>Withdrawal</h3>
                        <h2>$0</h2>
                    </div>
                    <div class="cta">
                        <div class="dollar">
                            <h2>&dollar;</h2>
                        </div>
                        <button>Withdraw</button>
                    </div>
                </div>
            </section>
        </section>
    </main>

   <?php Slave::section('shared.userfooter'); ?>