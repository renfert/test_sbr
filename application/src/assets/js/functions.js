/* 
    =============================================
       Validador de inputs/
    ============================================== 
*/

function stringValidate(string){
    if(string.includes('@') || string.includes('_') || string.includes('^') || string.includes('+') ||  string.includes('/') || string.includes('+') || string.includes('*') || string.includes('"')){
        swal({
            title: 'Utilice sólo letras y números',
            type: 'warning',
            confirmButtonColor: '#4fa7f3'
        }).then(function(){
           
        })
    return false;
    }else{
        return true;
    }
}

// -------- Start dropify
$('.dropify').dropify({
    messages: {
        'default': 'Drag and drop a file here or click',
        'replace': 'Drag and drop or click to replace',
        'remove': 'Remove',
        'error': 'Ooops, something wrong appended.'
    },
    error: {
        'fileSize': 'The file size is too big (1M max).'
    }
});



/* 
    =============================================
       Tawk to
    ============================================== 
*/
function getTawkTo(group){
    if(group == "administrator"){
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5cb4a313c1fe2560f3feedbc/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    }
}

/* 
    =============================================
       Logoff
    ============================================== 
*/
function logoff(){
    $(document).on("click","#logoff", function logoff(){
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
                function addZero(i) {
                    if (i < 10) {
                        i = "0" + i;
                    }
                    return i;
                }    
                var enter = sessionStorage.getItem('login_time');
                window.location.href = "/sess/logoff?start_time="+enter+"";
            })  
        });     
    });    
}

/* 
    =============================================
       Online users
    ============================================== 
*/
function onlineUsers(){
    $(document).ready(function(){
        $.ajax({
             url: '/info/online',
             dataType:"json",
             async: false,
             success: function(data){
                 var users = data[1];
                 var str = "";
                 for(var i=0; i<users.length; i++) {
                     var string = "<li>"+data[1][i]+"</li>"
                     var str = str + string;
                 }
                 $("#online").html(data[0]);
                 $("#onlineUsers").attr('data-content', "<ul>"+str+"</ul>");
    
             }
         });
    
         setInterval(function(){
             $.ajax({
                url: '/info/online',
                dataType:"json",
                async: false,
                success: function(data){
                    var users = data[1];
                    for(var i=0; i<users.length; i++) {
                  
                }
                $("#online").html(data[0]);
             }
         });
         }, 60000)
    
     });
}

 /* 
    =============================================
       Field validation
    ============================================== 
*/
 function callbackValidation(msg){
    swal({
        title: msg,
        text: 'por favor revise sus datos',
        imageUrl: '../assets/img/callback/missing.png',
        imageHeight: 90,
        animation: true,
        confirmButtonColor: '#4fa7f3'
    })
}

/* 
    =============================================
       Register a user
    ============================================== 
*/

function newUser(){
    $(document).ready(function(){
        $("#register_button").click(function(){
            $('body').loadingModal({
                position: 'auto',
                text: 'Creando el usuario ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'foldingCube'
            });
            var cont = 0;
            $('[required]').each(function(){
                if(!$(this).val()){
                    cont++
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.error('Todos los campos deben ser completados.');
                    $(this).addClass("invalid-field");
                }
            });

            if(cont!=0){
                $('body').loadingModal('destroy');
                callbackValidation(msg);
                return false;
            }else{
                    $.ajax({
                        url: '/reg/usr',
                        type: 'POST',
                        data: $("#register_form").serialize(),
                        success: function(data){
                            if(data != 0){
                                $('body').loadingModal('destroy');
                                swal({
                                    title: 'Usuario registrado',
                                    type: 'success',
                                    confirmButtonColor: '#4fa7f3'
                                }).then(function(){
                                    document.location.reload(true);
                                })
                            }else{
                                $('body').loadingModal('destroy');
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.error('Este correo ya se encuentra registrado');
                            }
                        }
                    });
                }
            });
            // Remove invalid field
            $(document).on("focus", "[required]", function(){
                $(this).removeClass("invalid-field");
            });
    });     
}


/* 
    =============================================
       Massive import
    ============================================== 
*/

function massiveImport(){
    $(document).ready(function(){
        $("#send_import").click(function(){
            $('body').loadingModal({
                position: 'auto',
                text: 'Importando ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'foldingCube'
            });
         
            var formData = new FormData();
            var input = document.getElementById('import_file');
            var file = input.files[0];
            formData.append('file', file);
            $.ajax({
                url: '/reg/create_massive',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){
                    $('body').loadingModal('destroy');
                    swal({
                        title: '¡Importación completada con éxito!',
                        type: 'success',
                        confirmButtonColor: '#4fa7f3'
                    }).then(function(){
                        document.location.reload(true);
                    })
                }
            });
                
        });
    });     
}

/* 
    =============================================
     Search
    ============================================== 
*/

function search() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByClassName("filter")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].closest('.col-xl-6').style.display = "";
        } else {
            li[i].closest('.col-xl-6').style.display = "none";
        }
    }
}

function searchCourseProduct() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].closest('.col-lg-6').style.display = "";
        } else {
            li[i].closest('.col-lg-6').style.display = "none";
        }
    }
}



/* 
    =============================================
     Table load
    ============================================== 
*/

