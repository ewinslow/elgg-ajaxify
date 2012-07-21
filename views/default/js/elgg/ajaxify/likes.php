(function($) {
    function showLikeHideUnlike($menu) {
        $menu.find('.elgg-menu-item-like').removeClass('hidden');
        $menu.find('.elgg-menu-item-unlike').addClass('hidden');
    }
   
    function showUnlikeHideLike($menu) {
        $menu.find('.elgg-menu-item-unlike').removeClass('hidden');
        $menu.find('.elgg-menu-item-like').addClass('hidden');
    }
   
    // Handles clicking the like button.
    $('.elgg-menu-item-like a').live('click', function() {
        var $menu = $(this).closest('.elgg-menu');
        
        // Be optimistic about success
        showUnlikeHideLike($menu);
        
        // Send the ajax request
        elgg.action($(this).attr('href'), {
            error: function() {
                // Something went wrong, so undo the optimistic changes
                showLikeHideUnlike($menu);
            }
        }); 
        
        // Don't want to actually click the link
        return false;
    });
   
    // Handles clicking the unlike button
    $('.elgg-menu-item-unlike a').live('click', function() {
        var $menu = $(this).closest('.elgg-menu');
        
        // Be optimistic about success
        showLikeHideUnlike($menu);
        
        // Send the ajax request
        console.log($menu);
        elgg.action($(this).attr('href'), {
            error: function() {
                // Something went wrong, so undo the optimistic changes
                showUnlikeHideLike($menu);
            }
        }); 
        
        // Don't want to actually click the link
        return false;
    });
})(jQuery);