function activateMenu() 
{
    var current_page_URL = location.href;
    
    $(".navbar-nav a").each(function()
    {
        var target_URL = $(this).prop("href"); 
        if (target_URL === current_page_URL)
        {
            $('nav a').parents('li, ul').removeClass('active'); 
            $(this).parent('li').addClass('active'); 
            return false;
        }
    });
}

$( document ).ready(function() {
    activateMenu();
});