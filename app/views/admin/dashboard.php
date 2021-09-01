<?php Slave::section('shared.adminheader', 'TraderDesk | Dashboard') ?>

    <main class="main">
        <div class="greetings">
            <h3>Welcome, <?=ucwords($data->user->username)?>!</h3>
            <a href="<?=SITE_URL?>manage-deposits">Manage Deposits</a>
            <a href="<?=SITE_URL?>manage-withdrawals">Manage Withdrawal</a>
            <a href="<?=SITE_URL?>investments">Investment Plan</a>
        </div>
        <section class="banner">
            <div class="banner-box">
                <img src="icons/depo.png" alt="total Deposit" width="64px" height="64px">
                <div class="text">
                    <h3>Total Deposit</h3>
                    <p>$0</p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/pend.png" alt="Pending Deposit" width="64px" height="64px">
                <div class="text">
                    <h3>Pending Deposit</h3>
                    <p>$0</p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/user.png" alt="total Users" width="64px" height="64px">
                <div class="text">
                    <h3>Total Users</h3>
                    <p><?=$data->totalusers?></p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/active.png" alt="Active Users" width="64px" height="64px">
                <div class="text">
                    <h3>Active Users</h3>
                    <p><?=$data->activeusers?></p>
                </div>
            </div>

            <div class="banner-box">
                <img src="icons/block.png" alt="Blocked Users" width="64px" height="64px">
                <div class="text">
                    <h3>Blocked Users</h3>
                    <p><?=$data->blockusers?></p>
                </div>
            </div>
        </section>

        <section class="graph">

        </section>
    </main>

<?php Slave::section('shared.userfooter'); ?>