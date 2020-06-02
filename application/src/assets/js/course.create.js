
// ---------- Start 
function ncrs(plan,baseurl){
    $(document).ready(function(){

        $(window).on('load', function(){
            $('.modal.fade').appendTo('#register_form');
        })

        // -------- Start progress bar
        bar1 = new ldBar("#myBar");

        // -------- Remove error class
        $(document).on("focus","input", function(){
            $(this).removeClass("verify-error");
        });

        // -------- Remove error class from textarea
        $(document).on("focus","textarea", function(){
            $(this).removeClass("verify-error");
        });

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

        // --------- Start tinymce
        tinymce.init({
            selector: "textarea#description",
            statusbar: false,
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            },
            toolbar: false,
            height:157,
            plugins: [
                "link lists preview hr anchor pagebreak",
                "emoticons paste textcolor"
            ],
            toolbar: " | bold italic | fontsizeselect | alignleft aligncenter alignright  | bullist numlist  |  preview media fullpage | forecolor backcolor",
        });


        // --------- Coin mask/
        var mask = {
            money: function() {
                var el = this
                ,exec = function(v) {
                v = v.replace(/\D/g,"");
                v = new String(Number(v));
                var len = v.length;
                if (1== len)
                v = v.replace(/(\d)/,"0.0$1");
                else if (2 == len)
                v = v.replace(/(\d)/,"0.$1");
                else if (len > 2) {
                v = v.replace(/(\d{2})$/,'.$1');
                }
                return v;
                };

                setTimeout(function(){
                el.value = exec(el.value);
                },1);
            }
        }

        $(function(){
            $('#price').bind('keypress',mask.money);
            $('#price').bind('keyup',mask.money)
        });

    

        // -------- Block/Unnlock module
        $(document).on("click", ".checkblock", function(e){
            var check = $(this).next("input");
            var el = $(this).find('i');
            if(check.prop("checked") == true){
                el.removeClass("mdi mdi-lock").addClass("mdi mdi-lock-open");
                check.prop("checked", false);
            }else{
                el.removeClass("mdi mdi-lock-open").addClass("mdi mdi-lock");
                check.prop("checked", true);
            }
        });



        // -------- Show content types in modal
        $(document).on("click",".moduleContent",function(e){
            e.preventDefault();
            var mod = $(this).attr("data-mod");// Get the module number
            $('#controler').val(mod); // Set the module number to control
            if(plan == "starter"){
            var imgExam = "lock.png";
            var imgWebinar = "lock.png";
            var imgVideo = "lock.png";
            var linkExam = "data-toggle='modal' data-target='#modalPlan'";
            var linkWebinar = "data-toggle='modal' data-target='#modalPlan' class='user-box'";
            var linkVideoCall = "data-toggle='modal' data-target='#modalPlan' class='user-box'";

            }
            if(plan == "pro"){
                var imgExam = "test.png";
                var imgWebinar = "webinar.png";
                var imgVideo = "videocall.png";
                var linkExam = 'id="exam"';
                var linkWebinar = "class='user-box webinar'";
                var linkVideoCall = "class='user-box videocall'";
            }

            if(plan == "enterprise"){
                var imgExam = "test.png";
                var imgWebinar = "webinar.png";
                var imgVideo = "videocall.png";
                var linkExam = 'id="exam"';
                var linkWebinar = "class='user-box webinar'";
                var linkVideoCall = "class='user-box videocall'";
            }

            
            if(plan == "trial"){
                var imgExam = "test.png";
                var imgWebinar = "webinar.png";
                var imgVideo = "videocall.png";
                var linkExam = 'id="exam"';
                var linkWebinar = "class='user-box webinar'";
                var linkVideoCall = "class='user-box videocall'";
            }
            swal({
                title: '<b>Contenido</b>',
                showCancelButton: false,
                showConfirmButton: false,
                html: '\
                <div class="row">\
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-ext="video"  class="user-box lessonContent">\
                            <div class="user-img">\
                                <img src="../assets/img/class/video.png" alt="user-img" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">Video</a> </h5>\
                        </div>\
                    </div>\
                    \
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-ext="audio" class="user-box lessonContent">\
                            <div class="user-img">\
                                <img src="../assets/img/class/audio.png" alt="user-img" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">Audio</a></h5>\
                        </div>\
                    </div>\
                    \
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-ext="pdf"  class="user-box lessonContent">\
                            <div class="user-img">\
                                <img src="../assets/img/class/pdf.png" alt="user-img" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">Pdf</a></h5>\
                        </div>\
                    </div>\
                    \
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-ext="downloaded"  class="user-box lessonContent">\
                            <div class="user-img">\
                                <img src="../assets/img/class/downloaded.png" alt="user-img" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">Archivos descargables</a></h5>\
                        </div>\
                    </div>\
                    \
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-toggle="modal" data-ext="exam" class="user-box"'+linkExam+'>\
                            <div class="user-img">\
                                <img src="../assets/img/class/'+imgExam+'" alt="user-img" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">Examen</a></h5>\
                        </div>\
                    </div>\
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-toggle="modal" '+linkWebinar+'>\
                            <div class="user-img">\
                                <img src="../assets/img/class/'+imgWebinar+'" alt="webinar" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">Webinar</a></h5>\
                        </div>\
                    </div>\
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-toggle="modal" '+linkVideoCall+'>\
                            <div class="user-img">\
                                <img src="../assets/img/class/'+imgVideo+'" alt="videocall" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">Video call</a></h5>\
                        </div>\
                    </div>\
                    <div class="col-xl-3">\
                        <div style="cursor:pointer" data-toggle="modal" class="user-box html">\
                            <div class="user-img">\
                                <img src="../assets/img/class/html.png" alt="html" class="img-thumbnail img-responsive">\
                            </div>\
                            <h5><a href="javascript:void(0);">HTML</a></h5>\
                        </div>\
                    </div>\
                </div>',
            })
        });
    });
}


// --------- Add modules dynamically 
function nModule(){ 
    $(document).ready(function(){
        var cont = 1000; // 1000....    
        var x = $("#newModule").val();
        var nextModule = parseInt(x) + parseInt(1);
        var prevModule = parseInt(x) - parseInt(1);
        $(document).on("click","#module",function(e){
            e.preventDefault();
            $('#class').append("\
            <li class='col-xl-12 mt-md-3 module'>\
                <div id='accordion'>\
                    <div class='card'>\
                        <div class='card-header' id='headingOne'>\
                            <h6 class='m-0'>\
                            <div class='input-group'>\
                            <input style='display:none;'class='position' type='number' value='"+x+"' name='position["+x+"]'>\
                            <input required type='text' class='form-control verify-module'  placeholder='Titulo del modulo' name='titleClass["+x+"]'>\
                            <!-- Time -->\
                            <!-- Modal -->\
                            <div class='modal fade' id='timemodal"+cont+"' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'\
                            aria-hidden='true'>\
                            <div class='modal-dialog modal-sm modal-side modal-top-right' role='document'>\
                                <div class='modal-content'>\
                                <div class='modal-header'>\
                                    <h5 class='modal-title' id='exampleModalLabel'>Establecer una fecha de lanzamiento del módulo</h5>\
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>\
                                    <span aria-hidden='true'>&times;</span>\
                                    </button>\
                                </div>\
                                <div class='modal-body'>\
                                    <div class='input-group-append'>\
                                        <input  name='releaseDateModule["+x+"]' maxlength='10' class='form-control' type='date'>\
                                    </div>\
                                    <hr>\
                                    <p>Si no se establece una fecha, el módulo estará disponible automáticamente.</p>\
                                </div>\
                                </div>\
                            </div>\
                            </div>\
                            \
                            \
                            <!-- Date time -->\
                            <div class='input-group-append' data-toggle='tooltip' data-placement='top' title='Fecha de lanzamiento del módulo'>\
                                <a data-toggle='modal' data-target='#timemodal"+cont+"' href='javascript:void(0)'>\
                                    <span data-mod='0'  name='0'  class='input-group-text btn-mdb-color'>\
                                        <i class='mdi mdi-clock text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            \
                            <!-- Add content -->\
                            <div class='input-group-append' data-toggle='tooltip' data-placement='top' title='Agregar lección'>\
                                <a href='javascript:void(0)'>\
                                    <span data-mod='"+x+"'  name='0' class='input-group-text btn-default moduleContent'>\
                                        <i class='mdi mdi-plus text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            \
                            <!-- Delete content content -->\
                            <div data-toggle='tooltip' data-placement='top' title='Eliminar este módulo' class='input-group-append'>\
                                <a href='javascript:void(0)'>\
                                    <span data-mod='0'  name='0'  class='input-group-text btn-red darken-1 remove_class'>\
                                        <i class='mdi mdi-trash-can text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            <!-- Move module -->\
                            <div data-toggle='tooltip' data-placement='top' title='Cambiar módulo de posición' class='input-group-append'>\
                                <a href='javascript:void(0)'>\
                                    <span data-mod='0'  name='0'  class='input-group-text btn-indigo handlerClasse'>\
                                        <i class='mdi mdi-cursor-move text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            <!-- Arrow -->\
                            <div data-toggle='tooltip' data-placement='top' title=''Expandir / contraer'' class='input-group-append'>\
                                <a href='#collapseOne"+cont+"' data-toggle='collapse' aria-expanded='true' aria-controls='collapseOne' href='javascript:void(0)'>\
                                    <span class='input-group-text btn-orange darken-4 handlerClasse'>\
                                        <i id='arrow' class='mdi mdi-arrow-up-thick text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            <!-- Block -->\
                            <div data-toggle='tooltip' data-placement='top' title='Cuando está bloqueado, el módulo se convierte en un requisito necesario para que el alumno pase al siguiente.' class='input-group-append checkblock'>\
                                <a href='javascript:void(0)'>\
                                    <span data-mod='0'  name='0'  class='input-group-text btn-deep-purple darken-2'>\
                                        <i class='mdi mdi-lock-open text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            <input id='check-"+x+"' name='requireToNext["+x+"]' type='checkbox' class='lockCheck'><label id='check-"+x+"' name='requireToNext["+x+"]'></label>\
                            </h6>\
                        </div>\
                        \
                        <div id='collapseOne"+cont+"' class='collapse show' aria-labelledby='headingOne' data-parent='#accordion'>\
                            <ol id='"+x+"'  class='row sortableContent'></ol>\
                        </div>\
                    </div>\
                </div>\
            </li>");

            // Append modal (Modal bug)
            $('.modal.fade').appendTo('#register_form');

            // Change arrow
            $(document).ready(function(){
                $(document).on("click",".changeArrow",function(e){
                    e.preventDefault();
                    var contentLi = $(this).parent().parent().parent().parent().parent().parent().find('ol').children();
                    if(!contentLi.length){
                    }else{
                        var classe = $(this).children().children().children().attr('class');
                        if (classe == "mdi mdi-arrow-down-thick"){
                            $(this).children().children().children().removeClass("mdi mdi-arrow-down-thick");
                            $(this).children().children().children().addClass("mdi mdi-arrow-up-thick");
                        }else{
                            $(this).children().children().children().removeClass("mdi mdi-arrow-up-thick");
                            $(this).children().children().children().addClass("mdi mdi-arrow-down-thick");
                        }
                    }
                })
            });

        
            // Start tooltip
            $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    
            
            // Start sortable
            $("ol.sortableClass").sortable({
                handle: '.handlerClasse',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                    $(this).find("input.position").val(index);
                    });
                }
            });
     
            cont++;
            x++;
            $("#newModule").val(nextModule);
        });

        $(document).on("click",".remove_class",function() {
            var classToDelete = $(this).closest('.col-xl-12');
            swal({
                title: "Cuidado!                ",
                text: "Usted está a punto de eliminar el módulo, ¿está seguro?",
                type: 'warning',
                showCancelButton: true,
                timer: 0
                }).then(
                function () {
                    $(".tooltip").tooltip("hide");
                    classToDelete.remove();
                    x--;
                    $("#newModule").val(prevModule);
                },
            )
        });  
    });
}




