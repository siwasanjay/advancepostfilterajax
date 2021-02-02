(function ($) {

    // Filter post based on option selected.
	var filter = {
		init: function () {
			this.cacheDOM();
			this.eventListner();
		},
		cacheDOM: function () {
            this.$catSelect = $('#inputCat');
			this.$orderSelect = $('#orderBy');
            this.$fIlterWrapper = $('#apfa-filter-wrapper');
            this.$button = $('#loadmore'); // loadmore button
		},
        eventListner: function () {
            this.$catSelect.on('change', this.filterCat.bind(this));
            this.$orderSelect.on('change', this.filterCat.bind(this));
            this.$button.on('click', this.loadMore.bind(this));
        },
        // Category and orderby select change.
        filterCat: function (e) {
            var selectedCat = this.$catSelect.val();
            var selectedOrder = this.$orderSelect.val();
            var postData = {
                action: 'apfa_filter_post', // action
                cCategory: selectedCat, // selected category
                cOrder: selectedOrder, // selected order
            };
            $.ajax({
                url: APFA_URL.ajaxurl,
                type: 'POST',
                data: postData,
                beforeSend: function(){

                },
                success: function(response){
					$('#apfa-filter-wrapper').html(response);
                },
            });
        },
        // loadmore
        loadMore: function() {
            var selectedCat = this.$catSelect.val();
            var selectedOrder = this.$orderSelect.val();
            var cPage = this.$fIlterWrapper.data('page');

            var postData = {
                action: 'apfa_filter_post', // action
                cCategory: selectedCat, // selected category
                cOrder: selectedOrder, // selected order
                cPage: cPage // current page
            };
            $.ajax({
                url: APFA_URL.ajaxurl,
                type: 'POST',
                data: postData,
                beforeSend: function(){

                },
                success: function(response){
                    $('#apfa-filter-wrapper').append(response);
                    $('#apfa-filter-wrapper').data('page') = cPage++;
                },
            });
        }
	};

    //rename PROJECTNAME
    var APFA = {
        // All pages
        common: {
        	init: function() {
                // JavaScript to be fired on all pages
            }
    	},
        // Filter page
        'page-template-filter-page': {
        	init: function() {
            	// JavaScript to be fired on the register page
                filter.init();
        	}
    	},

	};


    //common UTIL this doesn't change
    var PG_JS_UTIL = {

    	fire: function(func, funcname, args) {
            var namespace = APFA; // indicate your obj literal namespace here for standard lets make it abbreviation of current project

            funcname = (funcname === undefined) ? 'init' : funcname;
            if (func !== '' && namespace[func]
            	&& typeof namespace[func][funcname] === 'function') {
            		namespace[func][funcname](args);
        	}
    	},

	    loadEvents: function() {

	    	var bodyId = document.body.id;

	        // hit up common first.
	        PG_JS_UTIL.fire('common');

	        // do all the classes too.
	        $.each(document.body.className.split(/\s+/), function(i, classnm) {
	        	PG_JS_UTIL.fire(classnm);
	        	PG_JS_UTIL.fire(classnm, bodyId);
	        });

	        PG_JS_UTIL.fire('common', 'finalize');

	    }
	};

	$(function() {
		PG_JS_UTIL.loadEvents();
	});


})(jQuery);
