(function ($) {
    var dco_pv = {
        featured: parseInt(dcopv.featured),
        title: parseInt(dcopv.title),
        content: parseInt(dcopv.content),
        checkFeaturedImage: function () {
            if ($('#set-post-thumbnail').find('img').length) {
                $('.dco-pv-featured-error').addClass('hidden');
            } else {
                $('.dco-pv-featured-error').removeClass('hidden');
            }
        },
        checkTitle: function () {
            if ($('#title').val() !== '') {
                $('.dco-pv-title-error').addClass('hidden');
            } else {
                $('.dco-pv-title-error').removeClass('hidden');
            }
        },
        checkContent: function () {
            var content = '';
            //If visual tab active
            if (typeof (tinymce.editors.content) !== "undefined" && tinymce.editors.content.isHidden() !== true) {
                content = tinymce.editors.content.getContent();
            }
            //If text tab active
            else {
                content = $('#content').val();
            }

            if (content !== '') {
                $('.dco-pv-content-error').addClass('hidden');
            } else {
                $('.dco-pv-content-error').removeClass('hidden');
            }
        },
        showError: function () {
            var error = !$('.dco-pv-featured-error').hasClass('hidden') || !$('.dco-pv-title-error').hasClass('hidden') || !$('.dco-pv-content-error').hasClass('hidden');
            if (error) {
				//for compatibility with other validation plugins, e.g. ACF
                setTimeout(function () {
					$('.dco-pv-validation-error').removeClass('hidden');
					$('#publish').removeClass('disabled');
					$('.is-active').removeClass('is-active');
				}, 1);
				
                return false;
            } else {
                $('.dco-pv-validation-error').addClass('hidden');
            }
        }
    };

    $(function () {
        $(document).on('submit', '#post', function () {
            if (dco_pv.featured) {
                dco_pv.checkFeaturedImage();
            }

            if (dco_pv.title) {
                dco_pv.checkTitle();
            }

            if (dco_pv.content) {
                dco_pv.checkContent();
            }

            return dco_pv.showError();
        });

        if (parseInt(dco_pv.featured)) {
            $(document).on('click', '.media-toolbar-primary', function () {
                setTimeout(function () {
                    dco_pv.checkFeaturedImage();
                    dco_pv.showError();
                }, 1000);
            });
        }
    });
})(jQuery);