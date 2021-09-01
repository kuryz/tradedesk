<?php Slave::section('shared.adminheader', 'TraderDesk | Investment') ?>

<style>
/*dashboard styles */

.modal{
    width:90%;
    display: none;
    flex-direction: column;
    align-items: flex-start;
    box-shadow: 0px 0px 2px 2px rgb(170, 170, 170);
    padding:1rem;
    border-radius: .2rem;
    background-color: #fff;
    position: absolute;
    z-index: 3;
    top:5%;
    animation: fade .3s ease-in-out;
}

@keyframes fade{
    from{
        opacity: 0;
    }

    to{
        opacity: 1;
    }
}

.modal .modal-form button{
    width:10rem;
    height:2.5rem;
    background-color: tomato;
    color:#fff;
    border-radius: .4rem;
    border:1px solid tomato;
    transition: background-color .4s ease;
    cursor: pointer;
    font-size: .95rem;
    font-weight:300;
}

.modal .modal-form button:hover{
    background-color: #fff;
    color:tomato;
    border:1px solid #fff;
}

.modal .modal-form,.modal .modal-form .form-wrapper{
    display: flex;
    flex-direction: column;
    width: 100%;
    align-items: flex-start;
}

.modal .modal-form .form-wrapper label{
    width:100%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: .8rem;
    color:#333;
}

.modal .modal-form .form-wrapper label h3{
    font-weight: 300;
    font-size: 1.2rem;
    color: #222;
}


.modal .modal-form .form-wrapper label input{
    width:100%;
    height: 2rem;
}

.card{
    width:100%;
    /*height: 600px;*/
    position: relative;
    top: 100px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.card-box{
    width:100%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.modal .modal-form #close{
    font-weight: 700;
    font-size: 1.5rem;
    cursor: pointer;
    color: red;
}

.modal .modal-form .modal-text{
    display: flex;
    align-items: center;
    width:300px;
    justify-content: space-between;
}

@media screen and (min-width:500px){
    .main .banner{
        display: grid;
        grid-template-columns: repeat(2,1fr);
        width:100%;
        gap:1rem;
    }
}

@media screen and (min-width:600px){
    .main .greetings{
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }
    
    .card{
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap:1rem;
        place-items: center;
    }

    .main .greetings a{
        margin-top: 0;
    }

    .main .settings{
        width:400px;
    }

    .main .new{
        justify-content: center;
    }

    .main .modal{
        width:450px;
    }
}

@media screen and (min-width:800px){
    .main .greetings{
        width:700px;
        margin:1.5rem auto 3rem auto;
    }

    .card{
        grid-template-columns: repeat(3,1fr);
        width:400px;
        margin:1rem auto;
    }
}
.main .new button{
    width:10rem;
    height:2.5rem;
    border-radius: .4rem;
    cursor: pointer;
    background-color:#fff;
    box-shadow:1px 1px 2px 2px rgb(141, 141, 141);
    border:1px solid #fff;
    transition: background-color .4s ease;
    font-size: 1rem;
    font-weight:300;
    margin:1rem 0;
}

.main .new button:hover{
    background-color: tomato;
    border:1px solid tomato;
    color:#fff;
}
</style>


    <main class="main">
        <div class="greetings">
            <h3>Welcome, <?=ucwords($data->user->username)?>!</h3>    
        </div>
        
        <section class="new">
            <button id="button">Add New Plan &plus;</button>
        </section>
		<div class="error" style="padding-left: 233px;padding-right: 233px;">
            <?php show_errors(); ?>
            <?php show_status(); ?>
        </div>
        <section class="modal" id="modal">
            <form action="<?=SITE_URL?>post-invest" method="post" class="modal-form">
                <div class="modal-text">
                    <h3>Enter A Plan</h3>
                    <p id="close">&times;</p>
                </div>
                <div class="form-wrapper">
                    <label for="pName">Plan Name
                        <input type="text" name="title" id="pName">
                    </label>
    
                    <label for="pPrice">Plan Price
                        <input type="number" name="amount" id="pPrice">
                    </label>
    
                    <label for="pMaxPrice">Plan Maximum Price
                        <input type="number" name="max_amount" id="pMaxPrice">
                    </label>
    
                    <!-- <label for="pMinPrice">Plan Minimum Price
                        <input type="number" name="pMinPrice" id="pMinPrice">
                    </label>
    
                    <label for="maxReturn">Plan Maximum Return
                        <input type="number" name="pMaxReturn" id="pMaxReturn">
                    </label> -->
    
                    <label for="minReturn">Plan Return of Investment
                        <input type="number" name="return_of_investment" id="pMinReturn">
                    </label>
                </div>
                <?=crsf_token()?>
                <button type="submit">Add</button>
            </form>
        </section>

        <section class="card">
            <?php foreach($data->plans as $plan): ?>
        	<div class="card-box">
        		<p><?=$plan->title?></p>
	           	<p><?=$plan->amount?></p>
	           	<p>to earn</p>
	           	<p><?=$plan->max_price?></p>
	           	<p><?=$plan->roi?></p>
        	</div>
            <?php endforeach; ?>
        </section>
    </main>


<footer>
       <p> TraderDesk &copy;All Rights Reserved.</p>
    </footer>
</body>
<script>
    function modal(){
        let button = document.getElementById('button');
        let modals = document.querySelector('#modal');
        let main = document.querySelector('.greetings');
        button.addEventListener('click', ()=> {
            modals.style.display = 'flex';
            main.style.opacity = '.5';
        })

        let close = document.querySelector('#close');
        close.addEventListener('click', ()=>{
            modals.style.display = 'none';
            main.style.opacity = '1';
        })
    }
    modal();
</script>
</html>