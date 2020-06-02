$(document).on("click","#logoff", function(e){
    e.preventDefault();
    $(document).ready(function(){
        swal({
            title: 'Usted está a punto de salir',
            text: "¿está seguro?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4fa7f3',
            cancelButtonColor: '#d57171',
            confirmButtonText: 'Sí,quiero salir!'
            }).then(function () {
            window.location.href = "<?php echo site_url();?>sess/logoff";
        })  
    });     
});    