// ----------- Add new lesson
function nLesson(){
    $(document).ready(function(){
    positionControler = 0;
    var x = 0; // Initial field 
    var c = 100;
        $(document).on("click",".lessonContent",function(e){
            var ext = $(this).attr("data-ext");
            if(ext == "pdf"){ ext = ".pdf"; var size = "150"; var icon = "mdi mdi-file-pdf-box text-white"}
            if(ext == "video"){ ext = "video/*"; var size = "750"; icon="mdi mdi-play-circle text-white"}
            if(ext == "audio"){ ext = "audio/*"; var size = "750"; icon="mdi mdi-volume-high text-white"}
            if(ext == "downloaded"){ ext = ".xlsx, .xls, .csv, .docx, .pptx, .zip"; var size = "150"; icon="mdi mdi-download text-white"}       
            var controler = $('#controler').val();
            $('#'+controler+'').append("\
            <li style='padding-top:2%;' class='col-md-12 video'>\
                <div class='form-group row'>\
                    <div class='col-xl-8'>\
                        <div class='input-group'>\
                            <input  value='"+positionControler+"' type='number' class='positionLesson hide' name='positionLesson["+controler+"]["+positionControler+"]'>\
                            <input required placeholder='Titulo de la lección' type='text' name='titleLesson["+controler+"]["+positionControler+"]' class='form-control verify-lesson' />\
                            \
                            <label  for='fupload"+x+""+c+"' class='control-label label-bordered hide'>\
                                <i class='mdi mdi-cloud-upload mdi-18px'></i>&nbsp; \
                                <b class='fileName'>Seleccione un archivo</b>\
                            </label>\
                            \
                            <input data-icon='icon"+x+""+c+"'  required data-max-size='"+size+"' id='fupload"+x+""+c+"' type='file' accept='"+ext+"' name='lesson' class='fupload form-control hide  verify-lesson' />\
                            \
                            <input type='text' class='putFile hide' name='nameFile["+controler+"]["+positionControler+"]'> \
                            \
                            <input  type='text' class='realNameFile hide' name='realNameFile["+controler+"]["+positionControler+"]'> \
                            \
                            <div  data-click='fupload"+x+""+c+"' data-toggle='tooltip' data-placement='top' title='Editar esta lección' id='controlHop"+x+""+c+"'  class='input-group-append edit_lesson'>\
                                <a href='javascript:void(0)'>\
                                    <span class='input-group-text btn-default'>\
                                        <i id='icon"+x+""+c+"' class='"+icon+"'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            <div data-toggle='tooltip' data-placement='top' title='Eliminar esta lección' class='input-group-append'>\
                                <a href='javascript:void(0)'>\
                                    <span  class='input-group-text btn-red darken-1 remove_content'>\
                                        <i  class='mdi mdi-trash-can text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            <div data-toggle='tooltip' data-placement='top' title='Cambiar lección de posición' class='input-group-append'>\
                            <a href='javascript:void(0)'>\
                                <span data-mod='0'  name='0'  class='input-group-text btn-indigo handlerContent'>\
                                    <i class='mdi mdi-cursor-move text-white'></i>\
                                </span>\
                            </a>\
                        </div>\
                        </div>\
                    </div>\
                </div>\
            </li>");

            // Start sortable
            $("ol.sortableContent").sortable({
                handle: '.handlerContent',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                    $(this).find("input.positionLesson").val(index);
                    });
                }
            });  

            // Start tooltip
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
            });


            $("#controlerFile").val("fupload"+x+""+c+"");                       
            x++;   
            c++;
            positionControler = parseInt(positionControler) + parseInt(1);
            
            swal.close();
            var tst =  $("#controlerFile").val();
            $("#"+tst+"").click();
        });

        $(document).on("click",".remove_content",function() {
            var classToDelete = $(this).closest('li');
            swal({
                title: "Cuidado!                ",
                text: "Usted está a punto de eliminar esta lección, ¿está seguro?",
                type: 'warning',
                showCancelButton: true,
                timer: 0
                }).then(
                function () {
                    $(".tooltip").tooltip("hide");
                    classToDelete.remove();
                    positionControler--;
                    x--;
                },
            );
        });
    });
}




// ----------- Add new file
function nFile(){
    $(document).ready(function(){
        $(document).on("change", ".fupload", function(cb){

            // Define variables
            $ajaxCall = "Value";
            var el = $(this).next().next().next(); // Edit icon div
            var elId = $(this).next().next().next().attr("id");
            var myInput = $(this).next(".putFile"); // File name
            var realNameFile = $(this).next().next(); // Real name file input
            var fileInput = $(this); // File
            var fileInputId = $(this).attr("id");
            var fileName = cb.target.files[0].name; // File real name
            var targetTour = el.attr("id");

            // Put contron on bar
            $("#myBar").attr("data-fileinput", ""+fileInputId+"");
            $("#myBar").attr("data-el", ""+elId+"");

        
            // Put real name file
            realNameFile.val(fileName);

            // Update file name
            el.tooltip('dispose');
            el.tooltip();
            el.attr("title", ""+fileName+"");
            el.attr("data-original-title", ""+fileName+"");

           
            //aqui a sua função normal
            if (fileInput.get(0).files.length) {
                    var fileSize = fileInput.get(0).files[0].size; // in bytes                              
                    var formData = new FormData();
                    formData.append('lesson', $(this)[0].files[0]);

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

                    ajaxCall = $.ajax({
                        url: '/reg/lesson',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,    
                        xhr: function () {
                            var xhr = new XMLHttpRequest();

                            xhr.upload.onload = function (e) {
                                console.log("Starting loading....");
                            };

                            xhr.upload.onprogress = function (e) {
                                console.log("Total:"+e.total+" / Loaded: "+e.loaded+"");
                                // For uploads
                                if (e.lengthComputable) {
                                    var percent = Math.round(((e.loaded / e.total) *100));
                                    if(percent > 98){
                                        $("#myBar").hide();
                                        $("#progressMessage").show();
                                    }
                                    definirPercentualConcluido(percent); 
                                }else{
                                    console.log("Not computable");
                                }
                            };


                            xhr.upload.onerror = function (e) {
                                ajaxCall.abort();
                                console.log("Stop loading");
                                fileInput.val("");

                                ocultarMensagemDeEspera();

                                // Update tooltip
                                el.tooltip('dispose');
                                el.tooltip();
                                el.attr("title", "No hay archivos seleccionados");
                                el.attr("data-original-title", "No hay archivos seleccionados");

                                   // Tour to lesson
                                var tour = {
                                    id: "my-intro",
                                    steps: [
                                        {
                                            target: ''+targetTour+'',
                                            title: "<h3 class='text-danger' <i class='mdi mdi-close-circle-outline'> Error! la conexión se ha roto</h3>",
                                            content: "No se puede cargar el archivo: " +fileName+"",
                                            placement: 'bottom',
                                            zindex: 999
                                        }
                                    ],
                                    showPrevButton: false,
                                    showNextButton:false
                                };
                                // Start the tour!
                                hopscotch.startTour(tour);
                            };
                        
                            return xhr;
                        },
    
                        success: function(data){
                            definirPercentualConcluido(0); 
                            myInput.val(data);
                            ocultarMensagemDeEspera();
                            $("#myBar").show();
                            $("#progressMessage").hide();
                            
                            // Tour to lesson
                            var tour = {
                                id: "my-intro",
                                steps: [
                                    {
                                        target: ''+targetTour+'',
                                        title: "Archivo agregado",
                                        content: ""+fileName+"",
                                        placement: 'bottom',
                                        zindex: 999
                                    }
                                ],
                                showPrevButton: false,
                                showNextButton:false
                            };
                            // Start the tour!
                            hopscotch.startTour(tour);
                            setTimeout(function(){
                               hopscotch.endTour(tour);
                            }, 3000)
                        }
                    });
    
            } else {
                
            }
        });

        // -------- Edit file
        $(document).on("click", ".edit_lesson", function(){
            var el =  $(this).attr("data-click");
            $("#"+el+"").click();
            return false;
        });
    });
}


