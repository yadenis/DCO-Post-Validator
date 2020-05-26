wp.domReady(function () {
	var editor = wp.data.dispatch('core/editor');
	var notices = wp.data.dispatch('core/notices');
	const {getEditedPostAttribute} = wp.data.select('core/editor');
	const { __, _x, _n, _nx } = wp.i18n;

	// Backup original method.
	var savePost = editor.savePost;

	// Override core method.
	editor.savePost = function () {
		var valid = true;
		notices.removeNotice('dco-cv-title-notice');
		notices.removeNotice('dco-cv-content-notice');
		notices.removeNotice('dco-cv-featured_media-notice');

		const title = getEditedPostAttribute('title');
		if (title === '' && parseInt(dcopv.title)) {
			notices.createErrorNotice(__( 'You need to set Title!', 'dco-post-validator' ), {
				id: 'dco-cv-title-notice'
			});
			valid = false;
		}

		const content = getEditedPostAttribute('content');
		if (content === '' && parseInt(dcopv.content)) {
			notices.createErrorNotice(__( 'You need to set Content!', 'dco-post-validator' ), {
				id: 'dco-cv-content-notice'
			});
			valid = false;
		}

		const featured = getEditedPostAttribute('featured_media');
		if (featured === 0 && parseInt(dcopv.featured)) {
			notices.createErrorNotice(__( 'You need to set Featured Image!', 'dco-post-validator' ), {
				id: 'dco-cv-featured_media-notice'
			});
			valid = false;
		}

		if (!valid) {
			return false;
		}

		// Save post as normal.
		savePost();
	};
});