$(document).ready(function() {
    //419 error
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#current_pw").keyup(function() {
        var current_pw = $("#current_pw").val();
        alert(current_pw);
        $.ajax({
            type: 'post',
            url: '/admin/check-current-pw',
            success: function(resp) {
                alert(resp);
            },error:function() {
                alert("Error");
            }
        });
    });

    //$(document).on("click",".updateCategoryStatus",function() {
    $(".updateCategoryStatus").click(function() {
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-category-status',
            data: {status:status, category_id:category_id},
            success: function(resp) {
                //alert(resp['status']);
                //alert(resp['category_id']);
                if (resp['status'] == 0) {
                    $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'><span class='badge bg-label-secondary me-1'>Inactive</span></a>");
                }
                else if (resp['status'] == 1) {
                    $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'><span class='badge bg-label-success me-1'>Active</span></a>");
                }
            },error:function() {
                alert("Error");
            }
        });
        //alert(status);
        //alert(category_id);
    });

    // Update Review Status
    $(".updateReviewStatus").click(function() {
        var status = $(this).text();
        var review_id = $(this).attr("review_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-review-status',
            data: {status:status, review_id:review_id},
            success: function(resp) {
                //alert(resp['status']);
                //alert(resp['review_id']);
                if (resp['status'] == 0) {
                    $("#review-"+review_id).html("<a class='updateReviewStatus' href='javascript:void(0)'><span class='badge bg-label-secondary me-1'>Unapproved</span></a>");
                }
                else if (resp['status'] == 1) {
                    $("#review-"+review_id).html("<a class='updateReviewStatus' href='javascript:void(0)'><span class='badge bg-label-success me-1'>Approved</span></a>");
                }
            },error:function() {
                alert("Error");
            }
        });
        //alert(status);
        //alert(product_id);
    });

    $(".updateProductStatus").click(function() {
        var status = $(this).text();
        var product_id = $(this).attr("product_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status',
            data: {status:status, product_id:product_id},
            success: function(resp) {
                //alert(resp['status']);
                //alert(resp['product_id']);
                if (resp['status'] == 0) {
                    $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'><span class='badge bg-label-secondary me-1'>Inactive</span></a>");
                }
                else if (resp['status'] == 1) {
                    $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'><span class='badge bg-label-success me-1'>Active</span></a>");
                }
            },error:function() {
                alert("Error");
            }
        });
        //alert(status);
        //alert(product_id);
    });

    $(".updateAttributeStatus").click(function() {
        var status = $(this).text();
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-attribute-status',
            data: {status:status, attribute_id:attribute_id},
            success: function(resp) {
                //alert(resp['status']);
                //alert(resp['attribute_id']);
                if (resp['status'] == 0) {
                    $("#attribute-"+attribute_id).html("<a class='updateAttributeStatus' href='javascript:void(0)'><span class='badge bg-label-secondary me-1'>Inactive</span></a>");
                }
                else if (resp['status'] == 1) {
                    $("#attribute-"+attribute_id).html("<a class='updateAttributeStatus' href='javascript:void(0)'><span class='badge bg-label-success me-1'>Active</span></a>");
                }
            },error:function() {
                alert("Error");
            }
        });
        //alert(status);
        //alert(attribute_id);
    });

    /* Confirmation for delete 
    $(".confirmDelete").click(function () {
        var name = $(this).attr("name");
        if(confirm("Are you sure to delete this"+name+"?")) {
            return true;
        }
        return false;
    })*/

    // Confirmation for delete SweetAlert   
    $(document).on("click",".confirmDelete",function() {
        var record = $(this).attr("record");
        var record_id = $(this).attr("record_id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              /*Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )*/
              window.location.href = "/admin/delete-"+record+"/"+record_id
            }
          })
            return false;
    })

    // Product Attribute Add/ Remove 
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="attributes-field"><input type="text" id="size" name="size[]" value="" placeholder="Size"/><input type="text" id="sku" name="sku[]" value="" placeholder="SKU"/><input type="text" id="price" name="price[]" value="" placeholder="Price"/><input type="text" id="stock" name="stock[]" value="" placeholder="Stock"/><a href="javascript:void(0);" class="remove_button"><i class="bx bx-minus-circle ms-1"></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
    
});

/*
var input = $("#updatePwForm").find("#current_pw");
    input.keyup(function() {
        console.log($(this));
    });*/

