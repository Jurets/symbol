$(function() {
	$('.slider_block').cycle({
		fx:     'scrollLeft',
		pager: '#nav',
		speed:    300,
		timeout: 10000
	});
	$('input[placeholder], textarea[placeholder]').placeholder();
	$("select").uniform();


	$('#btnOrderFirst').click(function(){
		$('#order_phone').css('border-color','#AFABA7');
		$('#order_name').css ('border-color','#AFABA7');

		if ($('#order_name').val() == '') {
			$('#order_name').focus();
			$('#order_name').css('border-color','red');
			return;
		}
		if ($('#order_phone').val() == '') {
			$('#order_phone').focus();
			$('#order_phone').css('border-color','red');
			return;
		}
		$('#firstForm').submit();
	});


	$('#btnFastOrder').click(function(){

		// if mistake then return
		$('#fastPhone').css('border-color','#AFABA7');
		$('#fastName').css ('border-color','#AFABA7');

		if ($('#fastName').val() == '') {
			$('#fastName').focus();
			$('#fastName').css('border-color','red');
			return false;
		}
		if ($('#fastPhone').val() == '') {
			$('#fastPhone').focus();
			$('#fastPhone').css('border-color','red');
			return false;
		}

        $.ajax({
            type: "POST",
            data: {name: $('#fastName').val(), phone: $('#fastPhone').val(), url: document.location.href },
            url: "/cart/fast",
            success: function (data) {
                //else show its okay
                $('.modal_txt').show();
                $('#fastName').attr('disabled','disabled');
                $('#fastPhone').attr('disabled','disabled');
                $(this).attr('disabled','disabled');
                $('.fast').hide();
                $('#myModal').fadeOut(6000);
                return false;
            }
        });

        return false;

	});

});

$(function() {
$('.acc_container').hide(); //Hide/close all containers

    //On Click
$('.acc_trigger').click(function(){
    var $this = $(this),
        thisActive = $this.hasClass('active'),
        active;

    // If this one is active, we always just close it.
    if (thisActive) {
        $this.removeClass('active').next().slideUp();
    }
    else {
        // Is there just one active?
        active = $('.acc_trigger.active');
        if (active.length === 1) {
            // Yes, close it
            active.removeClass('active').next().slideUp();
        }

        // Open this one
        $this.addClass('active').next().slideDown();
    }
});
$('.acc_container li a.active').parent().parent().prev().click();

});

/**
 * Add product to cart from list
 * @param data
 * @param textStatus
 * @param jqXHR
 * @param redirect
 */
function processCartResponse(data, textStatus, jqXHR, redirect)
{
	var productErrors = $('#productErrors');
    if(data.errors)
    {
        window.location = redirect
    }else{
    	reloadSmallCart();
        $('#addProduct' + data.productId).addClass('add');
        $('#addProduct' + data.productId).val('добавлен');
        $('.head_basket').addClass('full');
        $("#cart").fadeOut().fadeIn().fadeOut().fadeIn();
    }
}

function reloadSmallCart()
{
	$("#cart").load('/cart/renderSmallCart');
}

function subscribe()
{
    if ($('#subscribeMail').val() != '')
    {
        $.ajax({
            type: "POST",
            data: {email: $('#subscribeMail').val() },
            url: "/users/subscribe",
            success: function (data) {
                if (data != 'ok')
                {
                    $('#subscribeMail').css('border-color','red');
                    $('#subscribeMail').focus();
                }
                else
                {
                    $('#subscribeMail').css('border-color','#d9a062');
                    $('#subscribeButton').addClass('add');
                    $('#subscribeButton').attr('disabled','disabled');
                    $('#subscribeButton').val('OK!');
                    $("#subscribeButton").fadeOut().fadeIn().fadeOut().fadeIn();
                }

            }
        });
    }
    else
    {
        $('#subscribeMail').css('border-color','red');
        $('#subscribeMail').focus();
    }
}