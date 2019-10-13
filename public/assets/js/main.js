
// Requête Ajax pour modification d'un utilisateur
$('#selectUser').change(function() {
    
    var idUser = this.value;

    $.ajax({
        url: "/admin/ajaxUserSelect",
        type: "POST",
        data: {
            idUser: idUser
        },
        success: function(result){
            $('#formUserChange').html(result);
        },
        error: function(){
        },
        complete: function(){
        }
    })
});

// Requête Ajax pour modification d'une prestation
$('#selectService').change(function() {
    
    var idService = this.value;

    $.ajax(
        {
        url: "/admin/ajaxServiceSelect",
        type: "POST",
        data: {
            idService: idService
        },
        success: function(result){
            $('#formServiceChange').html(result);
        },
        error: function(){
        },
        complete: function(){
            
        }
    })
});

