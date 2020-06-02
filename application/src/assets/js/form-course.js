jQuery(document).ready(function() {

			$(document).on("click", "#sellButton", function(){
				$("#controlTypeCourse").val("1");
				$("#courseType").hide();
				$("#selling").parent().fadeIn();
				$("#publish_button").parent().fadeIn();
			})

			$(document).on("click", "#trainingButton", function(){
				$("#controlTypeCourse").val("2");
				$("#courseType").hide();
				$("#training").parent().fadeIn();
				$("#publish_button").parent().fadeIn();
			})


			$("input").on("focus", function(){
				$(this).removeClass("verify-error");
			});

			jQuery('.form-wizard-wrapper').find('.form-wizard-link').click(function(){
				var elInfo = $("div[data-tab-content = 'info']");
				var elContent = $("div[data-tab-content = 'content']");
				var elPublish = $("div[data-tab-content = 'publish']");
				
				var mysvg = $(this).parent("li").prev("li").children().children();
				var type = $(this).attr("data-attr");

				if(type == "info"){
					elContent.hide();
					elPublish.hide();
					elInfo.show();
				}

				if(type == "content"){
					// Verify first step
					$(".verify-first-step").each(function(){
						var msg = $(this).attr("data-info");
						cont = 0;
						if($(this).val() == ""){
							$(this).addClass("verify-error");
							toastr.options.positionClass = 'toast-top-right';
							toastr.error('El campo de '+msg+' es obligatorio');
							cont++;
							return false;
						}
					});	

					if(cont != 0){
						return false;
					}else{
						mysvg.show();
						elInfo.hide();
						elPublish.hide();
						elContent.show();
					}
				}


				if(type == "publish"){
					var el = $(".active").attr("data-attr");
					cont = 0;

					// // Verify modules 
					if(el == "content"){
						// Verify modules
						$(".verify-module").each(function(index){
							var inputIndex = parseInt(index) + parseInt(1);
							var inputType = $(this).attr("type");
							
							if(inputType == "text"){
								if($(this).val() == ""){
									$(this).addClass("verify-error");
									toastr.options.positionClass = 'toast-top-right';
									toastr.error("El modulo "+inputIndex+" no tiene nombre");
									cont++;
									return false;
								}
							}
						});	

						// Verify lessons
						$(".verify-lesson").each(function(index){
							var inputIndex = parseInt(index) + parseInt(1);
							var inputType = $(this).attr("type");
							
							if(inputType == "text"){
								if($(this).val() == ""){
									$(this).addClass("verify-error");
									toastr.options.positionClass = 'toast-top-right';
									toastr.error("Hay alguna lección sin nombre");
									cont++;
									return false;
								}
							}

							if(inputType == "file"){
								var idHop = $(this).next().next().next().attr("id");
								if($(this)[0].files.length === 0){
									var placementRight = 'right';
									var placementLeft = 'left';
									var placementTop = 'top';
					
									// Define the tour!
									var tour = {
										id: "my-intro",
										steps: [
											{
												target: ''+idHop+'',
												title: "Agregar archivo",
												content: "Necesita agregar un archivo a esta lección.",
												placement: placementTop,
												yOffset: 10,	
											},
										],
										showPrevButton: false,
										showNextButton: false
									};
					
									// Start the tour!
									hopscotch.startTour(tour);
									cont++;
									return false;
								}
							}
						});
					}else{
						toastr.options.positionClass = 'toast-top-right';
						toastr.error("Debe pasar por el paso de contenido antes de continuar.");
						return false;
					}

					if(cont != 0){
						return false;
					}else{
						mysvg.show();
						elInfo.hide();
						elContent.hide();
						elPublish.show();
					}
				}
	

				jQuery('.form-wizard-link').removeClass('active');
				var innerWidth = jQuery(this).innerWidth();
				jQuery(this).addClass('active');
				var position = jQuery(this).position();
				jQuery('.form-wizardmove-button').css({"left": position.left, "width": innerWidth});
				var attr = jQuery(this).attr('data-attr');
				jQuery('.form-wizard-content').each(function(){
					if (jQuery(this).attr('data-tab-content') == attr) {
						jQuery(this).addClass('show');
					}else{
						jQuery(this).removeClass('show');
					}
				});
			});
		});