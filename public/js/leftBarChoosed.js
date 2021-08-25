window.location.pathname == '/admin/dashboard' ? document.getElementsByClassName('nav-link')[0].classList.add('active')
: window.location.pathname == '/admin/icons' ? document.getElementsByClassName('nav-link')[1].classList.add('active')
// : window.location.pathname == '/admin/product' ? (document.getElementsByClassName('nav-link')[2].classList.add('active'),document.getElementsByClassName('link-nav-child')[0].classList.add('link-nav-child-active'),document.getElementsByClassName('nav-child')[0].classList.add('nav-child-active'))
: window.location.pathname == '/admin/product' ? (document.getElementsByClassName('nav-link')[2].classList.add('active'))
: null;

function activeDropDownPhieu(){
    document.getElementById('phieuxuatkho').classList.toggle('active');
    document.getElementById('nav-child-Menu-Phieu').classList.toggle('d-none');
    console.log($('#phieuxuatkho').hasClass('active'));

    if($('#phieuxuatkho').hasClass('active') == true){
        document.getElementById('bold-up-phieu').style.transform = 'rotate(180deg)';
    }else{
        document.getElementById('bold-up-phieu').style.transform = 'rotate(0deg)';
    }
}