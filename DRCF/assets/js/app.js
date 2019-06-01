//print pages

$('.btn-imprimer').on('click', function() {
    //Print ele2 with default options
    $(".my-page").print();
});

$('.btn-imprimer-engagement').on('click', function() {
    //Print ele2 with default options
    $(".my-page-situation").print();
});
// //Print each datatable
// $('#table-couriel').DataTable( {
//     dom: 'Bfrtip',
//     buttons: [
//         'print', 'pdf'
//     ]
// } );


$('.boutton-recherche').click(function(event) {
    $('.resultat').hide();
    $('.recherche').fadeIn(); 
});

$("#btnLogin").click(function(event) {

    //Fetch form to apply custom Bootstrap validation
    var form = $("#formLogin")

    if (form[0].checkValidity() === false) {
    event.preventDefault()
    event.stopPropagation()
    }
    
    form.addClass('was-validated');
});
// check login message
$(".active").fadeIn();
$(".active").fadeOut(8000);

//lire show form and to be valid
$("button#btn-lire").click(function() {
   //alert($(this).data('be') + '  ' + $(this).data('user'));
   $('.lectDosEnregBeId').val($(this).data('be')).hide();
    $("div#myModal-lire").show();
});

//Enable form to add DEF
$(".input-checkbox").click(function() {
    $('.input-def').removeAttr('disabled');
    });
    

//Verifier show form and to be valid
$("button#btn-verifier").click(function() {
    //alert($(this).data('be') + '  ' + $(this).data('user'));
    $('.verifDosEnregBeId').val($(this).data('be')).hide();
});

//Verifier UPDATE show form 
$("button#btn-update-verifier").click(function() {
    //alert($(this).data('be') + '  ' + $(this).data('user'));
    $('.verifDosEnregBeId').val($(this).data('be')).hide();
    $('.verifDosModePass').val($(this).data('modpass'));
    $('.verifDosDateEtNum').val($(this).data('datenum'));
    $('.verifDosNumCompt').val($(this).data('numcompte'));
    $('.verifDosIntituleActivPrest').val($(this).data('intitulactivprest'));
    $('.verifDosRealisePysique').val($(this).data('realphysique'));
    $('.verifDosMontant').val($(this).data('montant'));
    $('.verifDosVisaCf').val($(this).data('visacf')).hide();
    $('.verifDosCasPossible').val($(this).data('caspossible'));

});


//REJECT show form in the verify list and to be record
$("#btn-rejeter").click(function() {
    //alert($(this).data('be') + '  ' + $(this).data('user'));
    $('.viseDosEnregBeId-reject').val($(this).data('be')).hide();
});

//Add VISA show form and to be create
$("button#btn-visa").click(function() {
    //alert($(this).data('be') + '  ' + $(this).data('user'));
    $('.enregVisaEnregBeId').val($(this).data('be')).hide();
    $('.enregVisaLivreNum').val($(this).data('livre'));
});

//lire close or annule
$(".btn-annule").click(function() {
    $("div#myModal-lire").hide();
});

