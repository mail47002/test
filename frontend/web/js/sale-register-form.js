
var seleFormEvents = (function ($) {
	$.runSaleFormEvents = {

		dateObj: '',

		initSaleFormEvents: function ()
		{

			this.dateObj = new Date();
			$('#saleregisterform-date').datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: '2015:'+this.dateObj.getFullYear(),
				defaultDate: null,
			});
		},

	}
})(jQuery);

$( document ).ready(function() {
    $.runSaleFormEvents.initSaleFormEvents();
});
