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



//--------------------------- INDICATORS CREATION FORM ---------------------------//
    $("#crm_toolsbundle_crmqueries_database").change(function (){
        if (this.value == 'PICK')
        {
            $("#ucrClassDisplay").hide();
            $("#crm_toolsbundle_crmqueries_groupNamePick").removeClass('hide');
        }else if(this.value == 'UCR')
        {
            $("#crm_toolsbundle_crmqueries_groupNamePick").addClass('hide');
            $("#ucrClassDisplay").css('display', '');
        }
    });
});

//--------------------------- ADD HEIGHT CONTACT/BOOKING FORM ---------------------------//

    $('.envButtonSearch').find('input').each(function() {
        var checked = $(this).attr('checked');
        if (checked != undefined ){
            var pageHeight = $(window).height();
            pageHeight = pageHeight - 380;
            $('.scrollAutoHor').height(pageHeight);
        }

    });

    $(window).on('resize', function(){
        var pageHeight =$(window).height();
        pageHeight = pageHeight - 380;
        $('.scrollAutoHor').height(pageHeight);
    });

