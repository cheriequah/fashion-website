$(document).ready(function() {
    //pass data from form to jquery, passing this data from jquery to ajax, passing this data to this slug, then it calls the controller function, do all the queries inside then pass back to ajax
    $('#orderby').on('change',function() {
        //alert("hello")
        var orderby = $(this).val();
        var pattern = get_filter("pattern");
        var slug = $("#slug").val();
        //this.form.submit();

        //419 error
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:slug,
            type: "post",
            data: {pattern:pattern,orderby:orderby,slug:slug},
            success: function (data) {
                $('.filter_products').html(data);
            },error:function() {
                alert("Error");
            }
        });
    });

    // patern filter
    $(".pattern").on('click',function() {
        //alert(this.className)
        var pattern = get_filter('pattern');
        var occasion = get_filter('occasion');
        var orderby = $('#orderby option:selected').val();
        var slug = $('#slug').val();
        
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:slug,
            type: "post",
            data: {pattern:pattern,occasion:occasion,orderby:orderby,slug:slug},
            success: function (data) {
                $('.filter_products').html(data);
            },error:function() {
                alert("Error");
            }
        });
    })

    // occasion filter
    $(".occasion").on('click',function() {
        //alert(this.className)
        var pattern = get_filter('pattern');
        var occasion = get_filter('occasion');
        var orderby = $('#orderby option:selected').val();
        var slug = $('#slug').val();
        
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:slug,
            type: "post",
            data: {pattern:pattern,occasion:occasion,orderby:orderby,slug:slug},
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
});