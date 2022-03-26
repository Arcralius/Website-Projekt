function activateMenu() {
    var current_page_URL = location.href;

    $(".navbar-nav a").each(function () {
        var target_URL = $(this).prop("href");
        if (target_URL === current_page_URL) {
            $('nav a').parents('li, ul').removeClass('active');
            $(this).parent('li').addClass('active');
            return false;
        }
    });
}

function addToCartListener() {
    var pid = $(this).val();
    var aurl = 'ajaxProcessing.php';
    $.ajax({
        url: aurl,
        type: 'POST',
        data: { 'addtocart': pid },
        success: function (result) {
            updateNavCart(Number(result));
        }
    });
}

function removeFromCartListener() {
    var pid = $(this).val();
    var aurl = 'ajaxProcessing.php';
    $.ajax({
        url: aurl,
        type: 'POST',
        data: { 'removefromcart': pid },
        success: function (result) {
            updateNavCart(Number(result));
        }
    });
}

function setProdQty() {
    var aurl = 'ajaxProcessing.php';
    var qty = $(this).val();
    $.ajax({
        url: aurl,
        type: 'POST',
        data: { 'setprodqty': qty },
        success: function (result) {
            showCart();
        }
    });
}
function updateNavCart(count) {
    if (!isNaN(count)) {
        $('.cartitems').html(count);
        showCart();
    }
}

function showCart() {
    var aurl = 'ajaxProcessing.php';
    $.ajax({
        url: aurl,
        type: 'POST',
        data: { 'getcart': '' },
        success: function (result) {
            $(".carttable").html(result);
            $('[name="addtocart"]').click(addToCartListener);
            $('[name="removefromcart"]').click(removeFromCartListener);
            $('[name="prod_qty"]').change(setProdQty);
        }
    });
}

function createCookie(name, value, seconds) {
    if (seconds) {
        var date = new Date();
        date.setTime(date.getTime() + (seconds * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}

function modal() {
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
      })
}

$(document).ready(function () {
    activateMenu();
    showCart();
    modal();
    $("#discount").change(function() {
        $("#discountval").html(this.value);
    });
});