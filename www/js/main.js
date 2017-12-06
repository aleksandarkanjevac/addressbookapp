$(document).ready(function () {


    $("#pencil0").click(function () {

        $("#skriven0").toggle("slow");
        $("#dugme0").toggle("slow");

    });

    $("#pencil1").click(function () {

        $("#skriven1").toggle("slow");
        $("#dugme1").toggle("slow");

    });

    $("#pencil2").click(function () {

        $("#skriven2").toggle("slow");
        $("#dugme2").toggle("slow");

    });

    $("#pencil").click(function () {

        $("#skriven").toggle("slow");
        $("#dugme").toggle("slow");

    });



    //REGISTRATION VALIDATION

    for (var i = 0; i < 6; i++) {

        var formarr = [$("#form1"), $("#form2"), $("#form3"), $("#form4"), $("#form5"), $("#form6")];
        var formerr = [$("#erro1"), $("#err2"), $("#err3"), $("#err4"), $("#err5"), $("#err6")];
        var msg = ["Name is required", "Last name is required", "Email is required", "Password is required",
            "Please, confirm your password", "Acces is required"];



        errors(formarr[i], formerr[i], msg[i]);
    }


    for (var i = 0; i < 5; i++) {
        var formarradd = [$("#addname"), $("#addlname"), $("#Email"), $("#phone"), $("#address")];
        var formerradd = [$("#adderr1"), $("#adderr2"), $("#adderr3"), $("#adderr4"), $("#adderr5"), $("#adderr6")];
        var msgadd = ["Name is required", "Last name is required", "Email is required", "Phone No is required",
            "Address is required"];

        errors(formarradd[i], formerradd[i], msgadd[i]);
    }


    function errors(form, err, msg) {

        form.blur(function () {
            if (!this.value) {
                err.html(msg).css("color", "red");

            }

        });

    }


    $("#register").focusout(function () {

        if (!$("#select_1").is(':checked') && !$("#select_2").is(':checked') && !$("#select_3").is(':checked')) {
            $("#err6").html("Access is required").css("color", "red");
        }

    });

    $("#close").click(function () {

        window.location.href = 'addressbook.php';

    });

    $("#close_statistic").click(function () {

        window.location.href = 'members.php';

    });

    /* $("#del").click(function () {
         confirm('Are you shure you want to delete this contact?!')

     });*/

    $("#cancel").click(function () {
        $("#alert").css("display", "none");

    });

});
