$(document).ready(function() {

    //419 error
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //pass data from form to jquery, passing this data from jquery to ajax, passing this data to this slug, then it calls the controller function, do all the queries inside then pass back to ajax
    $('#orderby').on('change',function() {
        //alert("hello")
        var orderby = $(this).val();
        var pattern = get_filter("pattern");
        var occasion = get_filter('occasion');
        var color = get_filter('color');
        var sleeve = get_filter('sleeve');
        var material = get_filter('material');
        var slug = $("#slug").val();
        //this.form.submit();

        $.ajax({
            url:slug,
            type: "post",
            data: {pattern:pattern,occasion:occasion,color:color,sleeve:sleeve,material:material,orderby:orderby,slug:slug},
            success: function (data) {
                $('.filter_products').html(data);
            },error:function() {
                alert("Error");
            }
        });
    });

    // Filter on click sort
    $(".pattern,.occasion,.color,.sleeve,.material").on('click',function() {
        //alert(this.className)
        var pattern = get_filter('pattern');
        var occasion = get_filter('occasion');
        var color = get_filter('color');
        var sleeve = get_filter('sleeve');
        var material = get_filter('material');
        var orderby = $('#orderby option:selected').val();
        var slug = $('#slug').val();

        $.ajax({
            url:slug,
            type: "post",
            data: {pattern:pattern,occasion:occasion,color:color,sleeve:sleeve,material:material,orderby:orderby,slug:slug},
            success: function (data) {
                $('.filter_products').html(data);
            },error:function() {
                alert("Error");
            }
        });
    })

    function get_filter(className) {
        var filter = []; 
        $('.'+className+':checked').each(function() {          
            filter.push($(this).val());
        });
        return filter;
    }

    $('#getPrice').on('change',function() {
        var size = $(this).val();
        if (size == "") {
            alert("Please Select a Size");
            return false;
        }
        var product_id = $(this).attr("product-id");

        $.ajax({
            url: '/get-product-price',
            data: {size:size,product_id:product_id},
            type: 'post',
            success: function(resp) {
                if (resp['discount'] > 0) {
                    $(".getAttrPrice").html("RM "+resp['final_price']+"<del class='text-muted'>RM "+resp['product_price']+"</del>");
                }else {
                    $(".getAttrPrice").html("RM "+resp['product_price']);
                }
                
            },error: function() {
                alert("Error");
            }
        });
    });

    // Update Cart Items
    $(document).on('click','.btnItemUpdate',function() {
        var cart_id = $(this).data('cartid');
        if ($(this).hasClass('qtyMinus')) {
            var qty = $(this).prev().val();
            //alert(qty);

            // If less than 1 then remove the item
            if (qty <= 1) {
                alert("Are you sure you want to remove this item?");
                return false;
                /*
                var result = confirm("Are you sure to remove this cart item?");
                if (result) {
                    $.ajax({
                        data: {cart_id:cart_id},
                        url: '/remove-cart-item',
                        type: 'post',
                        success:function(resp) {
                            $("#AjaxCartItems").html(resp.view);
                        },error:function() {
                            alert("Error");
                        }
                    });
                }*/
            }else {
                new_qty = parseInt(qty) - 1;
            }
        }
        if ($(this).hasClass('qtyPlus')) {
            var qty = $(this).prev().prev().val();
            //alert(qty); 
            new_qty = parseInt(qty) + 1;    
            
        }
        //alert(new_qty);
        
        //alert(cart_id);

        $.ajax({
            data: {cart_id:cart_id,qty:new_qty},
            url: '/update-qty-cart-item',
            type: 'post',
            success:function(resp) {
                //alert(resp.status);
                if (resp.status==false) {
                    alert(resp.message);
                }
                //alert(resp.totalCartItems);
                $(".totalCartItems").html(resp.totalCartItems);
                $("#AjaxCartItems").html(resp.view);
            },error:function() {
                alert("Error");
            }
        });
    });

    // Remove Cart Item
    $(document).on('click','.btnItemRemove',function() {
        
        //alert(new_qty);
        var cart_id = $(this).data('cartid');
        //alert(cart_id);
        var result = confirm("Are you sure to remove this cart item?");
        if (result) {
            $.ajax({
                data: {cart_id:cart_id},
                url: '/remove-cart-item',
                type: 'post',
                success:function(resp) {
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#AjaxCartItems").html(resp.view);
                },error:function() {
                    alert("Error");
                }
            });
        }
    });

    // validate signup form on keyup and submit
    $("#registerForm").validate({
        rules: {
            mobile: {
                minlength: 10
            },
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            topic: {
                required: "#newsletter:checked",
                minlength: 2
            },
            agree: "required"
        },
        messages: {

            mobile: {
                required: "Please enter a username",
                minlength: "Your mobile number must consist of at least 10 numbers"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy",
            topic: "Please select at least 2 topics"
        }
    });

    $('document').on('click','.addressRemove',function() {
        alert("Hello")
        var result = confirm("Are you sure to remove this cart item?");
        if (result) {
            return false;
        }
    });
});