function loadTable(name){
    $(document).ready(function () {
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: [
                { extend: 'pdf', className: 'btn btn-purple',filename:name,title: name
            },
                { extend: 'excel', className: 'btn btn-purple',filename:name,title: name },
            ]
        });

        // Responsive Datatable
        $('#responsive-datatable').DataTable();
        table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
}

function skipStep(){
    $(".skip").on("click", function(){
        var control = $(this).attr("data-step");
        var el = $(this).parent().parent().parent().children(".done");
        var el2 = $(this).parent().parent().parent().children(".na");

        $.ajax({
            url: '/edit/firstSteps',
            type: 'POST',
            data: {'step': control},
            success: function(data){
                el.show();
                el2.hide();
            }
        });
    });
}


/* 
    =============================================
     New categorie
    ============================================== 
*/

function newCategorie(){
    $(document).ready(function(){
        $("#send_cat").click(function(){
            var name = $("#name").val();
            var cont = 0;
            
            // Verify empty field
            if(name == ""){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('El campo de nombre es obligatorio');
                cont++;
            }
            if(cont == 0){ 
                $.ajax({
                    url: '/reg/cat',
                    type: 'POST',
                    data: $("#register_form").serialize(),
                        success: function(data){
                            if(data == "1"){
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.error('Esta categoría ya está registrado');
                            }else{
                                swal({
                                    title: 'Categoría registrada exitosamente',
                                    type: 'success',
                                    confirmButtonColor: '#4fa7f3'
                                }).then(function(){
                                    window.location.reload(); 
                                })
                            }
                        }
                });
            }
        });     
    });     
}


function newCategorieInCourse(){
    $(document).ready(function(){

        $(document).on("change", "#selectCat", function(){
            var el = $(this).val();
            if(el == "new-category"){
                $("#modalNewCategory").modal().show();
            }
        });


        $("#send_cat").click(function(){
            var name = $("#catName").val();
            var cont = 0;
            
            // Verify empty field
            if(name == ""){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('El campo de nombre es obligatorio');
                cont++;
            }
            if(cont == 0){ 
                $.ajax({
                    url: '/reg/cat', 
                    type: 'POST',
                    data: {'name':name},
                        success: function(data){
                            if(data == "1"){
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.error('Esta categoría ya está registrado');
                            }else{
                                $("#modalNewCategory").modal().hide();
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.success('Categoría registrada exitosamente');
                                $("#selectCat").prepend("\
                                    <option value="+name+">"+name+"</option>\
                                ");
                                $("#selectCat option[value="+name+"]").prop('selected', 'selected');
                            }
                        }
                });
            }
        });     
    });     
}

/* 
    =============================================
     Edit categorie
    ============================================== 
*/
$(document).ready(function(){
    $(".editCat").on("click", function(){
        var cont = 0;
        var name = $(this).prev('input').val();
        var el = $(this).prev('input');
        var id = el.prev().prev('input').val();
      
        // Verify empty field
        if(name == ""){
            toastr.options.positionClass = 'toast-top-right';
            toastr.error('El campo de nombre es obligatorio');
            cont++;
        }

        if(cont == 0){
            $.ajax({
                url: "/edit/cat/"+name+"/"+id,
                type: 'POST',
                success: function(data){
                    if(data == "1"){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.error('Esta categoría ya está registrado');
                    }else{
                        window.location.reload(); 
                    }
                }
            });
        }

    });     
});

/* 
    =============================================
     Delete categorie
    ============================================== 
*/
    $(document).ready(function(){
        $(".delCat").on("click", function(){
            id = $(this).attr("data-id");
            name = $(this).attr("data-name");
            swal({
                title: '¿Está seguro?',
                text: "El categoía " +name+ " se eliminará",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí, puede borrar!'
            }).then(function () {
                $.ajax({
                    url: "/del/cat/"+name+"/"+id,
                    type: 'POST'
                });
                document.location.reload(true);
            })  
        });
    });     


/* 
    =============================================
     Delete categorie
    ============================================== 
*/

function delUser(userId,userName){
    $(document).ready(function(){
        swal({
            title: '¿Está seguro?',
            text: "El usuario " +userName+ " se eliminará",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4fa7f3',
            cancelButtonColor: '#d57171',
            confirmButtonText: 'Sí, puede borrar!'
        }).then(function () {
            $.ajax({
                url: "/del/usr/"+userId,
                type: 'POST'
            });
            document.location.reload(true);
        })  
    });     
}


/* 
    =============================================
     Remove course from user
    ============================================== 
*/
function removeCourse(userId,userName,courseId,courseName){
    $(document).ready(function(){
        swal({
            title: '¿Está seguro?',
            text: "Quitar el curso " +courseName+ " del usuario "+userName+" ",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4fa7f3',
            cancelButtonColor: '#d57171',
            confirmButtonText: 'Sí, puede quitar!'
        }).then(function () {
            $('body').loadingModal({
                position: 'auto',
                text: 'Borrando, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'foldingCube'
            });
            $.ajax({
                url: "/del/userFromCourse/"+userId+"/"+courseId,
                type: 'POST',
                success: function(){
                    $('body').loadingModal('destroy');
                    document.location.reload(true);
                }
            });
        })  
    });     
}

