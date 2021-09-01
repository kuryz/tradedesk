<?php Slave::section('shared.userheader', 'TraderDesk | Deposit') ?>

<style>

</style>
    <main class="main">
        <div class="greetings">
            <h3>Your Deposits</h3>    
        </div>

        <section class="deposit-box">
            <!-- <ul class="options">
                <li>ID</li>
                <li>Amount</li>
                <li>Payment Mode</li>
                <li>Status</li>
                <li>Date Created</li>
            </ul>
            <div class="info">
                <li class="info-box">1</li>
                <li class="info-box">100.00</li>
                <li class="info-box">BTC</li>
                <li class="info-box">success</li>
                <li class="info-box">8/31/2021</li>
            </div>
            <div class="info">
                <li class="info-box">12</li>
                <li class="info-box">100.00</li>
                <li class="info-box">BTC</li>
                <li class="info-box">success</li>
                <li class="info-box">8/31/2021</li>
            </div> -->
            <table>
			  <thead>
			    <tr>
			      <th scope="col">ID</th>
			      <th scope="col">Amount</th>
			      <th scope="col">Payment Mode</th>
			      <th scope="col">Status</th>
			      <th scope="col">Period</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <td data-label="Account">3412</td>
			      <td data-label="Amount">$1,190</td>
			      <td data-label="Amount">BTC</td>
			      <td data-label="Due Date">success</td>
			      <td data-label="Period">03/31/2016</td>
			    </tr>
			    <tr>
			      <td scope="row" data-label="Account">6076</td>
			      <td data-label="Amount">$1,190</td>
			      <td data-label="Amount">BTC</td>
			      <td data-label="Due Date">success</td>
			      <td data-label="Period">03/31/2016</td>
			    </tr>
			    <tr>
			      <td scope="row" data-label="Account">AMEX</td>
			      <td data-label="Amount">$1,190</td>
			      <td data-label="Amount">BTC</td>
			      <td data-label="Due Date">success</td>
			      <td data-label="Period">03/31/2016</td>
			    </tr>
			    <tr>
			      <td scope="row" data-label="Acount">3412</td>
			      <td data-label="Amount">$1,190</td>
			      <td data-label="Amount">BTC</td>
			      <td data-label="Due Date">success</td>
			      <td data-label="Period">03/31/2016</td>
			    </tr>
			  </tbody>
			</table>
        </section>
    </main>

<?php Slave::section('shared.userfooter'); ?>