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
							
							cell	= 	'<div class="pathcell"><div class="pathcellcontent">'+
										'<div class="pathline">'+
										'<div class="pathicone" style="background:transparent url(\'http://maps.googleapis.com/maps/api/staticmap?center='+moments.data[moments.sort[i]].location.lat+','+moments.data[moments.sort[i]].location.lng+'&zoom=14&size=40x40&sensor=false\')">'+
										'</div>'+
										'<div class="pathdatas">'+
										'<div class="pathcomment">'+
										moments.data[moments.sort[i]].headline+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="pathcellfooter">'+
										'<ul class="ulspecial">'+
										'<li><div class="emo hearth floatl"></div><span class="floatl" style="line-height: 15px;">'+moments.data[moments.sort[i]].comments.length+'</span></li>'+
										'</ul>'+
										'</div>'+
										'</div></div>';
							$('#pathactivityfeed').append(cell);
						}
					}
				});
});