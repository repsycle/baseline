// Unhide some things when their content changes
/* Settings.php */ 
$('input[name="user-email"]').focus(function(event){
        $("#emailWarning").show();       
});
 
$('input[name="user-password"]').focus(function(event){
        $("#passwordWarning").show();       
});
/* Settings.php */




/* User */
$('.iHide').hide(); // want to hide it myself
// Otherwise lets check for changes and then post them through
$('form.users_update_group').change(function(event) {
   $(this).submit();
});
$('form.users_update_email').change(function(event) {
   $(this).submit();
});
$('form.users_update_password').change(function(event) {
   $(this).submit();
});
$('form.users_update_activation').change(function(event) {
   $(this).submit();
});
/* User */




/* GENERAL */

// This function will set the scrolling so that when a page refreshes to the same screen that your offet is the same
function page_scroller()
{
        var pageOffset = $(document).scrollTop();
        set_cookie("scroll", pageOffset);
}

if (pageOffsetCookie != 'null')
{    
        $(document).scrollTop(pageOffsetCookie);
}

$(window).scroll(function(event){       
        page_scroller()  
}); 
/* GENERAL */