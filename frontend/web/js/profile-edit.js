
var profileEditEvents = (function ($) {
	$.runProfileFormEvents = {

		dateObj: '',

		initProfileFormEvents: function ()
		{

			this.dateObj = new Date();
			$('#profile-birthday').datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: '1970:'+(this.dateObj.getFullYear()-18),
				defaultDate: null,
			});
		},

	}
})(jQuery);

$( document ).ready(function() {
    $.runProfileFormEvents.initProfileFormEvents();
});
