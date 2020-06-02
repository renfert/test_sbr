$(document).ready(function(){
    // Select
    $(".select2").select2();
    $(".select2-limiting").select2({
        maximumSelectionLength: 2
    });

    
    //Courses datatable
    var tableCourses = $('#datatableCourses').DataTable({
        lengthChange: false,
        buttons: [
            { extend: 'pdf', className: 'btn btn-purple',filename:'Cursos',title: 'Cursos'
        },
            { extend: 'excel', className: 'btn btn-purple',filename:'Cursos',title: 'Cursos' },
        ]
    });
    tableCourses.buttons().container().appendTo('#datatableCourses_wrapper .col-md-6:eq(0)');

     //Programs datatable
     var tablePrograms = $('#datatablePrograms').DataTable({
        lengthChange: false,
        buttons: [
            { extend: 'pdf', className: 'btn btn-purple',filename:'Programas',title: 'Programas'
        },
            { extend: 'excel', className: 'btn btn-purple',filename:'Programas',title: 'Programas' },
        ]
    });
    tablePrograms.buttons().container().appendTo('#datatablePrograms_wrapper .col-md-6:eq(0)');
});


function changeMode(id){
    $(document).on("change",".modeInput",function(){
        var mode = $(".modeText").attr("data-mode");
        if(mode == "disable"){
            $(".modeText").attr("data-mode", "enable");
            $(".modeText").removeClass("text-danger");
            $(".modeText").addClass("text-success");
            $(".modeText").html("activado");
            $(".text2").html("desactivarlo");

            $.ajax({
                url: '/edit/mode',
                type:"POST",
                data:{"mode":"enable", "id":id}
            });


        }else{
            $(".modeText").attr("data-mode", "disable");
            $(".modeText").removeClass("text-success");
            $(".modeText").addClass("text-danger");
            $(".modeText").html("desactivado");
            $(".text2").html("activarlo");

            $.ajax({
                url: '/edit/mode',
                type:"POST",
                data:{"mode":"disable", "id":id}
            });

        }
    })
}


function enroll_course(){
    $(document).on("click","#tour", function(){
        var course = $(this).parent().children('select').val();
        var student = $("#studentName").html();
        var studentId = $("#studentId").val();
        swal({
            title: 'Permitir acceso al curso <b style="color:#CD2626;">'+course+'</b> para el alumno: <b style="color:#CD2626;"> '+student+' </b>',
            text: "¿está seguro?",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#4fa7f3',
            cancelButtonColor: '#d57171',
            confirmButtonText: 'Sí'
        }).then(function () {
            $('body').loadingModal({
                position: 'auto',
                text: 'Guardando, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'foldingCube'
            });
            $.ajax({
                url: "/reg/enroll",
                type: "POST",
                data: {"course" : course, "student" : studentId},
                success: function(){
                    $('body').loadingModal('destroy');
                    document.location.reload(true);
                }
            })
        })  
            
    });
}

function enroll_program(){
    $(document).on("click","#send_program", function(){
        var program = $(this).parent().children('select').val();
        var student = $("#studentName").html();
        var studentId = $("#studentId").val();
        swal({
            title: 'Permitir acceso al programa  para el alumno: <b class="text-primary"> '+student+' </b>',
            text: "¿está seguro?",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#4fa7f3',
            cancelButtonColor: '#d57171',
            confirmButtonText: 'Sí'
        }).then(function () {
            $('body').loadingModal({
                position: 'auto',
                text: 'Guardando, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'foldingCube'
            });
            $.ajax({
                url: "/reg/enroll_program",
                type: "POST",
                data: {"program" : program, "student" : studentId},
                success: function(){
                    $('body').loadingModal('destroy');
                    document.location.reload(true);
                }
            })
        })   
    });
}


