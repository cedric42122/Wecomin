$('#selectUser').change(function() {
    
    var idUtilisateur = this.value;

    $.ajax({
        url: "/admin/ajaxSelect",
        type: "POST",
        data: {
            idUtilisateur: idUtilisateur
        },
        success: function(result){
            $('#formulaireModif').html(result);
        },
        error: function(){
        },
        complete: function(){
        }
    })
});
