
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
        console.log('PPL'),
        {
        url: "/admin/ajaxServiceSelect",
        type: "POST",
        data: {
            idService: idService
        },
        success: function(result){
            console.log('SUCCESS !!!!!')
            $('#formServiceChange').html(result);
        },
        error: function(){
            console.log('ERROR !!!!!')
        },
        complete: function(){
            console.log('COMPLETE !!!!!!')
        }
    })
});