//-----------------Add webinar
function nWebinar(){
    $(document).ready(function() {
        control = 1;
        controlQuest = 1;
        var x = 1; // Initial field 
        var c = 90000;
        $(document).on("click",".webinar",function(e){
            e.preventDefault(); 
            swal.close();
            var controler = $('#controler').val();
            $('#'+controler+'').append("\
            <li style='padding-top:2%;' class='col-md-12 video' id='closeLi"+x+"'>\
                <div class='form-group row'>\
                    <div class='col-xl-8'>\
                        <div class='input-group'>\
                            <input value='"+positionControler+"' type='number' class='positionWebinar hide' name='positionWebinar["+controler+"]["+x+"]'>\
                            <input required placeholder='Titulo de lo webinar' type='text' name='titleWebinar["+controler+"]["+x+"]' class='form-control putTitle"+controler+""+x+""+c+"'/>\
                            \
                            <label id='fupload"+x+""+c+"' data-icon='icon"+x+""+c+"' for='fupload"+x+""+c+"' class='control-label label-bordered hide' data-toggle='modal' data-target='#myModalWebinar"+x+"'><i class='mdi mdi-check-box-outline mdi-18px'></i>&nbsp; <b class='fileName'>Haga clic para editar el webinar</b>\
                            </label>\
                            \
                            <input data-icon='icon"+x+""+c+"' class='show_question' type='text'>\
                            \
                            <div data-click='fupload"+x+""+c+"' data-toggle='tooltip' data-placement='top' title='Editar este webinar' class='input-group-append edit_webinar'>\
                                <a href='javascript:void(0)'>\
                                    <span class='input-group-text btn-default'>\
                                        <i id='icon"+x+""+c+"' class='mdi mdi-message-video text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            <div data-toggle='tooltip' data-placement='top' title='Eliminar este webinar' class='input-group-append remove_webinar'>\
                                <a href='javascript:void(0)'>\
                                    <span  class='input-group-text btn-red darken-1'>\
                                        <i  class='mdi mdi-trash-can text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            <div data-toggle='tooltip' data-placement='top' title='Cambiar webinar de posición' class='input-group-append'>\
                            <a href='javascript:void(0)'>\
                                <span data-mod='0'  name='0'  class='input-group-text btn-indigo handlerContent'>\
                                    <i class='mdi mdi-cursor-move text-white'></i>\
                                </span>\
                            </a>\
                        </div>\
                            \
                        </div>\
                    </div>\
                </div>\
            </li>\
            \
            <!-- Central Modal Medium Success -->\
            <div class='modal fade' data-backdrop='static' id='myModalWebinar"+x+"' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>\
                <div class='modal-dialog modal-notify modal-lg' role='document'>\
                    <!--Content-->\
                        <div class='modal-content'>\
                        <button data-close='closeLi"+x+"' style='text-align:right' type='button' class='close close-webinar' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\
                        <!--Body-->\
                            <div class='modal-body'>\
                                <div class='form_webinar'>\
                                    <!-- First step -->\
                                        <div class='text-center first_step'>\
                                            <h2>Informaciones  </h2><hr>\
                                            <h4>Titulo del webinar</h4>\
                                            <input data-info='titulo del webinar' maxlength='100' type='text' class='text-field myTitle verify-webinar' id='putTitle"+controler+""+x+""+c+"'>\
                                            <h4>URL del webinar</h4>\
                                            <input required placeholder='Ex: https://zoom.com/tu-sala' type='text' data-info='url del webinar' name='urlWebinar["+controler+"]["+x+"]' class='text-field verify-webinar'/>\
                                            <h4>Descripcion del webinar</h4>\
                                            <textarea data-info='descripcion' name='webinarDescription["+controler+"]["+x+"]' type='text' class='text-field verify-webinar'></textarea>\
                                            <h4>¿Cuál es la fecha de lo webinar ?</h4>\
                                            <div class='input-group'>\
                                                <input data-info='fecha de lo webinar' name='dateWebinar["+controler+"]["+x+"]' type='date' class='text-field datepicker verify-webinar' placeholder='mm/dd/yyyy' id='datepicker'>\
                                            </div><!-- input-group -->\
                                            <h4>¿A qué hora es el webinar?</h4>\
                                            <div class='input-group'>\
                                                <input data-info='hora del webinar' name='timeWebinar["+controler+"]["+x+"]' type='text' id='timepicker' class='text-field timepicker verify-webinar'>\
                                            </div><!-- input-group -->\
                                            <!--Footer-->\
                                            </br>\
                                            <button type='button' class='ead btn-eadtools-light save_webinar'>GUARDAR <i class='mdi mdi-content-save text-white'></i> </button>\
                                        </div>\
                                        \
                                    </div>\
                                </div>\
                            </div>\
                            <!--/.Content-->\
                        </div>\
                    </div>\
                <!-- Central Modal Medium Success--></input>\
            ");

            // Close modal
            $(".close-webinar").on("click", function(){
                // Remove li
                var close = $(this).attr("data-close");
                $("#"+close+"").remove();

                // Remove modal
                var el = $(this).closest(".modal");
                el.remove();
            });

            // Append modal (Modal bug)
            $('.modal.fade').appendTo('#register_form');

            // Time Picker
            $(".timepicker").each(function(){
                $(this).timepicker({
                    defaultTIme : false,
                    icons: {
                        up: 'mdi mdi-chevron-up',
                        down: 'mdi mdi-chevron-down'
                    }
                });
            });

            // Tooltip
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
            })  


            // Click on edit webinar (open modal)
            $(".edit_webinar").on("click", function(){
                var el =  $(this).attr("data-click");
                $("#"+el+"").click();
            });
                       
            // Sortable
            $("ol.sortableContent").sortable({ 
                handle: '.handlerContent',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                    $(this).find("input.positionWebinar").val(index);
                    });
                }
            });
            
            // Start popover
            $('[data-toggle="popover"]').popover();
                       
            // Control to click in this webinar
            $("#controlerFile").val("fupload"+x+""+c+"");
                      
            x++;   
            c++;   
            control = parseInt(control) + parseInt(1);
            positionControler = parseInt(positionControler) + parseInt(1);
                
            swal.close();
            var tst =  $("#controlerFile").val();
            $("#"+tst+"").parent().children('.label-bordered').click();
        });

        // Save webinar
        $(document).on("click",".save_webinar",function(){
            var cont = 0;
            $(".verify-webinar").each(function(){
                var info = $(this).attr("data-info");
                if($(this).val() == ""){
                    cont++;
                    toastr.error('El campo '+info+' es obligatorio');
                    $(this).addClass("verify-error");
                    return false;
                }
            });

            if(cont == 0){
                var examName = $(this).closest('.form_webinar').children().children('.myTitle').val();
                var examPlaceId = $(this).closest('.form_webinar').children().children('.myTitle').attr("id");
                $("."+examPlaceId+"").val(examName); 
                $(this).closest(".modal").modal("toggle");
            }              
        });
        
        // Remove added webinar
        $(document).on("click",".remove_webinar",function() {
            var classToDelete = $(this).closest('li');
            swal({
                title: "Cuidado!                ",
                text: "Usted está a punto de eliminar este webinar, ¿está seguro?",
                type: 'warning',
                showCancelButton: true,
                timer: 0
                }).then(
                function () {
                    $('body').tooltip('dispose');
                    classToDelete.remove();
                    positionControler--;
                    x--;
                },
            );
        });
    });
}


