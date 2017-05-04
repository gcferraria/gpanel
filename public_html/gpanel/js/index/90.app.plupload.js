(function(JsB) {
	
	var
        PlupUpload = my.Class( JsB, {
	   	   constructor: function( elem, caller ) {
                PlupUpload.Super.call( this, elem, caller );

            	var that = this;
            	this.root.queue.push(function(){
                    that.uploader = new plupload.Uploader({
                        runtimes      : 'html5,flash,html4',
                        browse_button : document.getElementById('tab_images_uploader_pickfiles'),
                        container     : document.getElementById('tab_images_uploader_container'),
                        url           : that.$.attr('data-jsb-url'),
                        init          : {
                            PostInit: function() {
                                $('#tab_images_uploader_filelist').html("");
                     
                                $('#tab_images_uploader_uploadfiles').click(function() {
                                    that.uploader.start();
                                    return false;
                                });

                                $('#tab_images_uploader_filelist').on('click', '.added-files .remove', function(){
                                    that.uploader.removeFile($(this).parent('.added-files').attr("id"));    
                                    $(this).parent('.added-files').remove();                     
                                });
                            },

                            FilesAdded: function(up, files) {
                                plupload.each(files, function(file) {
                                    $('#tab_images_uploader_filelist').append('<div class="alert alert-warning added-files" id="uploaded_file_' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" style="margin-top:-5px" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> remover</a></div>');
                                });
                            },

                            UploadProgress: function(up, file) {
                                $('#uploaded_file_' + file.id + ' > .status').html(file.percent + '%');
                            },

                            FileUploaded: function(up, file, response) {
                                var response = $.parseJSON(response.response);

                                if (response.result && response.result == 1) {
                                    var id = response.id; // uploaded file's unique name. Here you can collect uploaded file names and submit an jax request to your server side script to process the uploaded files and update the images tabke
                                    $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-success").html('<i class="fa fa-check"></i> Completo'); // set successfull upload
                                } 
                                else {
                                    $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-danger").html('<i class="fa fa-warning"></i> Falhou'); // set failed upload
                                    app.notification( response[0], response[1] );
                                }
                            },

                            Error: function(up, err) {
                                app.notification(up, err );
                            },

                            UploadComplete: function() {
                                $('#tab_images_uploader_filelist').html("");
                                that.context.$reload.click();
                            }
                        }
                    });
                    
                    that.uploader.init();
                });
            }
	   	})
	;

    JsB.object( 'App.PlupUpload', PlupUpload );

})(JsB);