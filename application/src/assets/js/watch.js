function watch(template,courseTitle,cert,viewCert,courseId){ 
            const players = Array.from(document.querySelectorAll('video')).map(p => new Plyr(p));
            const playersAudio = Array.from(document.querySelectorAll('audio')).map(p => new Plyr(p));
            bar1 = new ldBar("#myBar");

            /* New question in comment system */
            $(document).ready(function(){
                var form = $('#discution');
                $(document).on("click", "#sendQuestion", function(){
                    var message = $(this).parent().parent().children().children().val();
                    if(message == ""){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.error('Necesitas escribir algun mensaje');
                    }else{
                        $.ajax({
                            url: '/reg/forumQuestion',
                            data: form.serialize(),
                            type: 'POST',
                            success: function(){
                                swal({
                                    text: 'Pregunta enviada',
                                    type: 'success',
                                    confirmButtonColor: '#4fa7f3'
                                    }).then(function(){
                                        document.location.reload(true);
                                })
                            }
                        }) 
                    }
                })
            });
       
            /* New answer in comment system */
            $(document).ready(function(){
                $(document).on("click", ".sendAnswer", function(){
                    var form =  $(this).parent().children();
                    $.ajax({
                        url: '/reg/forumAnswer',
                        data: form.serialize(),
                        type: 'POST',
                        success: function(){
                            swal({
                                text: 'Mensage  enviada',
                                type: 'success',
                                confirmButtonColor: '#4fa7f3'
                                }).then(function(){
                                    document.location.reload(true);
                            })
                        }
                    })
                })
            });
      

            /* Start exam */
            $(document).ready(function(){
                $(document).on("click", ".start", function(){
                    var storageControl = $(this).attr("data-control");
                    sessionStorage.setItem('controlExam', storageControl);
                    var time = $(this).attr('data-time');
                    var goTime = $(this).parent().next('form').find('.timer');
                    if(time !=0){
                        $(function(){
                                goTime.startTimer({
                                onComplete: function(element){
                                element.addClass('is-complete');
                                $(this).parent().next('.finishExam').click();
                                }
                            });
                        });
                    }
                });
            })

            /* Next question*/
            $(document).ready(function(){
                $(document).on("click", ".nextqst", function(){
                    $(".questhide").each(function(){
                        $(this).hide();
                    });
                    var question = $("#nextquestion").val();
                    $("."+question+"").parent(".questhide").show();
                    var next = parseInt(question.charAt(8)) + parseInt(1);
                    $("#nextquestion").val("question"+next);
                    
                    if ($(".question"+next+"").parent(".questhide").length ){
                      
                    }else{
                        $(this).fadeOut("slow", function() {
                            $(this).hide();
                        });
                    }
                })
            })

        
            /*  Leftbar navigation */
            $(document).ready(function(){
                $(".navcontroler").on("click", function(){

                    
                    if($(window).width() <= 800){
                        $("#wrapper").addClass("enlarged");
                    }
                
                    // Verification
                    if($(this).attr("name") == "0"){
                        // Hide all content
                        $("div[name='tohide']").each(function(){
                            $(this).hide();
                        });

                        // Stop all videos
                        $('video').each(function(){
                            $(this).trigger('pause');
                        });
                        
                        // Set next and prev li 
                        var place = $(this).attr("data-navigation");
                        var control = $(this).attr("name");
                        var next = parseInt(control) + parseInt(1);
                        var prev = parseInt(control) - parseInt(1);
                        $("#next").val(next);
                        $("#prev").val(prev);

                        // Show the content
                        $('div[data-navigation='+place+']').show();
                        var type =   $('div[data-navigation='+place+']').attr("data-type");
                        if(type == "video"){
                            var div =  $('div[data-navigation='+place+']').children().children();
                            var src = div.children('span').attr("data-src");
                            var video = div.find("video");
                            var view = video.attr("data-view");
                            if(view == "close"){
                                video.attr("src", src);
                                video.attr("data-view", "viewed");
                            }
                        }

                        var m = $(this).parent('li').attr("name");
                        $("#my_module").val(m);
                        var pdf = $('div[data-navigation='+place+']').children().children().children().children().children().attr("class");
                        var el = $('div[data-navigation='+place+']').children().children().children().children().children();
                        if(pdf == "btn btn-custom btn-purple waves-effect waves-light center pdfViwer"){
                          $(document).ready(function(){
                              el.click();
                          })   
                        }
                    }else{

                        var my_module = $("#my_module").val();
                        var module_to_go = $(this).parent('li').attr("name");


                        // The same module?
                        if(my_module == module_to_go){
                            // Hide all content
                            $("div[name='tohide']").each(function(){
                                $(this).hide();
                            });

                            // Stop all videos
                            $('video').each(function(){
                                $(this).trigger('pause');
                            });
                            
                            // Set next and prev li 
                            var place = $(this).attr("data-navigation");
                            var control = $(this).attr("name");
                            var next = parseInt(control) + parseInt(1);
                            var prev = parseInt(control) - parseInt(1);
                            $("#next").val(next);
                            $("#prev").val(prev);

                            // Show the content
                            $('div[data-navigation='+place+']').show();  
                            var type =   $('div[data-navigation='+place+']').attr("data-type");
                            if(type == "video"){
                                var div =  $('div[data-navigation='+place+']').children().children();
                                var src = div.children('span').attr("data-src");
                                var video = div.find("video");
                                var view = video.attr("data-view");
                                if(view == "close"){
                                    video.attr("src", src);
                                    video.attr("data-view", "viewed");
                                }
                            }
                            var pdf = $('div[data-navigation='+place+']').children().children().children().children().children().attr("class");

                            var type =   $('div[data-navigation='+place+']').attr("data-type");
                        
                            if(type == "video"){
                                var div =  $('div[data-navigation='+place+']').children().children();
                                var src = div.children('span').attr("data-src");
                                var video = div.find("video");
                                video.attr("src", src);
                            }

                            if(pdf == "btn btn-custom btn-purple waves-effect waves-light center pdfViwer"){
                                $('div[data-navigation='+place+']').children().children().children().children().children().click(); 
                            }
                            var m = $(this).parent('li').attr("name");
                            $("#my_module").val(m);
                        }
                        
                        else{
                            var check = $("li[name='"+my_module+"']").closest("li[class='has_sub']").attr("name"); 
                            if(check == "on"){
                                var verify = 0;
                                $("li[name='"+my_module+"']").each(function(){
                                    var done = $(this).children('a').children('button').attr("name");
                                    if(done == "pending"){
                                        verify++;
                                        swal({
                                            title: 'Módulo bloqueado',
                                            text: 'Usted necesita finalizar todas las actividades del módulo anterior',
                                            imageUrl: '../assets/img/callback/lock.png',
                                            imageHeight: 150,
                                            animation: true,
                                            confirmButtonColor: '#4fa7f3'
                                        })
                                    }
                                });
                                if(verify == 0){
                                         // Hide all content
                                        $("div[name='tohide']").each(function(){
                                            $(this).hide();
                                        });

                                        // Stop all videos
                                        $('video').each(function(){
                                            $(this).trigger('pause');
                                        });
                                        
                                        // Set next and prev li 
                                        var place = $(this).attr("data-navigation");
                                        var control = $(this).attr("name");
                                        var next = parseInt(control) + parseInt(1);
                                        var prev = parseInt(control) - parseInt(1);
                                        $("#next").val(next);
                                        $("#prev").val(prev);

                                        // Show the content
                                        $('div[data-navigation='+place+']').show();  
                                        var type =   $('div[data-navigation='+place+']').attr("data-type");
                                        if(type == "video"){
                                            var div =  $('div[data-navigation='+place+']').children().children();
                                            var src = div.children('span').attr("data-src");
                                            var video = div.find("video");
                                            var view = video.attr("data-view");
                                            if(view == "close"){
                                                video.attr("src", src);
                                                video.attr("data-view", "viewed");
                                            }
                                        }  
                                        var pdf = $('div[data-navigation='+place+']').children().children().children().children().children().attr("class");

                                        if(pdf == "btn btn-custom btn-purple waves-effect waves-light center pdfViwer"){
                                            $('div[data-navigation='+place+']').children().children().children().children().children().click(); 
                                        }
                                        var m = $(this).parent('li').attr("name");
                                        $("#my_module").val(m);
                                    }
                            }else{
                                 // Hide all content
                                $("div[name='tohide']").each(function(){
                                    $(this).hide();
                                });

                                // Stop all videos
                                $('video').each(function(){
                                    $(this).trigger('pause');
                                });
                                
                                // Set next and prev li 
                                var place = $(this).attr("data-navigation");
                                var control = $(this).attr("name");
                                var next = parseInt(control) + parseInt(1);
                                var prev = parseInt(control) - parseInt(1);
                                $("#next").val(next);
                                $("#prev").val(prev);

                                // Show the content   
                                $('div[data-navigation='+place+']').show(); 
                                var type =   $('div[data-navigation='+place+']').attr("data-type");
                                if(type == "video"){
                                    var div =  $('div[data-navigation='+place+']').children().children();
                                    var src = div.children('span').attr("data-src");
                                    var video = div.find("video");
                                    var view = video.attr("data-view");
                                    if(view == "close"){
                                        video.attr("src", src);
                                        video.attr("data-view", "viewed");
                                    }
                                }
                                var m = $(this).parent('li').attr("name");
                                var pdf = $('div[data-navigation='+place+']').children().children().children().children().children().attr("class");

                                if(pdf == "btn btn-custom btn-purple waves-effect waves-light center pdfViwer"){
                                    $('div[data-navigation='+place+']').children().children().children().children().children().click(); 
                                } 
                                $("#my_module").val(m);
                                }
                        }
                    }
                })
            });


            /* Next button */
            $(document).ready(function(){
                $(document).on("click",".next", function(){
                    var controler = $("#next").val();
                    var next = parseInt(controler);
                    var check = $('a[name="'+controler+'"]').attr("id");
                    if (check == null){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options = { onclick: function () {console_log('next');} }
                        toastr.info('No hay más contenido que mostrar');
                    }else{
                        // Hide all content
                        $("div[name='tohide']").each(function(){
                            $(this).hide();
                        });

                        // Stop all videos
                        $('video').each(function(){
                            $(this).trigger('pause');
                        });
                        }
                        $("a[name='"+next+"']").click();
                })
            })

            /* Prev button */
            $(document).ready(function(){
                $(document).on("click",".prev", function(){
                    var controler = $("#prev").val();
                    var prev = parseInt(controler);
                    var check = $("a[name='"+prev+"']").attr("id");
                    if (check == null){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options = { onclick: function () {console_log('next');} }
                        toastr.info('No hay más contenido que mostrar');
                    }else{
                         // Hide all content
                         $("div[name='tohide']").each(function(){
                            $(this).hide();
                        });

                        // Stop all videos
                        $('video').each(function(){
                            $(this).trigger('pause');
                        });
                        }
                        $("a[name='"+prev+"']").click();
                })
            })
        
            /* Finish downloaded content */
            $(document).ready(function(){
                $(document).on("click",".download",function(){
                    var iframe = $(this).parent().parent().next('.row').children().children();
                    iframe.show();
                    var lessonId = $(this).closest("div[name='tohide']").attr("class");
                    var userId = $("#user").val();
                    var courseId = $("#courseId").val();
        
                    if($("#"+lessonId+"").children().children('i').attr("name") == "done"){
                     /* Do nothing */
                    }else{
                        var update = $("#update").val();
                        var each = $("#each").val();
                        var up = parseInt(update) + parseInt(each);
                        
                        $("#update").val(up);
                        var updateBar = Math.ceil(update);

                        if(updateBar > 100 || updateBar > 98){
                            updateBar = 100;
                        }
                        $("#"+lessonId+"").children().children('i').attr("name", "done");
                        $("#"+lessonId+"").children('button').removeClass("btn btn-sm btn-indigo").addClass("btn btn-sm aqua-gradient");
                        bar1.set(updateBar);
                    }

                    $.ajax({
                        url: '/reg/progress',
                        type: 'POST',
                        dataType : "json",
                        data: {"lessid":lessonId , "usrid": userId, "update": update,"courseId" : courseId},      
                        success: function(data){
                            var up = parseInt(update) + parseInt(each);
                            $("#update").val(up);
                            
                            if(updateBar > 100 || updateBar > 98){
                                updateBar = 100;
                                // Verify if user view course yet
                                if(viewCert == "yes"){
                                    toastr.options.positionClass = 'toast-top-right';
                                    toastr.options.escapeHtml = true;
                                    toastr.options.timeOut = 30; 
                                    toastr.options.progressBar = true;
                                    toastr.options = { onclick: function () {$(".next").click();} }
                                    toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                                }else{
                                    // Verify if course have cert
                                    if(cert != 0){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/certificate.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </br> <h4> <a class="btn btn-info" target="_blank" href="/pages/view_cert?template='+template+'&course='+courseTitle+'&courseId='+courseId+'">VER CERTIFICADO</a></h4> </div>');
                                    }else{
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/trophy.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </div>');
                                    }
                                }
                            }else{
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.options.escapeHtml = true;
                                toastr.options.timeOut = 30; 
                                toastr.options.progressBar = true;
                                toastr.options = { onclick: function () {$(".next").click();} }
                                toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                            }
                        }
                    }); 
                 });
            });

            /* Finish pdf */
            $(document).ready(function(){
                $(".pdfViwer").on("click",function(){
                    $(this).hide();
                    var iframe = $(this).parent().parent().next('.row').children().children();
                    iframe.show();
                    var lessonId = $(this).closest("div[name='tohide']").attr("class");
                    var userId = $("#user").val();
                    var courseId = $("#courseId").val();
                    if($("#"+lessonId+"").children().children('i').attr("name") == "done"){
                    /* Do nothing */
                    }else{ 
                        var update = $("#update").val();
                        var each = $("#each").val();
                        var up = parseInt(update) + parseInt(each);
                        $("#update").val(up);
                        var updateBar = Math.ceil(update);
                        if(updateBar > 100 || updateBar > 98){
                            updateBar = 100;
                        }
                        $("#"+lessonId+"").children().children('i').attr("name", "done");
                        $("#"+lessonId+"").children('button').removeClass("btn btn-sm btn-indigo").addClass("btn btn-sm aqua-gradient");
                        bar1.set(updateBar);
                    }
                        
                    $.ajax({
                        url: '/reg/progress',
                        type: 'POST',
                        dataType : "json",
                        data: {"lessid":lessonId , "usrid": userId, "update": update,"courseId" : courseId},      
                        success: function(data){
                            if(updateBar > 100 || updateBar > 98){
                                updateBar = 100;
                                // Verify if user view course yet
                                if(viewCert == "yes"){
                                    toastr.options.positionClass = 'toast-top-right';
                                    toastr.options.escapeHtml = true;
                                    toastr.options.timeOut = 30; 
                                    toastr.options.progressBar = true;
                                    toastr.options = { onclick: function () {$(".next").click();} }
                                    toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                                }else{
                                    // Verify if course have cert
                                    if(cert != 0){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/certificate.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </br> <h4> <a class="btn btn-info" target="_blank" href="/pages/view_cert?template='+template+'&course='+courseTitle+'&courseId='+courseId+'">VER CERTIFICADO</a></h4> </div>');
                                    }else{
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/trophy.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </div>');
                                    }
                                }
                            }else{
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.options.escapeHtml = true;
                                toastr.options.timeOut = 30; 
                                toastr.options.progressBar = true;
                                toastr.options = { onclick: function () {$(".next").click();} }
                                toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                            }
                        }
                    }); 
                 });
            });

        /* Finish videocall */
        $(document).ready(function(){
            $(document).on("click", ".clickVideoCall", function(){
                var lessonId = $(this).closest("div[name='tohide']").attr("class");
                var callId = $(this).closest("div[name='tohide']").attr("data-callid");
                var userId = $("#user").val();
                var courseId = $("#courseId").val();
                if($("#"+lessonId+"").children().children('i').attr("name") == "done"){
                /* Do nothing */
                }else{
                    var update = $("#update").val();
                    var each = $("#each").val();
                    var up = parseInt(update) + parseInt(each);
                    $("#update").val(up);
                    var updateBar = Math.ceil(update);
                    if(updateBar > 100 || updateBar > 98){
                        updateBar = 100;
                    }
                    $("#"+lessonId+"").children().children('i').attr("name", "done");
                    $("#"+lessonId+"").children('button').removeClass("btn btn-sm btn-indigo").addClass("btn btn-sm aqua-gradient");
                    bar1.set(updateBar);

                    
                    // Call status
                    $.ajax({
                        url: '/reg/callStatus',
                        type: 'POST',
                        dataType: "json",
                        data: {"callId":callId , "usrId": userId}
                    });

                    $.ajax({
                            url: '/reg/progress',
                            type: 'POST',
                            dataType : "json",
                            data: {"lessid":lessonId , "usrid": userId , "update": update,"courseId" : courseId},      
                            success: function(data){
                                if(updateBar > 100 || updateBar > 98){
                                    updateBar = 100;
                                    // Verify if user view course yet
                                    if(viewCert == "yes"){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 30; 
                                        toastr.options.progressBar = true;
                                        toastr.options = { onclick: function () {$(".next").click();} }
                                        toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                                    }else{
                                        // Verify if course have cert
                                        if(cert != 0){
                                            toastr.options.positionClass = 'toast-top-right';
                                            toastr.options.escapeHtml = true;
                                            toastr.options.timeOut = 90; 
                                            toastr.options = { onclick: function () {console_log('previous');} }
                                            toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/certificate.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </br> <h4> <a class="btn btn-info" target="_blank" href="/pages/view_cert?template='+template+'&course='+courseTitle+'&courseId='+courseId+'">VER CERTIFICADO</a></h4> </div>');
                                        }else{
                                            toastr.options.positionClass = 'toast-top-right';
                                            toastr.options.escapeHtml = true;
                                            toastr.options.timeOut = 90; 
                                            toastr.options = { onclick: function () {console_log('previous');} }
                                            toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/trophy.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </div>');
                                        }
                                    }
                                }else{
                                    toastr.options.positionClass = 'toast-top-right';
                                    toastr.options.escapeHtml = true;
                                    toastr.options.timeOut = 30; 
                                    toastr.options.progressBar = true;
                                    toastr.options = { onclick: function () {$(".next").click();} }
                                    toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                                }
                            }
                    }); 
                }   
            });
        })

        /* Finish webinar */
        $(document).ready(function(){
            $(document).on("click", ".clickWebinar", function(){
                var lessonId = $(this).closest("div[name='tohide']").attr("class");
                var webinarId = $(this).closest("div[name='tohide']").attr("data-webinarid");
                var userId = $("#user").val();
                var courseId = $("#courseId").val();
                if($("#"+lessonId+"").children().children('i').attr("name") == "done"){
                /* Do nothing */
                }else{
                    var update = $("#update").val();
                    var each = $("#each").val();
                    var up = parseInt(update) + parseInt(each);
                    $("#update").val(up);
                    var updateBar = Math.ceil(update);
                    if(updateBar > 100 || updateBar > 98){
                        updateBar = 100;
                    }
                    $("#"+lessonId+"").children().children('i').attr("name", "done");
                    $("#"+lessonId+"").children('button').removeClass("btn btn-sm btn-indigo").addClass("btn btn-sm aqua-gradient");
                    bar1.set(updateBar);

                    // Webinar status
                    $.ajax({
                        url: '/reg/webinarStatus',
                        type: 'POST',
                        dataType: "json",
                        data: {"webinarId":webinarId , "usrId": userId}
                    });

                    $.ajax({
                        url: '/reg/progress',
                        type: 'POST',
                        dataType : "json",
                        data: {"lessid":lessonId , "usrid": userId , "update": update,"courseId" : courseId},      
                        success: function(data){
                            if(updateBar > 100 || updateBar > 98){
                                updateBar = 100;
                                // Verify if user view course yet
                                if(viewCert == "yes"){
                                    toastr.options.positionClass = 'toast-top-right';
                                    toastr.options.escapeHtml = true;
                                    toastr.options.timeOut = 30; 
                                    toastr.options.progressBar = true;
                                    toastr.options = { onclick: function () {$(".next").click();} }
                                    toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                                }else{
                                    // Verify if course have cert
                                    if(cert != 0){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/certificate.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </br> <h4> <a class="btn btn-info" target="_blank" href="/pages/view_cert?template='+template+'&course='+courseTitle+'&courseId='+courseId+'">VER CERTIFICADO</a></h4> </div>');
                                    }else{
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/trophy.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </div>');
                                    }
                                }
                            }else{
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.options.escapeHtml = true;
                                toastr.options.timeOut = 30; 
                                toastr.options.progressBar = true;
                                toastr.options = { onclick: function () {$(".next").click();} }
                                toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                            }
                        }
                    }); 
                }   
            });
        })

        /* Finish HTML */
        $(document).ready(function(){
            $(document).on("click", ".clickHtml", function(){
                var thisRow = $(this).closest('.row');
                var nextRow = thisRow.next('.row');
                var dir = nextRow.children().children().attr('data-dir');
                var myIframe = nextRow.children().children('iframe');
            

                var lessonId = $(this).closest("div[name='tohide']").attr("class");
                var htmlId = $(this).closest("div[name='tohide']").attr("data-htmlid");
                var userId = $("#user").val();
                var courseId = $("#courseId").val();
                if($("#"+lessonId+"").children().children('i').attr("name") == "done"){
                    // Set src on iframe
                    myIframe.attr("src", dir);
                    // Hide a html Jumbotron
                    thisRow.hide();
                    // Show html iframe
                    nextRow.fadeIn();
                }else{
                   
                    var update = $("#update").val();
                    var each = $("#each").val();
                    var up = parseInt(update) + parseInt(each);
                    $("#update").val(up);
                    var updateBar = Math.ceil(update);
                    if(updateBar > 100 || updateBar > 98){
                        $updateBar = 100;
                    }

                    
                    $(function(){
                        function1().done(function(){
                            // function1 is done, we can now call function2
                            console.log('function1 is done!');
                            
                            function2().done(function(){
                                //function2 is done
                                console.log('function2 is done!');
                            });
                        });
                    });

                    function function1(){
                        var dfrd1 = $.Deferred();
                        bar1.set(updateBar,true);
                        dfrd1.resolve();
                        return $.when(dfrd1).done(function(){}).promise();
                    }
                    
                    function function2(){
                        var dfrd1 = $.Deferred();
                        setTimeout(function(){
                            // Set src on iframe
                            myIframe.attr("src", dir);
                            // Hide a html Jumbotron
                            thisRow.hide();
                            // Show html iframe
                            nextRow.fadeIn();
                            console.log('task 1 in function2 is done!');
                            dfrd1.resolve();
                        }, 2000);
                        return dfrd1.promise();
                    }

                   
                    $("#"+lessonId+"").children().children('i').attr("name", "done");
                    $("#"+lessonId+"").children('button').removeClass("btn btn-sm btn-indigo").addClass("btn btn-sm aqua-gradient");
                    
                    // Html status
                    $.ajax({
                        url: '/reg/htmlStatus',
                        type: 'POST',
                        dataType: "json",
                        data: {"htmlId":htmlId , "usrId": userId}
                    });

                    $.ajax({
                        url: '/reg/progress',
                        type: 'POST',
                        dataType : "json",
                        data: {"lessid":lessonId , "usrid": userId , "update": update,"courseId" : courseId},      
                        success: function(data){
                            if(updateBar > 100 || updateBar > 98){
                                updateBar = 100;
                                // Verify if user view course yet
                                if(viewCert == "yes"){
                                    console.log("Teste");
                                    toastr.options.positionClass = 'toast-top-right';
                                    toastr.options.escapeHtml = true;
                                    toastr.options.timeOut = 30; 
                                    toastr.options.progressBar = true;
                                    toastr.options = { onclick: function () {$(".next").click();} }
                                    toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');                          
                                }else{
                                    // Verify if course have cert
                                    if(cert != 0){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/certificate.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </br> <h4> <a class="btn btn-info" target="_blank" href="/pages/view_cert?template='+template+'&course='+courseTitle+'&courseId='+courseId+'">VER CERTIFICADO</a></h4> </div>');
                                    }else{
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/trophy.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </div>');
                                    }
                                }
                            }else{
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.options.escapeHtml = true;
                                toastr.options.timeOut = 30; 
                                toastr.options.progressBar = true;
                                toastr.options = { onclick: function () {$(".next").click();} }
                                toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');  
                            }
                        }
                    }); 
                }   
            });
        })

        /* Finish video */ 
        $(document).ready(function(){
            $('video').on('ended',function(){   
                var lessonId = $(this).closest("div[name='tohide']").attr("class");
                var userId = $("#user").val();
                var courseId = $("#courseId").val();
                if($("#"+lessonId+"").children().children('i').attr("name") == "done"){
                /* Do nothing */ 
                }else{
                    var update = $("#update").val();
                    var each = $("#each").val();
                    var up = parseInt(update) + parseInt(each);
                    $("#update").val(up);
                    var updateBar = Math.ceil(update);
                    if(updateBar > 100 || updateBar > 98){
                        $updateBar = 100;
                    }
                    $("#"+lessonId+"").children().children('i').attr("name", "done");
                    $("#"+lessonId+"").children('button').removeClass("btn btn-sm btn-indigo").addClass("btn btn-sm aqua-gradient");
                    bar1.set(updateBar);
                    $.ajax({
                        url: '/reg/progress',
                        type: 'POST',
                        dataType : "json",
                        data: {"lessid":lessonId , "usrid": userId , "update": update,"courseId" : courseId},      
                        success: function(data){
                            if(updateBar > 100 || updateBar > 98){
                                updateBar = 100;
                                // Verify if user view course yet
                                if(viewCert == "yes"){
                                    toastr.options.positionClass = 'toast-top-right';
                                    toastr.options.escapeHtml = true;
                                    toastr.options.timeOut = 30; 
                                    toastr.options.progressBar = true;
                                    toastr.options = { onclick: function () {$(".next").click();} }
                                    toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                                }else{
                                    // Verify if course have cert
                                    if(cert != 0){
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/certificate.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </br> <h4> <a class="btn btn-info" target="_blank" href="/pages/view_cert?template='+template+'&course='+courseTitle+'&courseId='+courseId+'">VER CERTIFICADO</a></h4> </div>');
                                    }else{
                                        toastr.options.positionClass = 'toast-top-right';
                                        toastr.options.escapeHtml = true;
                                        toastr.options.timeOut = 90; 
                                        toastr.options = { onclick: function () {console_log('previous');} }
                                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/trophy.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </div>');
                                    }
                                }
                            }else{
                                toastr.options.positionClass = 'toast-top-right';
                                toastr.options.escapeHtml = true;
                                toastr.options.timeOut = 30; 
                                toastr.options.progressBar = true;
                                toastr.options = { onclick: function () {$(".next").click();} }
                                toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                            }
                        }
                    }); 
                }   
            });
        });

    
        /* Finish exam */
        $(document).ready(function(){
            $(document).on("click", ".finishExam", function(){

                // Verify if have empty fields
                var requiredBtn = $(this).attr("data-requiredcontrol");
                var control = 0;

                
                var btn = $(this).closest('form').prev('.pt-2').children('.start');
                var el = btn.next('.examFinished');
                btn.hide();
                el.show();
                var modalExam = $(this).closest('.modal');
                var userId = $("#user").val();
                var update = $("#update").val();
                var each = $("#each").val();
                var courseId = $("#courseId").val();
                var examId = $(this).closest("div[name='tohide']").attr("class");


                // Update course progress
                $.ajax({
                    url: '/reg/progress',
                    type: 'POST',
                    dataType : "json",
                    data: {"lessid":"null" ,"usrid": userId , "update": update,"courseId" : courseId},           
                }); 

                // Register a exam
                info = $(this).closest('form').serialize();      
                $.ajax({
                    url: '/reg/exam',
                    type: 'POST',
                    dataType: 'json',
                    data: info,      
                    success: function(data){    
                    }
                }); // End register exam
                // Modify css 
                modalExam.modal('toggle');
                $("#"+examId+"").children().children('i').attr("name", "done");
                $("#"+examId+"").children('button').removeClass("btn btn-sm btn-indigo").addClass("btn btn-sm aqua-gradient");
                data = $(this).closest('form').serialize();
                var updateBar = Math.ceil(update);

                // If course finished
                if(updateBar > 100 || updateBar > 98){
                    $updateBar = 100;
                    // Verify if course have cert
                    if(cert != 0){
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.escapeHtml = true;
                        toastr.options.timeOut = 90; 
                        toastr.options = { onclick: function () {console_log('previous');} }
                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/certificate.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </br> <h4> <a class="btn btn-info" target="_blank" href="/pages/view_cert?template='+template+'&course='+courseTitle+'&courseId='+courseId+'">VER CERTIFICADO</a></h4> </div>');
                    }else{
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.escapeHtml = true;
                        toastr.options.timeOut = 90; 
                        toastr.options = { onclick: function () {console_log('previous');} }
                        toastr.success('<div style="text-align:center;"><img width="60" src="../assets/img/callback/trophy.png"/> </br> <h4><b>Felicitaciones</b></h4>  Terminaste tu curso </div>');
                    } // End verify if course have cert
                }else{
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.escapeHtml = true;
                    toastr.options.timeOut = 30; 
                    toastr.options.progressBar = true;
                    toastr.options = { onclick: function () {$(".next").click();} }
                    toastr.success('Haga clic aquí para ir a la siguiente lección','Lección finalizada');
                } // End if finish course
                var up = parseInt(update) + parseInt(each);
                $("#update").val(up);
                bar1.set(updateBar);
            }); // End click finish exam
        }); // End document ready

        /* Start first content */
        $(document).ready(function(){
            $("a[name='0']").click();
            var m = $("a[name='0']").parent('li').attr("name");
            $("#my_module").val(m);
            $("#next").val("1");
        });
} 
        