//-----------------Add HTML
function nHtml(){
    $(document).ready(function() {
        control = 1;
        var x = 1; // Initial field 
        var c = 20000;
        $(document).on("click",".html",function(e){
            e.preventDefault(); 
            swal.close();
            var controler = $('#controler').val();
            $('#'+controler+'').append("\
            <li style='padding-top:2%;' class='col-md-12' id='closeLi"+x+"'>\
                <div class='form-group row'>\
                    <div class='col-xl-8'>\
                        <div class='input-group'>\
                            <input value='"+positionControler+"' type='number' class='positionHtml hide ' name='positionHtml["+controler+"]["+x+"]'>\
                            <input required placeholder='Titulo del HTML' type='text' name='titleHtml["+controler+"]["+x+"]' class='form-control putTitle"+controler+""+x+""+c+"'/>\
                            \
                            <label id='fupload"+x+""+c+"' data-icon='icon"+x+""+c+"' for='fupload"+x+""+c+"' class='control-label label-bordered hide' data-toggle='modal' data-target='#myModalHtml"+x+"'><i class='mdi mdi-check-box-outline mdi-18px'></i>&nbsp; <b class='fileName'>Haga clic para editar el HTML</b>\
                            </label>\
                            \
                            <input data-icon='icon"+x+""+c+"' class='show_question' type='text'>\
                            \
                            <div data-click='fupload"+x+""+c+"' data-toggle='tooltip' data-placement='top' title='Editar HTML' class='input-group-append edit_html'>\
                                <a href='javascript:void(0)'>\
                                    <span class='input-group-text btn-default'>\
                                        <i id='icon"+x+""+c+"' class='mdi mdi-language-html5                  text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            <div data-toggle='tooltip' data-placement='top' title='Eliminar HTML' class='input-group-append remove_html'>\
                                <a href='javascript:void(0)'>\
                                    <span  class='input-group-text btn-red darken-1'>\
                                        <i  class='mdi mdi-trash-can text-white'></i>\
                                    </span>\
                                </a>\
                            </div>\
                            \
                            <div data-toggle='tooltip' data-placement='top' title='Cambiar HTML de posición' class='input-group-append'>\
                            <a href='javascript:void(0)'>\
                                <span data-mod='0'  name='0'  class='input-group-text btn-indigo handlerContent'>\
                                    <i class='mdi mdi-cursor-move text-white'></i>\
                                </span>\
                            </a>\
                        </div>\
                            \
                        </div>\
                    </div>\
                </div>\
            </li>\
            \
            <!-- Central Modal Medium Success -->\
            <div class='modal fade' data-backdrop='static' id='myModalHtml"+x+"' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>\
                <div class='modal-dialog modal-notify modal-lg' role='document'>\
                    <!--Content-->\
                        <div class='modal-content'>\
                        <button data-close='closeLi"+x+"' style='text-align:right' type='button' class='close close-html' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\
                        <!--Body-->\
                            <div class='modal-body'>\
                                <div class='form_html'>\
                                    <!-- First step -->\
                                        <div class='first_step'>\
                                            <h2 class='text-center'>Informaciones  </h2></br>\
                                            <div class='text-center'>\
                                                <span class='badge badge-default text-center'>Su proyecto html debe estar comprimido en formato .zip                                            y debe contener el archivo index.html en su raíz.\
                                            </span></br>\
                                            </div></br>\
                                            <h4>Titulo</h4>\
                                            <input data-info='titulo del HTML' maxlength='100' type='text' class='text-field myTitle verify-html' id='putTitle"+controler+""+x+""+c+"'></br>\
                                            <h4>Archivo</h4>\
                                            <input data-info='archivo' accept='.zip' type='file' class='dropify uploadHtml verify-html' />\
                                            <input class='putFile hide' type='text' name='directoryHtml["+controler+"]["+x+"]'>\
                                            </br>\
                                            <!--Footer-->\
                                            </br>\
                                            <button type='button' class='ead btn-eadtools-light save_html'>GUARDAR <i class='mdi mdi-content-save text-white'></i> </button>\
                                        </div>\
                                        \
                                    </div>\
                                </div>\
                            </div>\
                            <!--/.Content-->\
                        </div>\
                    </div>\
                <!-- Central Modal Medium Success--></input>\
            ");

            // Dropify initiate
            $('.dropify').dropify()

            // Close modal
            $(".close-html").on("click", function(){
                // Remove li
                var close = $(this).attr("data-close");
                $("#"+close+"").remove();

                // Remove modal
                var el = $(this).closest(".modal");
                el.remove();
            });

            // Append modal (Modal bug)
            $('.modal.fade').appendTo('#register_form');

            // Time Picker
            $(".timepicker").each(function(){
                $(this).timepicker({
                    defaultTIme : false,
                    icons: {
                        up: 'mdi mdi-chevron-up',
                        down: 'mdi mdi-chevron-down'
                    }
                });
            });

            // Tooltip
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
            })  


            // Click on edit webinar (open modal)
            $(".edit_html").on("click", function(){
                var el =  $(this).attr("data-click");
                $("#"+el+"").click();
            });
                       
            // Sortable
            $("ol.sortableContent").sortable({ 
                handle: '.handlerContent',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                    $(this).find("input.positionHtml").val(index);
                    });
                }
            });
            
            // Start popover
            $('[data-toggle="popover"]').popover();
                       
            // Control to click in this html
            $("#controlerFile").val("fupload"+x+""+c+"");
                      
            x++;   
            c++;   
            control = parseInt(control) + parseInt(1);
            positionControler = parseInt(positionControler) + parseInt(1);
                
            swal.close();
            var tst =  $("#controlerFile").val();
            $("#"+tst+"").parent().children('.label-bordered').click();
        });

        // Save html
        $(document).on("click",".save_html",function(){
            var cont = 0;
            $(".verify-html").each(function(){
                var info = $(this).attr("data-info");
                if($(this).val() == ""){
                    cont++;
                    toastr.error('El campo '+info+' es obligatorio');
                    $(this).addClass("verify-error");
                    return false;
                }
            });

            if(cont == 0){
                var examName = $(this).closest('.form_html').children().children('.myTitle').val();
                var examPlaceId = $(this).closest('.form_html').children().children('.myTitle').attr("id");
                $("."+examPlaceId+"").val(examName); 
                $(this).closest(".modal").modal("toggle");
            }              
        });
        
        // Remove added html
        $(document).on("click",".remove_html",function() {
            var classToDelete = $(this).closest('li');
            swal({
                title: "Cuidado!                ",
                text: "Usted está a punto de eliminar este webinar, ¿está seguro?",
                type: 'warning',
                showCancelButton: true,
                timer: 0
                }).then(
                function () {
                    $('body').tooltip('dispose');
                    classToDelete.remove();
                    positionControler--;
                    x--;
                },
            );
        });
    });
}


 // -----------------Add Video call
