<?php Slave::section('shared.header', 'TradeWell | login'); ?>
<link rel="stylesheet" href="styles/login.css">
<main>
    <section class="form">
        <div class="img">
            <img src="images/71361-sign-in.gif" alt="sign-in" width="100%">
        </div>
        <h3>Welcome! Please Kindly fill in your details below</h3>
        <div class="error" style="padding-left: 233px;padding-right: 233px;">
        <?php show_status('login'); ?>
        </div>
        <div class="form-wrapper">
            <form action="<?=SITE_URL?>post-login" method="POST">
                <label for="username">
                    <input type="text" placeholder="Enter your Username" id="username" name="username" required>
                </label>

                <label for="password">
                    <input type="password" placeholder="Enter your password" id="password" name="password" required>
                </label>
                <?=crsf_token()?>
                <button type="submit">Submit</button>
            </form>
        </div class="form-wrapper">
        
    </section>
</main>
<?php Slave::section('shared.footer'); ?>  