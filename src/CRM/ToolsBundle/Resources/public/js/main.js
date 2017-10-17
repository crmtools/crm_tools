$(document).ready(function() {

    var container =$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    $('.js-datepicker').datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        orientation: 'top',


    });
//--------------------------- CONTACT AND BOOKING FORM ---------------------------//
    $('.envButtonSearch > input').attr('onclick', 'this.form.submit()');

});