function nVideoCall(){
$(document).ready(function() {
    control = 1;
    controlQuest = 1;
    var x = 1; // Initial field 
    var c = 12000;
        $(document).on("click",".videocall",function(e){
            swal.close();
            e.preventDefault(); 
            var controler = $('#controler').val();
            $('#'+controler+'').append("\
            <li style='padding-top:2%;' class='col-md-12 video' id='closeLi"+x+"'>\
                <div class='form-group row'>\
                    <div class='col-xl-8'>\
                        <div class='input-group'>\
                            <input style='display:none' value='"+positionControler+"' type='number' class='positionVideocall' name='positionVideoCall["+controler+"]["+x+"]'>\
                            <input required placeholder='Titulo de la video call' type='text' name='titleVideoCall["+controler+"]["+x+"]' class='form-control putTitle"+controler+""+x+""+c+"'/>\
                            \
                            <label id='fupload"+x+""+c+"' data-icon='icon"+x+""+c+"' for='fupload"+x+""+c+"' class='control-label label-bordered hide' data-toggle='modal' data-target='#myModalVideocall"+x+"'><i class='mdi mdi-check-box-outline mdi-18px text-white'></i>&nbsp; <b class='fileName'>Haga clic para editar la Videocall</b>\
                            </label>\
                            \
                            <input  class='show_question' type='text'>\
                            \
                            <div data-click='fupload"+x+""+c+"' data-toggle='tooltip' data-placement='top' title='Editar esta videocall' class='input-group-append edit_videocall'>\
                            <a href='javascript:void(0)'>\
                                <span class='input-group-text btn-default'>\
                                    <i id='icon"+x+""+c+"' class='mdi mdi-video text-white'></i>\
                                </span>\
                            </a>\
                        </div>\
                        <div data-toggle='tooltip' data-placement='top' title='Eliminar esta videocall' class='input-group-append remove_videocall'>\
                            <a href='javascript:void(0)'>\
                                <span  class='input-group-text btn-red darken-1'>\
                                    <i  class='mdi mdi-trash-can text-white'></i>\
                                </span>\
                            </a>\
                        </div>\
                        \
                        <div data-toggle='tooltip' data-placement='top' title='Cambiar videocall de posición' class='input-group-append'>\
                        <a href='javascript:void(0)'>\
                            <span data-mod='0'  name='0'  class='input-group-text btn-indigo handlerContent'>\
                                <i class='mdi mdi-cursor-move text-white'></i>\
                            </span>\
                        </a>\
                    </div>\
                            \
                        </div>\
                    </div>\
                </div>\
            </li>\
            \
            <!-- Central Modal Medium Success -->\
            <div class='modal fade' id='myModalVideocall"+x+"' data-backdrop='static' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>\
                <div class='modal-dialog modal-notify modal-lg' role='document'>\
                    <!--Content-->\
                        <div class='modal-content'>\
                        <button data-close='closeLi"+x+"' style='text-align:right' type='button' class='close close-call' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\
                        <!--Body-->\
                            <div class='modal-body'>\
                                <div class='form_call'>\
                                    <!-- First step -->\
                                        <div class='text-center first_step'>\
                                            <h2>Informaciones  </h2><hr>\
                                            <h4>Titulo del video call</h4>\
                                            <input data-info='titulo del video call' type='text' class='text-field myTitle verify-call' id='putTitle"+controler+""+x+""+c+"'>\
                                            <h4>Descripcion del video call</h4>\
                                            <textarea data-info='descripcion del video call' name='videoCallDescription["+controler+"]["+x+"]' type='text' class='text-field verify-call'></textarea>\
                                            <h4>¿Cuál es la fecha de la video call ?</h4>\
                                            <div class='input-group'>\
                                                <input data-info='fecha de la video call' name='dateVideoCall["+controler+"]["+x+"]' type='date' class='text-field datepicker verify-call' placeholder='mm/dd/yyyy' id='datepicker'>\
                                            </div><!-- input-group -->\
                                            <h4>¿A qué hora es el video call?</h4>\
                                            <div class='input-group'>\
                                                <input data-info='hora del video call' name='timeVideoCall["+controler+"]["+x+"]' type='text' id='timepicker' class='text-field timepicker verify-call'>\
                                            </div><!-- input-group -->\
                                            <!--Footer-->\
                                            </br>\
                                            <button type='button' class='ead btn-eadtools-light save_call'>GUARDAR <i class='mdi mdi-content-save'></i> </button>\
                                        </div>\
                                        \
                                    </div>\
                                </div>\
                            </div>\
                            <!--/.Content-->\
                        </div>\
                    </div>\
                <!-- Central Modal Medium Success--></input>\
            ");

            // Close modal
            $(".close-call").on("click", function(){
                // Remove li
                var close = $(this).attr("data-close");
                $("#"+close+"").remove();

                // Remove modal
                var el = $(this).closest(".modal");
                el.remove();
            });

            // Append modal (Modal bug)
            $('.modal.fade').appendTo('#register_form');

            // Time Picker
            $(".timepicker").each(function(){
                $(this).timepicker({
                    defaultTIme : false,
                    icons: {
                        up: 'mdi mdi-chevron-up',
                        down: 'mdi mdi-chevron-down'
                    }
                });
            });

            //Start tooltip
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
            });  

            // Edit videocall to click
            $(".edit_videocall").on("click", function(){
                var el =  $(this).attr("data-click");
                $("#"+el+"").click();
            });
                       
            // Sortable
            $("ol.sortableContent").sortable({ 
                handle: '.handlerContent',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                    $(this).find("input.positionVideocall").val(index);
                    });
                }
            });
            
            // Start popover
            $('[data-toggle="popover"]').popover();
            
            // Controler to click
            $("#controlerFile").val("fupload"+x+""+c+"");
                    
            x++;   
            c++;   
            control = parseInt(control) + parseInt(1);
            positionControler = parseInt(positionControler) + parseInt(1);
            
            swal.close();
            var tst =  $("#controlerFile").val();
            $("#"+tst+"").parent().children('.label-bordered').click();
        });

        
        // Save videocall
        $(document).on("click",".save_call",function(){
            var cont = 0;
            $(".verify-call").each(function(){
                var info = $(this).attr("data-info");
                if($(this).val() == ""){
                    cont++;
                    toastr.error('El campo '+info+' es obligatorio');
                    $(this).addClass("verify-error");
                    return false;
                }
            });

            if(cont == 0){
                var examName = $(this).closest('.form_call').children().children('.myTitle').val();
                var examPlaceId = $(this).closest('.form_call').children().children('.myTitle').attr("id");
                $("."+examPlaceId+"").val(examName); 
                $(this).closest(".modal").modal("toggle");
            }                        
        });
        
        // Remove added video call
        $(document).on("click",".remove_videocall",function() {
            var classToDelete = $(this).closest('li');
            swal({
                title: "Cuidado!                ",
                text: "Usted está a punto de eliminar esta videocall, ¿está seguro?",
                type: 'warning',
                showCancelButton: true,
                timer: 0
                }).then(
                function () {
                    $('body').tooltip('dispose');
                    classToDelete.remove();
                    positionControler--;
                    x--;
                },
            );
        });
    });
}

