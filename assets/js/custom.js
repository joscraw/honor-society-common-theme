(function($){

    $('.js-tribe-button--no-rsvp').click(function(){

        debugger;


        $('.js-tribe-tickets-order_status-row').find('select[name="attendee[order_status]"]').val("no");
        $(event.target).unbind('click');
        $(event.target).prop("type", "submit").click();
    });

    $('.js-tribe-button--rsvp').click(function(){

        $('.js-tribe-tickets-order_status-row').find('select[name="attendee[order_status]"]').val("yes");
        $(event.target).unbind('click');
        $(event.target).prop("type", "submit").click();
    });

})(jQuery);