/* 
    =============================================
     Remove program from user
    ============================================== 
*/
function removeProgram(userId,userName,programId,programName){
    $(document).ready(function(){
        swal({
            title: '¿Está seguro?',
            text: "Quitar el programa " +programName+ " del usuario "+userName+" ",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4fa7f3',
            cancelButtonColor: '#d57171',
            confirmButtonText: 'Sí, puede quitar!'
        }).then(function () {
            $('body').loadingModal({
                position: 'auto',
                text: 'Borrando, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'foldingCube'
            });
            $.ajax({
                url: "/del/userFromProgram/"+userId+"/"+programId,
                type: 'POST',
                success: function(){
                    $('body').loadingModal('destroy');
                    document.location.reload(true);
                }
            });
        })  
    });     
}


/* 
    =============================================
     Search category
    ============================================== 
*/
function searchCat() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].closest('.col-xl-3').style.display = "";
        } else {
            li[i].closest('.col-xl-3').style.display = "none";
        }
    }
}



/* 
    =============================================
    Delete course
    ============================================== 
*/
function deleteCourse(){
    $(document).ready(function(){
        $(document).on("click",".exclude_course",function() {
            var courseId = $(this).prev('input').val();
            swal({
                title: "Cuidado!                ",
                text: "Usted está a punto de eliminar el curso, ¿está seguro?",
                type: 'warning',
                showCancelButton: true,
                timer: 0
                }).then(    
                function () {
                    
                    $('body').loadingModal({
                        position: 'auto',
                        text: 'Borrando... aguarde ...',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'foldingCube'
                    });
                    $.ajax({
                        url: '/del/course',
                        type: 'POST',
                        data: {"courseId" : courseId},
                        success: function(data){
                            document.location.reload(true);
                        }
                    });
                },
            )
        });

    });
}


/* 
    =============================================
     Change settings images
    ============================================== 
*/


/* 
    =============================================
     Save setttings
    ============================================== 
*/

function newSettings(){
    $(document).ready(function(){
        $("#send").on("click", function(){
            var formData = new FormData($("#my_form")[0]);
            $.ajax({
                url: '/edit/settings',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,        
                success: function(data){
                    swal({
                        title: 'Guardado',
                        type: 'success',
                        confirmButtonColor: '#4fa7f3'
                        }).then(function(){
                            document.location.reload(true);
                        });
                }
            });
        });
    });
}

/* 
    =============================================
     Upload course image
    ============================================== 
*/

function uploadCourseImage(){
    $(function() {
        $(document).on("change",".uploadFile", function()
        {
            $('body').loadingModal({
                position: 'auto',
                text: 'Guardando su imagen, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'fadingCircle'
            });
            var myInput = $(this).parent().parent().children('.putFile');
            var fileInput = $(this);
            var formData = new FormData();
            formData.append('image', $(this)[0].files[0]);
            $.ajax({
                url: '/reg/course_image',
                type: 'POST',
                data: formData,  
                processData: false,
                contentType: false,  
                success: function(data){
                    myInput.val(data);
                    $('body').loadingModal('destroy');
                }
            });

            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support    
        });
    });
}

/* 
    =============================================
     Upload html
    ============================================== 
*/

function uploadHtml(){
    $(function() {
        $(document).on("change",".uploadHtml", function()
        {
            var el = $(this);
            $('body').loadingModal({
                position: 'auto',
                text: 'Guardando archivo, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'fadingCircle'
            });
            var myInput = $(this).parent().parent().children('.putFile');
            console.log(myInput);
            var fileInput = $(this);
            var formData = new FormData();
            formData.append('html', $(this)[0].files[0]);
            $.ajax({
                url: '/reg/html',
                type: 'POST',
                data: formData,  
                processData: false,
                contentType: false,  
                success: function(data){
                    if(data == 0){
                        $('body').loadingModal('destroy');
                        el.val('');
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.error('No pudimos encontrar el archivo index.html en la raíz de su proyecto.');
                    }else{
                        myInput.val(data);
                        $('body').loadingModal('destroy');
                    }
                }
            });

            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support    
        });
    });
}


/* 
    =============================================
     Upload program image
    ============================================== 
*/

function uploadProgramImage(){
    $(function() {
        $(document).on("change",".uploadFile", function()
        {
            $('body').loadingModal({
                position: 'auto',
                text: 'Guardando su imagen, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'fadingCircle'
            });
            var myInput = $(this).parent().parent().children('.putFile');
            var fileInput = $(this);
            var formData = new FormData();
            formData.append('image', $(this)[0].files[0]);
            $.ajax({
                url: '/reg/program_image',
                type: 'POST',
                data: formData,  
                processData: false,
                contentType: false,  
                success: function(data){
                    myInput.val(data);
                    $('body').loadingModal('destroy');
                }
            });

            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support    
        });
    });
}

/* 
    =============================================
     Upload course image
    ============================================== 
*/