// -----------Add exam
function nExam(){
    $(document).ready(function() {
        control = 1;
        controlQuest = 1;
        var x = 1; // Initial field 
        var c = 6000;
        $(document).on("click","#exam",function(e){
            firstQuestion = 1;
            swal.close();
            e.preventDefault(); 
            var controler = $('#controler').val();
            $('#'+controler+'').append("\
            <li style='padding-top:2%;' class='col-md-12 video' id='closeLi"+x+"'>\
                <div class='form-group row'>\
                    <div class='col-xl-8'>\
                        <div class='input-group'>\
                            <input style='display:none' value='"+positionControler+"' type='number' class='positionLesson' name='positionExam["+controler+"]["+x+"]'>\
                            <input required placeholder='Titulo de lo exam' type='text' name='titleExam["+controler+"]["+x+"]' class='form-control putTitle"+controler+""+x+""+c+"'/>\
                            \
                            <label id='fupload"+x+""+c+"' for='fupload"+x+""+c+"' class='control-label label-bordered hide' data-toggle='modal' data-target='#myModalMultiple"+x+"'><i class='mdi mdi-check-box-outline mdi-18px'></i>&nbsp; <b class='fileName'>Haga clic para editar el examen</b>\
                            </label>\
                            \
                            <input class='show_question' type='text'>\
                            \
                            <div data-click='fupload"+x+""+c+"' data-toggle='tooltip' data-placement='top' title='Editar este examen' class='input-group-append edit_exam'>\
                                <a href='javascript:void(0)'>\
                                    <span class='input-group-text btn-default text-white'>\
                                        <i id='icon"+x+""+c+"' class='mdi mdi-comment-question text-white'></i>\
                                    </span>\
                                </a>\
                        </div>\
                        <div data-toggle='tooltip' data-placement='top' title='Eliminar este examen' class='input-group-append remove_exam'>\
                            <a href='javascript:void(0)'>\
                                <span  class='input-group-text btn-red darken-1 text-white'>\
                                    <i  class='mdi mdi-trash-can text-white'></i>\
                                </span>\
                            </a>\
                        </div>\
                        \
                        <div data-toggle='tooltip' data-placement='top' title='Cambiar webinar de posición' class='input-group-append'>\
                        <a href='javascript:void(0)'>\
                            <span data-mod='0'  name='0'  class='input-group-text btn-indigo handlerContent text-white'>\
                                <i class='mdi mdi-cursor-move text-white'></i>\
                            </span>\
                        </a>\
                    </div>\
                            \
                        </div>\
                    </div>\
                </div>\
            </li>\
            \
            <!-- Central Modal Medium Success -->\
            <div class='modal fade' data-backdrop='static' data-keyboard='false' id='myModalMultiple"+x+"' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>\
                <div class='modal-dialog modal-notify modal-lg' role='document'>\
                    <!--Content-->\
                        <div class='modal-content'>\
                        <button data-close='closeLi"+x+"' style='text-align:right' type='button' class='close close-exam' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>\
                        <!--Body-->\
                            <div class='modal-body'>\
                                <div class='form_exam'>\
                                    <!-- First step -->\
                                        <div class='text-center first_step'>\
                                            <h2>Informaciones</h2><hr>\
                                            <h4>Título del examen</h4>\
                                            <input data-name='titulo del examen'  type='text' class='text-field myTitle verifyExamInitial' id='putTitle"+controler+""+x+""+c+"'>\
                                            <h4>¿Cuántos minutos dura el examen?</h4>\
                                            <!-- Timing -->\
                                                <div class='form-group'>\
                                                    <input id='controlTime"+x+"' class='modeTime' checked type='checkbox' data-plugin='switchery'/>\
                                                    <small id='emailHelp' class='form-text text-muted'>Deshabilite para que no haya tiempo de examen.</small>\
                                                </div>\
                                            <input data-name='duración del examen' min='1' onKeyUp='if( this.value>99){}else if(this.value<0){this.value=1;}' max='10000'  type='number' required name='timing["+x+"]' class='text-field verifyExamInitial'>\
                                            <h4>¿Cuál es el porcentaje mínimo de aprobación?</h4>\
                                            <input data-name='porcentaje mínimo de aprobación' required min='1' onKeyUp='if(this.value>99){this.value=100;}else if(this.value<0){this.value=0;}' max='100'  type='number' name='approval["+x+"]' class='text-field verifyExamInitial'>\
                                            <!--Footer-->\
                                            <div class='modal-footer justify-content-center'>\
                                                <button type='button' class='ead btn-eadtools-light next_step'>SIGUIENTE <i class='mdi mdi-arrow-right-thick'></i> </button>\
                                            </div>\
                                        </div>\
                                        \
                                        <!-- Second step -->\
                                        <div class='text-center second_step' style='display:none;'>\
                                        <h2>Preguntas</h2>\
                                        <span>Haga clic en cualquier pregunta para agregarla</span>\
                                        <hr>\
                                            <div class='questions'>\
                                                <!-- Multiple choice -->\
                                                <a class='multiple_question' style='padding-right:5%;' data-place='place_question"+controler+""+x+"' data-nav='place_question_nav"+controler+""+x+"' href='#'><i style='margin-right:2%'margin-top:10%; class='fas fa-plus fa-2x'></i><img data-toggle='tooltip' data-placement='top' title='Opción múltiple' style='width:10%;' src='/assets/img/callback/multiple_question.png' alt='Multiple choice'></a>\
                                                \
                                                <!-- Descriptive question -->\
                                                <a class='descriptive_question' style='padding-right:5%;' data-place='place_question"+controler+""+x+"' data-nav='place_question_nav"+controler+""+x+"' href='#'><i style='margin-top:10%'; class='fas fa-plus fa-2x'></i><img data-toggle='tooltip' data-placement='top' title='Pregunta descriptiva' style='width:10%;' src='/assets/img/callback/descriptive_question.png' alt='Descriptive question'></a>\
                                                <!-- Free question -->\
                                                <a class='free_question' data-place='place_question"+controler+""+x+"' data-nav='place_question_nav"+controler+""+x+"' href='#'><i style='margin-top:10%;' class='fas fa-plus fa-2x'></i><img data-toggle='tooltip' data-placement='top' title='Pregunta libre' style='width:10%;' src='/assets/img/callback/free_question.png' alt='Free question'></a>\
                                            </div>\
                                            <!-- Here start the questions navigation -->\
                                            <div class='row'>                           \
                                                <!-- Question navigation -->\
                                                <div class='col-4'>\
                                                    <div class='list-group list-group-horizontal-xl' id='list-tab' role='tablist'>\
                                                        <ol class='sortableQuestion'  id='place_question_nav"+controler+""+x+"'>\
                                                        </ol>\
                                                    </div>\
                                                </div> <!-- End question navigation -->\
                                                \
                                                <div class='col-8'>\
                                                    <div class='tab-content' id='place_question"+controler+""+x+"' style='display:none'>\
                                                        <!-- Question content here --->\
                                                    </div> <!-- End of tab content -->\
                                                </div><!-- End of question content -->\
                                            </div><!-- End of row -->\
                                            <!--Footer-->\
                                            <div class='modal-footer justify-content-center'>\
                                                <button type='button' class='ead btn-eadtools-light prev_step'>ANTERIOR <i class=' mdi mdi-arrow-left-thick'></i> </button>\
                                                <button data-close='myModalMultiple"+x+"'  type='button' class='ead btn-eadtools-light save_exam'>GUARDAR <i class='mdi mdi-content-save'></i> </button>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                            <!--/.Content-->\
                        </div>\
                    </div>\
                <!-- Central Modal Medium Success--></input>\
            ");

            // Select2
            $(".select2").select2();

            // Steps navigation
            $(document).ready(function(){
                $(document).on("click", ".next_step", function(){
                    var cont = 0;
                    var el = $(this).parent().parent();
                    el.children(".verifyExamInitial").each(function(){
                        var text = $(this).attr("data-name");
                        if($(this).val() == ""){
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.error('El campo '+text+' debe ser completado.');
                            $(this).addClass("verify-error");
                            cont++;
                            return false;
                        }
                    });

                    if(cont == 0){
                        $(this).parent().parent('.first_step').hide();
                        $(this).parent().parent('.first_step').next('.second_step').fadeIn("slow");
                    }          
                });

                $(document).on("click", ".prev_step", function(){
                    $(this).closest('.second_step').hide();
                    $(this).closest('.second_step').prev('.first_step').fadeIn("slow");
                })
            });

                    
            // Adjust the modal
            $('.modal.fade').appendTo('#register_form');

            // Close modal
            $(".close-exam").on("click", function(){
                // Remove li
                var close = $(this).attr("data-close");
                $("#"+close+"").remove();

                // Remove modal
                var el = $(this).closest(".modal");
                el.remove();

            });

            //Sortable 
            $("ol.sortableContent").sortable({ 
                handle: '.handlerContent',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                    $(this).find("input.positionLesson").val(index);
                    });
                }
            });

            //Start tooltip
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
            });

            // Edit exam click
            $(".edit_exam").on("click", function(){
                var el =  $(this).attr("data-click");
                $("#"+el+"").click();
            });
                    
            //Start switchery
            var elem = document.querySelector('#controlTime'+x+'');
            var init = new Switchery(elem); // put option after elem attribute

            // Start popover
            $('[data-toggle="popover"]').popover();
            
            // Control to click
            $("#controlerFile").val("fupload"+x+""+c+"");
                   
            x++;   
            c++;   
            control = parseInt(control) + parseInt(1);
            positionControler = parseInt(positionControler) + parseInt(1);
                
            swal.close();
            var tst =  $("#controlerFile").val();
            $("#"+tst+"").parent().children('.label-bordered').click();
        });

        // Save exam
        $(document).on("click",".save_exam",function(){
            var cont = 0;
            var close = $(this).attr("data-close");
            // Verify if exam have questions
            $(".tab-content").each(function(){
                var el = $(this).children().attr('class');
                if(el == null){
                    toastr.error('Sus exámenes deben contener al menos una pregunta');
                    cont++;
                }
            });

            if(cont != 0){
                return false;
            }

            $(".questionValidation").each(function(){
                if($(this).val() == ""){
                    var text = $(this).attr("data-name");
                    toastr.error('La '+text+' está vacía. ');
                    cont++;
                }
            });

            if(cont != 0){
                return false;
            }

            // Verify if all multiple question have answer
            $(".verifyAnswer").each(function(){
                var check = $(this);
                var text = $(this).attr("data-name");
                var el = $(this).children('div');
                var verify = el.attr("class");
                var correct = 0;
                if(verify == null){
                    cont++;
                    toastr.error('La '+text+' no tiene respuesta');
                }

                if(cont != 0){
                    return false;
                }
                
                var el = $(this).find('.custom-control.custom-radio');
                $(el).each(function(){
                    var text = $(this).attr("data-name");
                    var radioInput = $(this).children();
                    if(radioInput.is(":checked")){
                        correct++;  
                    } 
                });

                if(correct == 0){
                    cont++;
                    toastr.error('Olvidaste marcar una respuesta correcta a la '+text+'');
                }

                if(cont != 0){
                    return false;
                }
            }); // End verification

            if(cont == 0){
                var examName = $(this).closest('.form_exam').children().children('.myTitle').val();
                var examPlaceId = $(this).closest('.form_exam').children().children('.myTitle').attr("id");
                $("."+examPlaceId+"").val(examName);
                $("#"+close+"").modal("toggle");

            }               
        });
        
        // Remove added exam
        $(document).on("click",".remove_exam",function() {
            var classToDelete = $(this).closest('li');
            swal({
                title: "Cuidado!                ",
                text: "Usted está a punto de eliminar este examen, ¿está seguro?",
                type: 'warning',
                showCancelButton: true,
                timer: 0
                }).then(
                function () {
                    $('body').tooltip('dispose');
                    classToDelete.remove();
                    positionControler--;
                    x--;
                },
            );
        });
    });
}

