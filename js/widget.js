jQuery(function($) {
	jQuery.ajax({
					url: PAthActivityAjaxUri,
					type: 'POST',
					data: {
						action: 'get_path_activity'
					},
					dataType: 'json',
					success: function(response) {
						$('#pathactivityfeedloading').css('background','none');
						//affichage du path
						var moments = response;
						var cell 	= '';
						for(var i = 0; i < moments.nbdisplay; i++){
							var myDate = new Date();

							myDate.setTime(moments.data[moments.sort[i]].visible_ts);
							
							cell	= 	'<div class="pathcell">'+
										'<div class="pathline">'+
										'<div class="pathicone">'+
										'</div>'+
										'<div class="pathdatas">'+
										'<div class="pathplace">'+
										'<strong>at</strong> '+moments.data[moments.sort[i]].location.city+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="pathcomment">'+
										moments.data[moments.sort[i]].headline+
										'</div>'+
										'</div>';
							$('#pathactivityfeed').append(cell);
							console.log(moments.data[moments.sort[i]]);
						}
					}
				});
});