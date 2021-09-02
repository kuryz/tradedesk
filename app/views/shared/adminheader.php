
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=(!is_null($title)) ? $title : 'TradeWell'?></title>
    <link rel="stylesheet" href="<?=SITE_URL?>styles/admin.css">
    <link rel="stylesheet" href="<?=SITE_URL?>styles/table.css">
</head>
<body>
    
    <header>
        <a href="<?=SITE_URL?>"><h3>Trader<span>Desk</span></h3></a>
        <div class="dash-holder">
            <a href="<?=SITE_URL?>admin-dashboard" style="color: tomato;">Dashboard</a>
             <a href="<?=SITE_URL?>logout" style="color: #bebaba;">Logout</a>
            <a href="<?=SITE_URL?>settings"><img src="icons/wrench.svg" alt="settings" width="22px" height="22px"></a> 
            <a href="users.html"><img src="icons/user-circle - deactive.svg" alt="user" width="32px" height="32px"></a> 
        </div>
    </header>