function nQuestion(){
    // Add multiple question
    $(document).ready(function() {  
        var x = 1;
        $(document).on("click", ".multiple_question", function(e){
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 10;
            toastr.options.preventDuplicates = true;
            toastr.options.timeOut = 1500;
            toastr.options.closeEasing = 'swing';
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.success('Pregunta de opción múltiple agregada');
            var exam = $(this).attr('data-place').charAt(15);
            var questionPlace = $(this).attr('data-place');
            var questionPlaceNav = $(this).attr('data-nav');
            $(".tab-content").show();
            $(".order").show();

            if(firstQuestion == 1){
                style = "active-question";
            }else{
                style = "";
            }

            var addMultiple = $("\
            <li id='question"+x+"' class='list-group-item text-white pointer navQuestions "+style+" '>\
                <i data-toggle='tooltip' data-placement='top' title='Borrar' class='mdi mdi-trash-can mdi-18px md-6 text-danger pointer remove_question'></i>\
                <i data-toggle='tooltip'  data-placement='top' title='Mover' class='mdi mdi-cursor-move mdi-18px md-6 text-primary pointer handlerQuestion' style='padding-right:10%;'></i> <span class='question_text'>Pregunta "+firstQuestion+"</span>  \
                <input type='number' name='positionQuestion["+exam+"]["+controlQuest+"]'  class='position_question hide' value="+x+">\
            </li>\
            ");

            if(firstQuestion == 1){
                var display = "";
            }else{
                var display = "style='display:none;'";
            }
            var addContentMultiple = $("\
                <div "+display+" class='question"+x+" myContent'>\
                    <h3 class='text-left text-info'>Opción múltiple</h3>\
                    <hr>\
                    <h5 class='text-left'>Peso de la pregunta</h5>\
                    <div class='wrap'>\
                    <div class='stars'>\
                        <input style='display:none' class='putWeight' value='1' type='number' name='questionWeight["+exam+"]["+controlQuest+"]'>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='1'>\
                            <div class='face'></div>\
                            <i class='fas fa-star star one-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='2'>\
                            <div class='face'></div>\
                            <i class='far fa-star star two-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='3'>\
                            <div class='face'></div>\
                            <i class='far fa-star star three-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='4' >\
                            <div class='face'></div>\
                            <i class='far fa-star star four-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='5'>\
                            <div class='face'></div>\
                            <i class='far fa-star star five-star'></i>\
                        </label>\
                    </div>\
                    </div>\
                    <h5 class='text-left'>Escribe tu pregunta</h5>\
                    <textarea data-name='pregunta "+firstQuestion+" ' rows='5' required name='question["+exam+"]["+controlQuest+"]' type ='text' class='text-field questionValidation'></textarea>\
                    <input type='text' value='multiple' style='display:none' name='questionType["+exam+"]["+controlQuest+"]'>\
                    </br>\
                    <a data-exam='answerExam"+exam+"' data-question='answerQuestion"+controlQuest+"' class='ead btn-eadtools-light ead-md text-white add_new_answer'>Añadir respuesta</a>\
                    </br></br>\
                    <!-- Answer -->\
                    <div data-name='pregunta "+firstQuestion+" ' class='putAnswer"+exam+""+controlQuest+" verifyAnswer'>\
                    \
                    </div>\
                </div>\
            ");

            // Sortable
            $("ol.sortableQuestion").sortable({ 
                handle: '.handlerQuestion',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                        var text = parseInt(index) + parseInt(1);
                        $(this).find("input.position_question").val(index);
                        $(this).find("span.question_text").html("Pregunta "+text+"");
                    });
                }
            });

            // Update questions text
            $("ol.sortableQuestion").children('li.navQuestions').each(function(){
                var index = $(this).index();
                var newValue = parseInt(index) + parseInt(1);
                $(this).find("span.question_text").html("Pregunta "+newValue+"");
            });
            

            // Function star
            $(function() {
                $(document).on({
                    mouseover: function(event) {
                        $(this).find('.far').addClass('star-over');
                        $(this).prevAll().find('.far').addClass('star-over');
                    },
                    mouseleave: function(event) {
                        $(this).find('.far').removeClass('star-over');
                        $(this).prevAll().find('.far').removeClass('star-over');
                    }
                }, '.rate');

                
                $(document).on('click', '.rate', function() {
                    if ( !$(this).find('.star').hasClass('rate-active') ) {
                        $(this).siblings().find('.star').addClass('far').removeClass('fas rate-active');
                        $(this).find('.star').addClass('rate-active fas').removeClass('far star-over');
                        $(this).prevAll().find('.star').addClass('fas').removeClass('far star-over');
                    } else {
                        console.log('has');
                    }
                });

                $(document).on("change",".weight",function(){
                    var weight = $(this).attr('data-weight');
                    var tst = $(this).closest('.stars').children().val(weight);
                });
                
            }); // End function star
            
            
            // Tooltip
            addMultiple.tooltip();
            addContentMultiple.tooltip(); // End tooltip

            var controler = $('#controler').val();
            $("#"+questionPlace+"").append(addContentMultiple);
            $("#"+questionPlaceNav+"").append(addMultiple);
            x++;
                               
            firstQuestion++;
            control = parseInt(control) + parseInt(1);
            controlQuest = parseInt(controlQuest) + parseInt(1);
        });

        // Add a descriptive question
        $(document).on("click",".descriptive_question", function(){
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 10;
            toastr.options.preventDuplicates = true;
            toastr.options.timeOut = 1500;
            toastr.options.closeEasing = 'swing';
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.success('Pregunta descriptiva agregada');
            var exam = $(this).attr('data-place').charAt(15);
            var questionPlace = $(this).attr('data-place');
            var questionPlaceNav = $(this).attr('data-nav');
            $(".tab-content").show();
            $(".order").show();
            var addDescriptive = $("\
            <li id='question"+x+"' class='list-group-item text-white pointer navQuestions'>\
                <i data-toggle='tooltip' data-placement='top' title='Borrar' class='mdi mdi-trash-can mdi-18px md-6 text-danger pointer remove_question'></i>\
                <i data-toggle='tooltip'  data-placement='top' title='Mover' class='mdi mdi-cursor-move mdi-18px md-6 handlerQuestion text-primary pointer' style='padding-right:10%;'></i> <span class='question_text'>Pregunta "+firstQuestion+"</span> \
                <input type='number' name='positionQuestion["+exam+"]["+controlQuest+"]' style='display:none;' class='position_question' value="+x+">\
            </li>\
            ");
            if(x == 1){
                var display = "";
            }else{
                var display = "style='display:none;'";
            }
            var addContentDescriptive = $("\
                <div "+display+" class='question"+x+" myContent'>\
                    <h3 class='text-left text-info'>Pregunta descriptiva</h3>\
                    <hr>\
                    <h5 class='text-left'>Peso de la pregunta</h5>\
                    <div class='wrap'>\
                    <div class='stars'>\
                        <input style='display:none' class='putWeight' value='1' type='number' name='questionWeight["+exam+"]["+controlQuest+"]'>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='1'>\
                            <div class='face'></div>\
                            <i class='fas fa-star star one-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='2'>\
                            <div class='face'></div>\
                            <i class='far fa-star star two-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='3'>\
                            <div class='face'></div>\
                            <i class='far fa-star star three-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='4' >\
                            <div class='face'></div>\
                            <i class='far fa-star star four-star'></i>\
                        </label>\
                        <label class='rate'>\
                            <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='5'>\
                            <div class='face'></div>\
                            <i class='far fa-star star five-star'></i>\
                        </label>\
                    </div>\
                    </div>\
                    <h5 class='text-left'>Escribe tu pregunta</h5>\
                    <textarea required  data-name='pregunta "+firstQuestion+" ' rows='5' name='question["+exam+"]["+controlQuest+"]' type='text' class='text-field questionValidation'></textarea>\
                    <input type='text' value='descriptive' style='display:none' name='questionType["+exam+"]["+controlQuest+"]'>\
                    </br>\
                </div>\
            ");

            // Sortable
            $("ol.sortableQuestion").sortable({ 
                handle: '.handlerQuestion',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                        var text = parseInt(index) + parseInt(1);
                        $(this).find("input.position_question").val(index);
                        $(this).find("span.question_text").html("Pregunta "+text+"");
                    });
                }
            });

            // Update questions text
            $("ol.sortableQuestion").children('li.navQuestions').each(function(){
                var index = $(this).index();
                var newValue = parseInt(index) + parseInt(1);
                $(this).find("span.question_text").html("Pregunta "+newValue+"");
            })

            $(function() {

                $(document).on({
                    mouseover: function(event) {
                        $(this).find('.far').addClass('star-over');
                        $(this).prevAll().find('.far').addClass('star-over');
                    },
                    mouseleave: function(event) {
                        $(this).find('.far').removeClass('star-over');
                        $(this).prevAll().find('.far').removeClass('star-over');
                    }
                }, '.rate');
            
            
                $(document).on('click', '.rate', function() {
                    if ( !$(this).find('.star').hasClass('rate-active') ) {
                        $(this).siblings().find('.star').addClass('far').removeClass('fas rate-active');
                        $(this).find('.star').addClass('rate-active fas').removeClass('far star-over');
                        $(this).prevAll().find('.star').addClass('fas').removeClass('far star-over');
                    } else {
                        console.log('has');
                    }
                });

                $(document).on("change",".weight",function(){
                    var weight = $(this).attr('data-weight');
                    var tst = $(this).closest('.stars').children().val(weight);
                })
                
            });
            addDescriptive.tooltip();
            addContentDescriptive.tooltip();
            $("#"+questionPlace+"").append(addContentDescriptive);
            $("#"+questionPlaceNav+"").append(addDescriptive);
            x++;
            firstQuestion++;
            control = parseInt(control) + parseInt(1);
            controlQuest = parseInt(controlQuest) + parseInt(1);
        });

        // Add Free question
        $(document).on("click",".free_question", function(){
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 10;
            toastr.options.preventDuplicates = true;
            toastr.options.timeOut = 1500;
            toastr.options.closeEasing = 'swing';
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.success('Pregunta libre agregada');
            var exam = $(this).attr('data-place').charAt(15);
            var questionPlace = $(this).attr('data-place');
            var questionPlaceNav = $(this).attr('data-nav');
            $(".tab-content").show();
            $(".order").show();
            var addFree = $("\
            <li id='question"+x+"' class='list-group-item text-white pointer navQuestions'>\
                <i data-toggle='tooltip' data-placement='top' title='Borrar' class='mdi mdi-trash-can mdi-18px md-6 text-danger pointer remove_question'></i>\
                <i data-toggle='tooltip'  data-placement='top' title='Mover' class='mdi mdi-cursor-move mdi-18px md-6 handlerQuestion text-primary pointer' style='padding-right:10%;'></i> <span class='question_text'>Pregunta "+firstQuestion+"</span> \
                <input type='number' name='positionQuestion["+exam+"]["+controlQuest+"]' style='display:none;' class='position_question' value="+x+">\
            </li>\
            ");
            if(x == 1){
                var display = "";
            }else{
                var display = "style='display:none;'";
            }
            var addContentFree = $("\
                <div "+display+" class='question"+x+" myContent'>\
                    <h3 class='text-left text-info'>Pregunta libre</h3>\
                    <hr>\
                        <h5 class='text-left'>Peso de la pregunta</h5>\
                        <div class='wrap'>\
                        <div class='stars'>\
                            <input style='display:none' class='putWeight' value='1' type='number' name='questionWeight["+exam+"]["+controlQuest+"]'>\
                            <label class='rate'>\
                                <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='1'>\
                                <div class='face'></div>\
                                <i class='fas fa-star star one-star'></i>\
                            </label>\
                            <label class='rate'>\
                                <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='2'>\
                                <div class='face'></div>\
                                <i class='far fa-star star two-star'></i>\
                            </label>\
                            <label class='rate'>\
                                <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='3'>\
                                <div class='face'></div>\
                                <i class='far fa-star star three-star'></i>\
                            </label>\
                            <label class='rate'>\
                                <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='4' >\
                                <div class='face'></div>\
                                <i class='far fa-star star four-star'></i>\
                            </label>\
                            <label class='rate'>\
                                <input type='radio' name='inputWeight["+exam+"]["+controlQuest+"]' class='weight' data-weight='5'>\
                                <div class='face'></div>\
                                <i class='far fa-star star five-star'></i>\
                            </label>\
                        </div>\
                        </div>\
                    <h5 class='text-left'>Escribe tu pregunta</h5>\
                    <textarea  data-name='pregunta "+firstQuestion+" ' rows='5' required name='question["+exam+"]["+controlQuest+"]' class='text-field questionValidation' maxlength='700'></textarea>\
                    <input type='text' value='free' style='display:none;' name='questionType["+exam+"]["+controlQuest+"]'>\
                    </br>\
                </div>\
            ");

            $("ol.sortableQuestion").sortable({ 
                handle: '.handlerQuestion',
                stop: function(event, ui) {
                    $(this).children().each(function (index){
                        var text = parseInt(index) + parseInt(1);
                        $(this).find("input.position_question").val(index);
                        $(this).find("span.question_text").html("Pregunta "+text+"");
                    });
                }
            });

            // Update questions text
            $("ol.sortableQuestion").children('li.navQuestions').each(function(){
                var index = $(this).index();
                var newValue = parseInt(index) + parseInt(1);
                $(this).find("span.question_text").html("Pregunta "+newValue+"");
            })
        
            $(function() {

                $(document).on({
                    mouseover: function(event) {
                        $(this).find('.far').addClass('star-over');
                        $(this).prevAll().find('.far').addClass('star-over');
                    },
                    mouseleave: function(event) {
                        $(this).find('.far').removeClass('star-over');
                        $(this).prevAll().find('.far').removeClass('star-over');
                    }
                }, '.rate');
            
            
                $(document).on('click', '.rate', function() {
                    if ( !$(this).find('.star').hasClass('rate-active') ) {
                        $(this).siblings().find('.star').addClass('far').removeClass('fas rate-active');
                        $(this).find('.star').addClass('rate-active fas').removeClass('far star-over');
                        $(this).prevAll().find('.star').addClass('fas').removeClass('far star-over');
                    } else {
                        console.log('has');
                    }
                });

                $(document).on("change",".weight",function(){
                    var weight = $(this).attr('data-weight');
                    var tst = $(this).closest('.stars').children().val(weight);
                })
                
            });
            firstQuestion++;
            addFree.tooltip();
            addContentFree.tooltip();
            $("#"+questionPlace+"").append(addContentFree);
            $("#"+questionPlaceNav+"").append(addFree);
    
            x++;
        
            control = parseInt(control) + parseInt(1);
            controlQuest = parseInt(controlQuest) + parseInt(1);
        
        });

        // Function just to click
        $(document).ready(function clickNav(){
            if(navigation = $("li.navQuestions")[0]){
                navigation.click();
            }
        });

        // No duration
        $(document).on("change", ".modeTime", function(){
            if($(this).is(':checked')){
                $(this).parent().next('input').show();
                $(this).parent().next('input').val("");
            }else{
                $(this).parent().next('input').hide();
                $(this).parent().next('input').val(0);
            }
        })


        // Remove question
        $(document).on("click",".remove_question",function(){
            firstQuestion--;
            var contentRemove = $(this).parent().attr("id");   
            $("."+contentRemove+"").remove();
            $(this).parent().remove();
            // Update question text
            $("ol.sortableQuestion").children('li.navQuestions').each(function(){
                var index = $(this).index();
                var txt = parseInt(index) + parseInt(1);
                $(this).find("input.position_question").val(index);
                $(this).find("span.question_text").html("Pregunta "+txt+"");
            });         
            clickNav();
        });

        // Nav question
        $(document).on("click",".navQuestions",function(){

            // Remove active class of all li
            $(".navQuestions").each(function(){
                $(this).removeClass("active-question");                    
            })

            // Add active class
            $(this).addClass("active-question");

            // Hide all content
            var nav = $(this).attr("id");
            $(".myContent").each(function(){
                $(this).hide();
            });

            // Show only the current content
            $("."+nav+"").show();
        });
    
        $(document).on("change", "#verifyCert", function(){
            if($(this).is(':checked')){
                $("#selectCert").show();
            }else{
                $("#selectCert").hide();
            }
            
        });
    });            
}