function uploadCourseVideoPreview(){
    $(function() {
        $(document).on("change",".uploadFileVideo", function()
        {
            var uploadFile = $(this);        
            var myInput = $(this).parent().parent().children('.putFile');
            var fileInput = $(this);
            var maxSize = $(this).data('max-size');
            var bar1 = new ldBar("#myBar");

            //aqui a sua função normal
            if (fileInput.get(0).files.length) {
                var fileSize = fileInput.get(0).files[0].size; // in bytes
                if (fileSize > parseInt(maxSize) * parseInt(1000000)  ) {
                    swal({
                    title: "Ok",
                    text: "Lo archivo supera el tamaño máximo de: "+maxSize+" MB",
                    type: 'warning',
                    });
                    return false;
                }else{
                    var path = $(this).val();
                    var filename = path.replace(/^.*\\/, "");
                    var formData = new FormData();
                    formData.append('videoPreview', $(this)[0].files[0]);

                    var exibirMensagemDeEspera = function(){
                      $("#myModal").modal('show');
                    }

                    var ocultarMensagemDeEspera = function(){
                        $("#myModal").modal('hide');    
                    }

                    var definirPercentualConcluido = function(percentual){
                        bar1.set(percentual);
                    }

                    exibirMensagemDeEspera();
                    $.ajax({
                        url: '/reg/video_preview',
                        type: 'POST',
                        data: formData,
                        processData: false, 
                        contentType: false,    
                        xhr: function () {
                            var xhr = $.ajaxSettings.xhr();
                            xhr.upload.onprogress = function (e) {
                                // For uploads
                                if (e.lengthComputable) {
                                    var percent = Math.round(((e.loaded / e.total) *100));
                                    if(percent > 98){
                                       $("#myBar").hide();
                                       $("#progressMessage").show();
                                       
                                    }
                                    definirPercentualConcluido(percent); 
                                }
                            };
                            return xhr;
                        },
    
                        success: function(data){
                            definirPercentualConcluido(0); 
                            myInput.val(data);
                            ocultarMensagemDeEspera();
                            $("#myBar").show();
                            $("#progressMessage").hide();
                        }
                    });
                }
            } 
        });
    });
}

/* 
    =============================================
     Max lenght
    ============================================== 
*/

function maxLenght(){
    $('.max').maxlength({
        alwaysShow: true,
        warningClass: "badge badge-success",
        limitReachedClass: "badge badge-danger"
    });
}


/* 
    =============================================
     Delete a lesson
    ============================================== 
*/
$(document).ready(function(){
    $(".delete_lesson").on("click", function(){
        $('.tooltip').hide();
        var classToDelete = $(this).closest('li');
        var content = $(this).children().val();
        swal({
            title: "Cuidado!                ",
            text: "Usted está a punto de eliminar esta leccion, ¿está seguro?",
            type: 'warning',
            showCancelButton: true,
            timer: 0
            }).then(
            function () {
                $.ajax({
                    type: 'POST',
                    url: '/del/lesson',
                    data: {"lessonId" : content} ,
                    success: function(data){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.success('Lección eliminada con éxito');
                    }
                })
                classToDelete.remove();
                $(".tooltip").tooltip("hide");
            },
        )
    })
});



/* 
    =============================================
     Delete a module
    ============================================== 
*/
$(document).ready(function(){
    $(document).on("click",".delete_class",function() {
        var classToDelete = $(this).closest('.col-xl-12');
        var module = $(this).closest(".card-header").children().children().eq(2).val();
        swal({
            title: "Cuidado!                ",
            text: "Usted está a punto de eliminar el módulo, ¿está seguro?",
            type: 'warning',
            showCancelButton: true,
            timer: 0
            }).then(
            function () {
                $.ajax({
                    type: 'POST',
                    url: '/del/module',
                    data: {"moduleId" : module} ,
                    success: function(data){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.success('Modulo eliminado con éxito');
                    }
                })
                classToDelete.remove();
                $(".tooltip").tooltip("hide");
            },
        )
    });  
});


/* 
    =============================================
     Delete a webinar
    ============================================== 
*/
$(document).ready(function(){
    $(".delete_webinar").on("click", function(){
        $('.tooltip').hide();
        var classToDelete = $(this).closest('li');
        var content = $(this).children().val();
        swal({
            title: "Cuidado!                ",
            text: "Usted está a punto de eliminar este webinar, ¿está seguro?",
            type: 'warning',
            showCancelButton: true,
            timer: 0
            }).then(
            function () {
                $.ajax({
                    type: 'POST',
                    url: '/del/webinar',
                    data: {"webinarId" : content} ,
                    success: function(data){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.success('Webinar eliminado con éxito');
                    }
                })
                classToDelete.remove();
            },
        )
    })
});

/* 
    =============================================
     Delete a videocall
    ============================================== 
*/
$(document).ready(function(){
    $(".delete_videocall").on("click", function(){
        $('.tooltip').hide();
        var classToDelete = $(this).closest('li');
        var content = $(this).children().val();
        swal({
            title: "Cuidado!                ",
            text: "Usted está a punto de eliminar esta videocall, ¿está seguro?",
            type: 'warning',
            showCancelButton: true,
            timer: 0
            }).then(
            function () {
                $.ajax({
                    type: 'POST',
                    url: '/del/videocall',
                    data: {"callId" : content} ,
                    success: function(data){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.success('Video call eliminada con éxito');
                    }
                })
                classToDelete.remove();
            },
        )
    })
});

