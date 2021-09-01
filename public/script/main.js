function toggle(){
    let toggleBtn = false;
    let container = document.getElementById('container');
    let menu = document.getElementById('toggle');
    let navlinks = document.querySelectorAll('#container .list li');

    menu.addEventListener('click', ()=>{
        if(toggleBtn === false){
            container.style.height = '200px';
            toggleBtn = true;
        }
        else if(toggleBtn === true){
            container.style.height = '0';
            toggleBtn = false;
        }
    }) 
}
toggle();