//Affectation show form and to be valid
$("button#btn-affectation").click(function() {
    //alert($(this).data('numebe') + '  ' + $(this).data('numelivre'));
    $('.affectDosEnregBeNum').val($(this).data('numebe')).hide();
    $('.affectDosEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//ComfirmFromCheckToDeleguate to be valid
$("button#btn-comfirmFromCheckToDelegate").click(function() {
    //alert($(this).data('numebe') + '  ' + $(this).data('numelivre'));
    $('.mouvHistoEnregBeNum').val($(this).data('numebe')).hide();
    $('.mouvHistoEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//ComfirmFromDeleguateToCouriel to be valid
$("button#btn-comfirmFromDelegateToCouriel").click(function() {
    //alert($(this).data('numebe') + '  ' + $(this).data('numelivre'));
    $('.mouvHistoEnregBeNum').val($(this).data('numebe')).hide();
    $('.mouvHistoEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//ComfirmFromDeleguateToCheck to be valid
$("button#btn-comfirmFromDelegateToCheck").click(function() {
    //alert($(this).data('numebe') + '  ' + $(this).data('numelivre'));
    $('.mouvHistoEnregBeNum').val($(this).data('numebe')).hide();
    $('.mouvHistoEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//Show Motif Reject Detail View
$("button#btn-viewRejetMotifDetail").click(function() {
    //alert($(this).data('rejetmotiftype') + '  ' + $(this).data('rejetmotifdesc'));
    $('#motif-content-detail').html('<h4>' + $(this).data('rejetmotiftype') + '</h4> <p>' + $(this).data('rejetmotifdesc') + '</p>');
});

//Form to Record Tef here
$("button#btn-add-tef").click(function() {
    //alert($(this).data('numebe') + '  ' + $(this).data('numelivre'));
    $('.enregTefEnregBeNum').val($(this).data('numebe')).hide();
    $('.enregTefEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//Form to vise DEF 
$("button#btn-vise-def").click(function() {
    //alert( + $(this).data('numelivre));
    $('.enregDefEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//Form to reject DEF 
$("button#btn-reject-def").click(function() {
    //alert( + $(this).data('numelivre));
    $('.enregDefEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//Form to Revise after reject DEF 
$("button#btn-vise-def-rectify").click(function() {
    //alert( + $(this).data('numelivre));
    $('.enregDefEnregBeLivreNum').val($(this).data('numelivre')).hide();
});

//For disabled one fo each input situation
$( "#date-years" ).mousedown(function(){
    $( ".date-mounths" ).val('').hide();
});

$( ".date-mounths" ).mousedown(function(){
    $( "#date-years" ).val('').hide();
});

//Show location find Detail View
$("button#btn-situationDetail").click(function() {

    var lire = '';
    var verif = '';
    var vise = '';
    var rejet = '';

    if ($(this).data('lire') == 1) {
         lire = 'lu';
    }else { lire = ''; }

    if ($(this).data('verifier') == 1) {
        verif = 'vérifié';
    }else { verif = ''; } 

    if ($(this).data('viser') == 1) {
        vise = 'visé';
    }else { vise = ''; }

    if ($(this).data('rejeter') == 1) {
        rejet = 'rejeté';
    }else {rejet = ''; }

    var reception = new Date($(this).data('receptiondate'));

    $('#location-content-detail').html('<h4 class="text-uppercase">' + $(this).data('degignebe') + '</h4>'+ 
    '<p><span>Numéro d\'enregistrement: </span><span>' + $(this).data('numelivre') + '</span></p>'+
    '<p><span>Numéro de BE: </span><span>' + $(this).data('numebe') + '</span></p>'+
    '<p><span>Expediteur: </span><span>' + $(this).data('titulairebe') + '</span></p>'+
    '<p><span>Lieu: </span><span>' + $(this).data('lieube') + '</span></p>'+
    '<p><span>Date d\'enregistrement: </span><span>' + $(this).data('datecreabe') + '</span></p>'+
    '<p><span>Etat: </span><span class="badge badge-secondary">' + lire + '</span>&nbsp<span class="badge badge-secondary">' + verif + '</span>&nbsp<span class="badge badge-secondary">' + vise + '</span>&nbsp<span class="badge badge-secondary">' + rejet + '</span></p>'+
    '<p><span>Destiné au Monsier: </span><span>' + $(this).data('destination') + '</span>, le <span>' + reception + '</span></p>'
    
    );
});

//date picker
$( "#datepicker" ).datepicker({
    altField: "#datepicker",
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    dateFormat: 'dd-mm-yy'
    });

//date lire dossier
$( ".date-lire" ).datepicker({
    altField: "#datepicker",
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    dateFormat: 'dd-mm-yy'
    });

//date for chearch years
$( ".date-years" ).datepicker({
    altField: "#datepicker",
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    dateFormat: 'yy'
    });

//date for chearch mounths
$( ".date-mounths" ).datepicker({
    altField: "#datepicker",
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    dateFormat: 'dd-mm-yy'
    });
    
//Table data for recorded couriel
$(document).ready( function () {
    //Hidden default recherch and resultat
    $('.resultat').hide();
    setTimeout(function(){ 
        $('.resultat').fadeIn();
        $('.recherche').fadeOut();
        }, 4000);

     // Setup - add a text input to each footer cell
    $('.table-couriel tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Recherche '+title+'" />' );
    } );


    let table = $('.table-couriel').DataTable({ "scrollY": "200px", "scrollX": true, 
       "scrollCollapse": true, "paging": true,
       
       dom: 'Bfrtip',
       buttons: [
           'print', 'pdf'
       ]

    });

     // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    // // Setup - add a text input to each footer cell
    // $('#table-couriel thead tr').clone(true).appendTo( '#table-couriel thead' );
    // $('#table-couriel thead tr:eq(1) th').each( function (i) {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Recherche '+title+'" />' );
 
    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i).search() !== this.value ) {
    //             table
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

    /**
     * Tree View
     */
    $('#treeview').hummingbird();
    //choose select only
    $('input:checkbox').click(function() {
        $('input:checkbox').not(this).prop('checked', false);
    });

} );