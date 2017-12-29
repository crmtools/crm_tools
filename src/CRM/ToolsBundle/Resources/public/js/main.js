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
            $("#crm_toolsbundle_crmqueries_groupNameUcr").removeClass('hide');
        }
    });

     var bddVal = $("#crm_toolsbundle_crmqueries_database").val();
     if(bddVal == 'UCR'){
         $("#crm_toolsbundle_crmqueries_groupNameUcr").removeClass('hide');
     }else if(bddVal == 'PICK'){
         $("#ucrClassDisplay").hide();
         $("#crm_toolsbundle_crmqueries_groupNamePick").removeClass('hide');
     }

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

//--------------------------- DISPLAY THE GOOD GROUP NAME IND. MODIFF. ---------------------------//
    var current_value = $('#crm_toolsbundle_crmqueries_groupNameUcr').attr('value');
    $('#crm_toolsbundle_crmqueries_groupNameUcr').find('option').each(function(){
        var value= $(this).attr('value');
        if(current_value == value){
            $(this).attr("selected","selected");
        }
    });

//--------------------------- DISPLAY THE SQL CODE IND. MODIFF. ---------------------------//
    var query_text = $('#crm_toolsbundle_crmqueries_queryText').attr('value');
    $('.withoutPadding').find('textarea').append(query_text);

//--------------------------- DISPLAY ACTIVE QUERY IND. MODIFF. ---------------------------//
    var active_query = $('#crm_toolsbundle_crmqueries_enableHistory').attr('value');
    console.log(active_query);

    if(active_query == 1){
        $('#crm_toolsbundle_crmqueries_enableHistory_0').attr("checked", "checked");
    }else {
        $('#crm_toolsbundle_crmqueries_enableHistory_1').attr("checked", "checked");
    }

    $("#modalSuccessMessage").modal('show');