/* 
    =============================================
     Delete a exam
    ============================================== 
*/
$(document).ready(function(){
    $(".delete_exam").on("click", function(){
        $('.tooltip').hide();
        var classToDelete = $(this).closest('li');
        var content = $(this).children().val();
        swal({
            title: "Cuidado!                ",
            text: "Usted está a punto de eliminar este examen, ¿está seguro?",
            type: 'warning',
            showCancelButton: true,
            timer: 0
            }).then(
            function () {
                $.ajax({
                    type: 'POST',
                    url: '/del/exam',
                    data: {"examId" : content} ,
                    success: function(data){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.success('Examen eliminado con éxito');
                    }
                })
                classToDelete.remove();
            },
        )
    })
});



/* 
    =============================================
     Change profile image
    ============================================== 
*/

function editProfile(){
    $(document).ready(function(){
        $(document).on("click", ".avatar", function(){
            var avatar = $(this).attr("data-avatar");
            $("#avatarName").val(avatar);
            $('#my_modal').modal('hide');
            $("#user-img").attr("src", "../assets/img/avatar/"+avatar+"");
        });

        loadFile = function(event) {
            $('#my_modal').modal('hide');
            var output = document.getElementById('user-img');
            var photo =  URL.createObjectURL(event.target.files[0]);
            output.src = URL.createObjectURL(event.target.files[0]);
        };

        $(document).on("click", "#send", function(){
            var formdata = new FormData($("#my_form")[0]);
            $.ajax({
                type: 'POST',
                url: '/edit/profile',
                data: formdata ,
                processData: false,
                contentType: false,
                success: function(data){
                    swal({
                        title: 'Guardado',
                        type: 'success',
                        confirmButtonColor: '#4fa7f3'
                        }).then(function(){
                            document.location.reload(true);
                        });
                }
            })
        })
    });
}


/* 
    =============================================
     Update API
    ============================================== 
*/

