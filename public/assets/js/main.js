$('select').on('change', function() {
    alert( this.value );

    // myvalue = this.value;
    // console.console.log(value);
    

    $.ajax({
        url: "/admin/ajaxSelect",
        type: "POST",
        data: {
            test: "hello"
        },
        success: function(){
            // alert( value );
        },
        error: function(){
            alert( value );
        },
        complete: function(){
            //alert( value );
        }
    })
});
