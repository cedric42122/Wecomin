// Bandeau cookie
window.cookieconsent.initialise({
  palette: {
    popup: {
      background: "#252e39"
    },
    button: {
      background: "transparent",
      text: "#14a7d0",
      border: "#14a7d0"
    }
  },
  content: {
    message:
      "\nCe site utilise des cookies pour vous garantir la meilleure expérience sur notre site.",
    dismiss: "Acceptez !",
    link: "En savoir plus "
  }
});

// Requête Ajax pour modification d'un utilisateur
$("#selectUser").change(function() {
  var idUser = this.value;

  $.ajax({
    url: "/admin/ajaxUserSelect",
    type: "POST",
    data: {
      idUser: idUser
    },
    success: function(result) {
      $("#formUserChange").html(result);
    },
    error: function() {},
    complete: function() {}
  });
});

// Requête Ajax pour modification d'une prestation
$("#selectService").change(function() {
  var idService = this.value;

  $.ajax({
    url: "/admin/ajaxServiceSelect",
    type: "POST",
    data: {
      idService: idService
    },
    success: function(result) {
      $("#formServiceChange").html(result);
      bsCustomFileInput.init();
    },
    error: function() {},
    complete: function() {}
  });
});

$(document).ready(function() {
  bsCustomFileInput.init();
});