function editApi(){
    $(document).ready(function(){
        $(document).on("click", "#send_integration_mercadopago", function(){
            var publicKey = $("#publicKey").val();
            var accessToken = $("#accessToken").val();
            var currency = "MXN";

            $.ajax({
                dataType: "json",
                url: "https://api.mercadopago.com/v1/identification_types?access_token="+accessToken+"",
                success: function(c){
                    $.each(c, function(key, newObj){
                        id = newObj.id;

                        switch(id) {
                            case "LC":
                                currency = "ARS";
                                break;
                            case "CPF":
                                currency = "BRL";
                              break;
                            case "RUT":
                                currency = "CLP";
                                break;
                            case "NIT":
                                currency = "COP";
                                break;
                            case "DNI":
                                currency = "PEN";
                                break;
                            case "CI":
                                currency = "UYU";
                                break;
                            default: 
                                currency = "MXN";
                                break;
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '/edit/integration',
                        data: {"publicKey" : publicKey, "accessToken" : accessToken} ,
                        success: function(data){
                            $("#currency").append(currency);
                            $('#modalMp').modal('show');
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '/edit/currency',
                        data: {"currency" : currency} ,
                    });
                },
                error: function(data){
                    $.ajax({
                        type: 'POST',
                        url: '/edit/integration',
                        data: {"publicKey" : publicKey, "accessToken" : accessToken} ,
                        success: function(data){
                            $("#currency").append(currency);
                            $('#modalMp').modal('show');
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '/edit/currency',
                        data: {"currency" : currency} ,
                    });
                }
            });
        })

        $(document).on("click", "#send_integration_analytics", function(){
            idAnalytics = $("#id_analytics").val();
            $.ajax({
                type: 'POST',
                url: '/edit/integration_analytics',
                data: {"idAnalytics" : idAnalytics},
                success: function(data){
                    swal({
                        title: 'Guardado',
                        type: 'success',
                        confirmButtonColor: '#4fa7f3'
                        }).then(function(){
                            document.location.reload(true);
                        });
                }
            })
        });

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
               result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
         

        $(document).on("click", "#send_secret_eadtools", function(){
            $.ajax({
                type: 'POST',
                url: '/edit/integration_eadtools',
                success: function(data){
                    var trimStr = $.trim(data);
                    $("#secret_eadtools").val(trimStr);
                }
            })
        });
    });
}

/* 
    =============================================
    Login
    ============================================== 
*/
function login(){
	$(document).ready(function(){
		$(document).on("click", "#linkNewAccount", function(){
			$(this).hide();
			$("#linkHacerLogin").show();
			$(".login").hide();
			$(".new_account").show();
		})

		$(document).on("click", "#linkHacerLogin", function(){
			$(this).hide();
			$("#linkNewAccount").show();
			$(".login").show();
			$(".new_account").hide();
		})

        // Create new account in course purchase
		$(document).on("click", "#send_account", function(){
            var dataForm = $("#form_account").serialize();
            var cont = 0;

            var pass = $("#password").val();
            var email = $("#email").val();
            var time = $("#time").val();
            var name = $("#name").val();

            if(name == ""){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('El campo nombre es obligatorio');
                cont++;
                return false;
            }

            if(email == ""){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('El campo email es obligatorio');
                cont++;
                return false;
            }

            if(pass == ""){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('El campo de contraseña es obligatorio');
                cont++;
                return false;
            }


            if($("#password").val() != $("#confirmPass").val()){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('Las contraseñas son diferentes');
                cont++;
                return false;
            }

            if(cont == 0){
                $('body').loadingModal({
                    position: 'auto',
                    text: 'Creando el usuario ...',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'foldingCube'
                });
                $.ajax({
                    url: '/reg/usr',
                    type: "POST",
                    data: dataForm,
                    success:function(data){
                        if(data != 0){
                            $('body').loadingModal('destroy');
                            // Login
                            $.ajax({
                                url: '/login/main',
                                data: {'time':time,'password':pass,'email':email},
                                type: "POST",
                                success:function(data){
                                    if(data == "0"){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.error('Contraseña o usuario incorrecto');
                                    }else{
                                        loginTime = $("#time").val();
                                        sessionStorage.setItem('login_time', loginTime);
                                        location.reload();
                                    }
                                }
                            });
                        }else{
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.error('Este e-mail ya existe');
                            $('body').loadingModal('destroy');
                        }
                    }
                });		
            }	
        });


        // Create new account from home
        $(document).on("click", "#send_account_home", function(){
            var dataForm = $("#form_account_home").serialize();
            var name = $("#name").val();
            var pass = $("#password").val();
            var email = $("#email").val();
            var time = $("#time").val();
            var cont = 0;

            $('[required]').each(function(){
                var el = $(this).val();
                var info = $(this).attr("data-name");
                if(el == ""){
                    cont++;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.error('El campo '+info+' es obligatorio');
                    return false;
                }
            })
          
            if($("#password").val() != $("#confirmPass").val()){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('Las contraseñas son diferentes');
                cont++
            }

            if(cont == 0){
                $('body').loadingModal({
                    position: 'auto',
                    text: 'Creando el usuario ...',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'foldingCube'
                });
                $.ajax({
                    url: '/reg/usr',
                    type: "POST",
                    data: dataForm,
                    success:function(data){
                        if(data != 0){
                            $('body').loadingModal('destroy');
                            $("#form_account_home").hide();
                            $("#accountCreated").fadeIn("slow");
                        }else{
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.error('Este e-mail ya existe');
                            $('body').loadingModal('destroy');
                        }
                    }
                });
            }
        })
        
        
    
		$(document).on("click","#send_login", function(){
			formData = $("#form_login").serialize();
			$.ajax({
				url: '/login/main', 
				data: formData,
				type: "POST",
				success:function(data){
					if(data == "0"){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.error('Contraseña o usuario incorrecto');
					}else{
						loginTime = $("#time").val();
						sessionStorage.setItem('login_time', loginTime);
						swal({
                        	title: 'Inicio de sesión con éxito',
                            type: 'success',
                            confirmButtonColor: '#4fa7f3'
                        }).then(function(){
                              window.location.href = data;
                        })
					}
				}
			});
		})
	});
}



/* 
    =============================================
    Login freecourse
    ============================================== 
*/
function loginFreeCourse(){
	$(document).ready(function(){

        // Go to new account2
		$(document).on("click", "#linkNewAccount2", function(){
			$(this).hide();
			$("#linkHacerLogin2").show();
			$(".login2").hide();
			$(".new_account2").show();
		})

        // Go to login2
		$(document).on("click", "#linkHacerLogin2", function(){
			$(this).hide();
			$("#linkNewAccount2").show();
			$(".login2").show();
			$(".new_account2").hide();
		})


        // Create acoount to free course
		$(document).on("click", "#send_free_course2", function(){
            var dataForm = $("#form_free_course2").serialize();
            var pass = $("#passwordFreeCourse").val();
            var email = $("#emailFreeCourse").val();
            var time = $("#time").val();
            var urlCourse = $("#courseId").attr('data-course');
            if($("#password").val() != $("#confirmPass").val()){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('Las contraseñas son diferentes');
            }else{
                $('body').loadingModal({
                    position: 'auto',
                    text: 'Creando el usuario...',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'foldingCube'
                });
                $.ajax({
                    url: '/reg/usrFreeCourse',
                    type: "POST",
                    data: dataForm,
                    success:function(data){  
                        $('body').loadingModal('destroy');
                        if(data != 0){
                            // Login
                            $.ajax({
                                url: '/login/main',
                                data: {'time':time,'password':pass,'email':email},
                                type: "POST",
                                success:function(data){
                                    if(data == "0"){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.error('Contraseña o usuario incorrecto');
                                    }else{
                                        loginTime = $("#time").val();
                                        sessionStorage.setItem('login_time', loginTime);
                                        $("#form_free_course2").hide();
                                        $("#accountCreated").fadeIn();
                                    }
                                }
                            });
                        }else{
                            $('body').loadingModal('destroy');
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.error('Este e-mail ya existe');
                        }
                    }
                });
            }
        })

        // Login on course page
        $(document).on("click","#send_login2", function(){
			formData = $("#form_login2").serialize();
			$.ajax({
				url: '/login/main',
				data: formData,
				type: "POST",
				success:function(data){
					if(data == "0"){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.error('Contraseña o usuario incorrecto');
					}else{
						loginTime = $("#time").val();
						sessionStorage.setItem('login_time', loginTime);
						swal({
                        	title: 'Inicio de sesión con éxito',
                            type: 'success',
                            confirmButtonColor: '#4fa7f3'
                        }).then(function(){
							window.location.reload(); 
                        })
					}
				}
			});
		})
        
       
	});
}

/* 
    =============================================
    Delete program
    ============================================== 
*/

function deleteProgram(){
    $(document).ready(function(){
        $(document).on("click", ".delete_program", function(){
            var programId = $(this).attr("id");
            swal({
                title: '¿Está seguro de que desea excluir este programa?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí!'
            }).then(function () {
                $.ajax({
                    url: '/del/program',
                    type: 'POST',
                    dataType: 'json',
                    data: {"id" : programId},
                });
                location.reload();
                
            })    
        });
    });
}

/* 
    =============================================
    New group
    ============================================== 
*/

function newGroup(){
    $("#register_button").click(function(){
        var name = $("#name").val();
        var cont = 0;
        
        // Verify empty field
        if(name == ""){
            toastr.options.positionClass = 'toast-top-right';
            toastr.error('El campo de nombre es obligatorio');
            cont++;
        }
        if(cont == 0){ 
            $.ajax({
                url: '/reg/grp',
                type: 'POST',
                data: $("#register_form").serialize(),
                    success: function(data){
                        if(data == "1"){
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.error('Este grupo ya está registrado');
                        }else{
                            swal({
                                title: 'Equipo registrado exitosamente',
                                type: 'success',
                                confirmButtonColor: '#4fa7f3'
                            }).then(function(){
                                window.location.reload(); 
                            })
                        }
                    }
            });
        }
    });     
}

function clearInfo(){
    $('input').on("focus", function(){
        $('.info').each(function(){
            $(this).fadeOut("slow");
        });
    });
}

/* 
    =============================================
    Edit group
    ============================================== 
*/


    $(document).ready(function(){
        $(".editGroup").on("click", function(){
            var cont = 0;
            var name = $(this).parent().children().val();
            var id = $(this).parent().children().children().val();
            var name = $(this).prev('input').val();
            var el = $(this).prev('input');
            var id = el.prev('input').val();

            // Verify empty field
            if(name == ""){
                toastr.options.positionClass = 'toast-top-right';
                toastr.error('El campo de nombre es obligatorio');
                cont++;
            }

            if(cont == 0){
                $.ajax({
                    url: "/edit/grp/"+name+"/"+id,
                    type: 'POST',
                    success: function(data){
                        if(data == "1"){
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.error('Este grupo ya está registrado');
                        }else{
                            window.location.reload(); 
                        }
                    }
                });
            }
    
        });     
    });


/* 
    =============================================
    Delete group
    ============================================== 
*/

    $(document).ready(function(){
        $(".delGroup").on("click", function(){
            id = $(this).attr("data-id");
            name = $(this).attr("data-name");

            swal({
                title: '¿Está seguro?',
                text: "El equipo " +name+ " se eliminará",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí, puede borrar!'
            }).then(function () {
                $.ajax({
                    url: "/del/grp/"+name+"/"+id,
                    type: 'POST'
                });
                document.location.reload(true);
            })  
        });
    });     




/* 
    =============================================
    Leads form
    ============================================== 
*/

function formLead(){
    $(document).ready(function(){
        $(document).on("click", "#send", function(){
            var formData  = $("#my_form").serialize();
            $.ajax({
                url: '/reg/lead',
                data: formData,
                type: 'POST' ,
                success:function(data){
				    swal({
                        title: 'Mensage enviada!',
                        type: 'success',
                        confirmButtonColor: '#4fa7f3'
                    }).then(function(){
					window.location.reload(); 
                })
			}	
            });
        });
    });
}

/* 
=============================================
Enroll to a free course
============================================== 
*/
function enrollFree(userId,courseId,url){
    $(document).ready(function(){
        $('body').loadingModal({
            position: 'auto',
            text: 'Estamos preparando su curso, usted será redirigido en breve...',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'foldingCube'
        });
        $.ajax({
            url: '/reg/enroll_product',
            data: {"student" : userId, "course" : courseId},
            type: 'POST' ,
            success:function(data){
                $('body').loadingModal('destroy');
                window.location.href=''+url+'';
			}	
        });
    });
}

/* 
=============================================
Enroll course into group
============================================== 
*/
function enrollCourseGroup(){
    $(document).ready(function(){
        $(document).on("click","#send", function(){
            var course = $(this).parent().children('select').val();
            var groupId = $("#groupId").val();
            swal({
                title: 'Agregar este curso a este grupo?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí'
            }).then(function () {
                $.ajax({
                    url: "/reg/enroll_course_group",
                    type: "POST",
                    data: {"course" : course, "groupId" : groupId},
                })
                document.location.reload(true);
            })  
            
        });
    });
}

/* 
=============================================
New program
============================================== 
*/
function newProgram(){
    $(document).ready(function(){
        $(document).on("click", "#sendProgram", function(){
            var formData = $("#register_form").serialize();
            var cont = 0;
            
            if($("#name").val() == ""){
                cont++;
                toastr.options.positionClass = 'toast-top-right';
                toastr.error("El campo de nombre debe completarse");
                return false;
            }
            if(cont!=0){    
                return false;
            }else{ 
                $.ajax({
                    url: '/reg/program',
                    type: "POST",
                    data: formData,
                    success: function(){
                        swal({
                            title: 'Programa agregado',
                            type: 'success',
                            confirmButtonColor: '#4fa7f3'
                        }).then(function(){
                            document.location.reload(true);
                        })
                    }
                });
            }
        })
        // Remove invalid field //
        $(document).on("focus", "[required]", function(){
            $(this).removeClass("invalid-field");
        });
    });
}

/* 
=============================================
Enroll user into group
============================================== 
*/
function enrollUserGroup(){
    $(document).ready(function(){
        $(document).on("click","#send_user", function(){
            var user = $("#user").val();
            var groupId = $("#groupId").val();
            swal({
                title: 'Agregar usuario al grupo?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí'
            }).then(function () {
                $.ajax({
                    url: "/reg/enroll_group",
                    type: "POST",
                    data: {"group" : groupId, "user" : user},
                })
                window.location.reload();
            })  
            
        });
    });
}

/* 
=============================================
Enroll program into group
============================================== 
*/
function enrollProgramGroup(){
    $(document).ready(function(){
        $(document).on("click","#send_program", function(){
            var program = $(this).parent().children('select').val();
            var groupId = $("#groupId").val();
            swal({
                title: 'Agregar este programa a este grupo?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí'
            }).then(function () {
                $.ajax({
                    url: "/reg/enroll_program_group",
                    type: "POST",
                    data: {"program" : program, "groupId" : groupId},
                });
                window.location.reload(); 
            })  
            
        });
    });
}

/* 
=============================================
Plugins
============================================== 
*/
function groupKit(){
    $(document).ready(function(){
       // Select2
       $(".select2").select2();

       $(".select2-limiting").select2({
           maximumSelectionLength: 2
       });

       // Default Datatable
       $('#datatable').DataTable();

       //Buttons examples
       var table = $('#datatable-buttons').DataTable({
           lengthChange: false,
           buttons: [
            { extend: 'pdf', className: 'ead btn-eadtools-light btn-md' },
            { extend: 'excel', className: 'ead btn-eadtools-light btn-md' },
        ]
       });

       // Key Tables

       $('#key-table').DataTable({
           keys: true
       });

       // Responsive Datatable
       $('#responsive-datatable').DataTable();

       // Multi Selection Datatable
       $('#selection-datatable').DataTable({
           select: {
               style: 'multi'
           }
       });

       table.buttons().container()
           .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

       // Default Datatable
       $('#datatable').DataTable();

       //Buttons examples
       var table = $('#datatable-users').DataTable({
           lengthChange: false,
           buttons: [
            { extend: 'pdf', className: 'ead btn-eadtools-light btn-md' },
            { extend: 'excel', className: 'ead btn-eadtools-light btn-md' },
        ]
       });

       // Key Tables

       $('#key-table').DataTable({
           keys: true
       });

       // Responsive Datatable
       $('#responsive-datatable').DataTable();

       // Multi Selection Datatable
       $('#selection-datatable').DataTable({
           select: {
               style: 'multi'
           }
       });

       table.buttons().container()
           .appendTo('#datatable-users_wrapper .col-md-6:eq(0)');

       // Default Datatable
       $('#datatable').DataTable();

       //Buttons examples
       var table = $('#datatable-program').DataTable({
           lengthChange: false,
           buttons: [
            { extend: 'pdf', className: 'ead btn-eadtools-light btn-md' },
            { extend: 'excel', className: 'ead btn-eadtools-light btn-md' },
        ]
       });

       // Key Tables

       $('#key-table').DataTable({
           keys: true
       });

       // Responsive Datatable
       $('#responsive-datatable').DataTable();

       // Multi Selection Datatable
       $('#selection-datatable').DataTable({
           select: {
               style: 'multi'
           }
       });

       table.buttons().container()
           .appendTo('#datatable-program_wrapper .col-md-6:eq(0)');

    });
}

/* 
=============================================
Delete user from group
============================================== 
*/
function delUserGroup(){
    $(document).ready(function(){
        $(document).on("click", "#remove_user", function(){
            var user = $(this).next('input').val();
            var groupId = $("#groupId").val();
            swal({
                title: 'Eliminar usuario de este grupo?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí'
            }).then(function () {
                $.ajax({
                    url: "/del/removeUserGroup",
                    type: "POST",
                    data: {"group" : groupId, "user" : user},
                });
                window.location.reload(); 
            })  
        })
    })
}

/* 
=============================================
Delete course from group
============================================== 
*/
function delCourseGroup(){
    $(document).ready(function(){
        $(document).on("click", "#remove_course", function(){
            var course = $(this).next('input').val();
            var groupId = $("#groupId").val();
            swal({
                title: 'Eliminar curso de este grupo?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí'
            }).then(function () {
                $.ajax({
                    url: "/del/delCourseGroup",
                    type: "POST",
                    data: {"group" : groupId, "course" : course},
                });
                window.location.reload();
            })  
        })
    })
}

/* 
=============================================
Delete program from group
============================================== 
*/
function delProgramGroup(){
    $(document).ready(function(){
        $(document).on("click", "#remove_program", function(){
            var program = $(this).next('input').val();
            var groupId = $("#groupId").val();
            swal({
                title: 'Eliminar programa de este grupo?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Sí'
            }).then(function () {
                $.ajax({
                    url: "/del/delProgramGroup",
                    type: "POST",
                    data: {"group" : groupId, "program" : program},
                });
                window.location.reload();
            })  
        })
    })
}






