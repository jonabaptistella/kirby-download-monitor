/* ------------------------------------------------------------- */
/* Fire functions, once loaded in the panel */
/* ------------------------------------------------------------- */

$.fn.downloadfield = function() {

/* ------------------------------------------------------------- */
/* Hide some stuff */
/* ------------------------------------------------------------- */

  $(".field-name-title, .sidebar-list:eq(0) li:not(.sidebar-list li:eq(0))").css({display: "none"});

/* ------------------------------------------------------------- */
/* Create the dynamic download-link */
/* ------------------------------------------------------------- */

  $(document).on("keyup", "#form-field-download_id", function(e) {

    if(e.which === 32){
      $(this).val($(this).val().replace(/ /g, "_"));
    }

    $(this).val($(this).val().toLowerCase());

    $("#form-field-download_link").val(download_base + $(this).val());

  });

/* ------------------------------------------------------------- */
/* E.T. phone home */
/* ------------------------------------------------------------- */

  if(window.console) {
    console.log("[download] initialized")
  }

};

/* ------------------------------------------------------------- */
/* Fire all future elements (once) */
/* ------------------------------------------------------------- */

$(function() {

  $(document).on("keypress keydown keyup", "#form-field-download_link", function(e) {

      e.preventDefault();

  });

});