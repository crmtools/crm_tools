//
// $(document).ready(function(){
//     var date_input=$('input[name="date"]'); //our date input has the name "date"
//
//     var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
//     console.log($('.bootstrap-iso form').parent());
//     var options={
//         format: 'dd/mm/yyyy',
//         container: container,
//         todayHighlight: true,
//         autoclose: true,
//         orientation: 'top',
//     };
//     date_input.datepicker(options);
//
// });

$(document).ready(function() {

    var container =$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    $('.js-datepicker').datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        orientation: 'top',


    });
});



// $(document).ready(function() {
//
//
//
//     $('.js-datepicker').datepicker({
//         format: 'yyyy-mm-dd'
//
//     });
//     var options={
//         format: 'dd/mm/yyyy',
//         container: container,
//         todayHighlight: true,
//         autoclose: true,
//         orientation: 'top',
//     };
//     date_input.datepicker(options);
// });