function nAnswer(){
    // Add new answer
    $(document).ready(function() {  
        var campos_max = 999;   //max de 10 campos
        var w = 2; // campos iniciais
         // Add multiple answer
         $(document).on("click",".add_new_answer", function(){
            var exam = $(this).attr('data-exam').charAt(10);
            var question = $(this).attr('data-question').charAt(14);
            var addAnswer = $("\
                <div class='col-12'>\
                    <div class='input-group mb-2'>\
                        <div class='input-group-prepend'>\
                            <div class='input-group-text'>\
                                <div class='custom-control custom-checkbox'>\
                                    <i data-toggle='tooltip' data-placement='top' title='Borrar' class='mdi mdi-close remove_answer pointer'></i>\
                                </div>\
                            </div>\
                        </div>\
                        \
                        <div class='input-group-prepend'>\
                            <div class='input-group-text'>\
                                <div data-toggle='tooltip' data-placement='top' title='Respuesta correcta' class='custom-control custom-radio' data-name='pregunta "+firstQuestion+"'>\
                                    <input type='radio' name='correct["+question+"]' class='custom-control-input' id='customCheck"+exam+""+question+""+w+"'>\
                                    <label class='custom-control-label' for='customCheck"+exam+""+question+""+w+"'></label>\
                                </div>\
                            </div>\
                        </div>\
                        <input required name='answer["+question+"]["+control+"]' type='text'  maxlength='700' class='form-control py-0 putCorrectAnswer' id='inlineFormInputGroup' placeholder='Respuesta'>\
                    </div>\
                </div>\
            ");
            addAnswer.tooltip();
            $(this).parent().children(".putAnswer"+exam+""+question+"").append(addAnswer);
            w++;
            control = parseInt(control) + parseInt(1);
            // Remove answer
            $(document).on("click",".remove_answer",function(){
                $(this).closest('.col-12').remove();
                w--;
            });
        });
    });

    // Apply the correct answer
    $(document).ready(function(){
        $(document).on("change","input[type='radio']",function(){
            correctAnswer = $(this).parent().parent().parent().parent().children('.putCorrectAnswer').val();
            $(this).val(correctAnswer);
        });

        // Change correct radio
        $(document).on("change",".putCorrectAnswer", function(){
            var correctAnswerSec = $(this).val();
            var tst = $(this).parent().children('.input-group-prepend').next('.input-group-prepend').children().children().children('input').val(correctAnswerSec);
            
        })
    });
}


 //  ------------------- Register course
function nCourse(baseurl){
    $(document).ready(function(){
        $("#register_button").click(function(){
            var typeCourse = $("#controlTypeCourse").val();
            var formData = $("#register_form").serialize();
            $('body').loadingModal({
                position: 'auto',
                text: 'Guardando su curso, espere ...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'foldingCube'
            });
            $.ajax({
                url: '/reg/course',
                type: 'POST',
                data: formData,    
                success: function(data){
                    $('body').loadingModal('destroy');
                    $("#lastSvg").show();
                    $("#courseLink").attr("href",""+baseurl+"pages/watch?id="+data+"");
                    if(typeCourse == "1"){
                        $("#selling").hide();
                        $("#publish_button").hide();
                        $("#finish_course_sell").parent().fadeIn();
                    }else{
                        $("#training").hide();
                        $("#publish_button").hide();
                        $("#finish_course_sell").parent().fadeIn();
                    }
                }
            });
        });
    });     
}

function stopUpload(){
    $(document).ready(function(){
        // Stop upload by clicking X
        $("#stopProgress").on("click", function(){
            var fileInput = $("#myBar").attr("data-fileinput");
            var el = $("#myBar").attr("data-el");

            ajaxCall.abort();
            console.log("Stop loading");
            $("#"+fileInput+"").val("");

            // Update tooltip
            $("#"+el+"").tooltip('dispose');
            $("#"+el+"").tooltip();
            $("#"+el+"").attr("title", "No hay archivos seleccionados");
            $("#"+el+"").attr("data-original-title", "No hay archivos seleccionados");
        });
    });
}
        

