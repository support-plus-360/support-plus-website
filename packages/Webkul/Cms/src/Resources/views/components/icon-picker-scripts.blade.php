<script>
(function () {
	if (window.__cmsIconPickerBooted) {
		return;
	}

	window.__cmsIconPickerBooted = true;

	const baseIconClass = 'text-2xl text-gray-800 dark:text-gray-200';
	const emptyIconClass = 'text-2xl text-gray-300 dark:text-gray-600';

	function getModal(uid) {
		return document.querySelector(`[data-cms-icon-picker-modal="${uid}"]`);
	}

	function getActivePanel(modal) {
		return modal?.querySelector('[data-cms-icon-picker-panel]:not(.is-hidden)');
	}

	function syncIconPreview(uid) {
		const input = document.querySelector(`[data-cms-icon-picker-input="${uid}"]`);
		const previewI = document.querySelector(`[data-cms-icon-picker-preview="${uid}"]`);

		if (!input || !previewI) {
			return;
		}

		const value = (input.value || '').trim();
		previewI.className = value ? (value + ' ' + baseIconClass) : emptyIconClass;
	}

	function filterActiveTab(uid, query) {
		const modal = getModal(uid);
		const panel = getActivePanel(modal);

		if (!panel) {
			return;
		}

		const normalizedQuery = (query || '').toLowerCase().trim();

		panel.querySelectorAll('[data-cms-icon-class]').forEach((btn) => {
			const cls = (btn.getAttribute('data-cms-icon-class') || '').toLowerCase();
			btn.classList.toggle('is-hidden', Boolean(normalizedQuery && !cls.includes(normalizedQuery)));
		});
	}

	window.cmsIconPickerSetTab = function (uid, libraryKey) {
		const modal = getModal(uid);

		if (!modal) {
			return;
		}

		modal.querySelectorAll('[data-cms-icon-picker-tab]').forEach((tab) => {
			const isActive = tab.getAttribute('data-cms-icon-picker-tab') === libraryKey;
			tab.classList.toggle('cms-icon-picker-tab-active', isActive);
		});

		modal.querySelectorAll('[data-cms-icon-picker-panel]').forEach((panel) => {
			const isActive = panel.getAttribute('data-cms-icon-library') === libraryKey;
			panel.classList.toggle('is-hidden', !isActive);
		});

		const search = modal.querySelector(`[data-cms-icon-picker-search="${uid}"]`);
		filterActiveTab(uid, search?.value || '');
	};

	window.cmsIconPickerOpen = function (uid) {
		const modal = getModal(uid);
		const search = modal?.querySelector(`[data-cms-icon-picker-search="${uid}"]`);

		if (!modal) {
			return;
		}

		const firstTab = modal.querySelector('[data-cms-icon-picker-tab]');

		if (firstTab) {
			window.cmsIconPickerSetTab(uid, firstTab.getAttribute('data-cms-icon-picker-tab'));
		}

		modal.classList.add('is-open');
		document.body.classList.add('overflow-hidden');

		if (search) {
			search.value = '';
			filterActiveTab(uid, '');
			window.setTimeout(() => search.focus(), 0);
		}
	};

	window.cmsIconPickerClose = function (uid) {
		const modal = getModal(uid);

		if (!modal) {
			return;
		}

		modal.classList.remove('is-open');
		document.body.classList.remove('overflow-hidden');
	};

	window.cmsIconPickerSelect = function (uid, cls) {
		const input = document.querySelector(`[data-cms-icon-picker-input="${uid}"]`);

		if (input && cls) {
			input.value = cls;
			syncIconPreview(uid);
			input.dispatchEvent(new Event('input', { bubbles: true }));
		}

		window.cmsIconPickerClose(uid);
	};

	window.cmsIconPickerClear = function (uid) {
		const input = document.querySelector(`[data-cms-icon-picker-input="${uid}"]`);

		if (!input) {
			return;
		}

		input.value = '';
		syncIconPreview(uid);
		input.dispatchEvent(new Event('input', { bubbles: true }));
	};

	function bootIconPickers() {
		document.querySelectorAll('[data-cms-icon-picker-input]').forEach((input) => {
			const uid = input.getAttribute('data-cms-icon-picker-input');

			if (!uid || input.dataset.cmsIconPickerReady === '1') {
				return;
			}

			input.dataset.cmsIconPickerReady = '1';
			syncIconPreview(uid);
			input.addEventListener('input', () => syncIconPreview(uid));
		});

		document.querySelectorAll('[data-cms-icon-picker-search]').forEach((search) => {
			if (search.dataset.cmsIconPickerSearchReady === '1') {
				return;
			}

			search.dataset.cmsIconPickerSearchReady = '1';

			search.addEventListener('input', () => {
				const uid = search.getAttribute('data-cms-icon-picker-search');
				filterActiveTab(uid, search.value);
			});
		});
	}

	if (document.readyState === 'complete') {
		window.setTimeout(bootIconPickers, 0);
	} else {
		window.addEventListener('load', () => window.setTimeout(bootIconPickers, 0), { once: true });
	}
})();
</script>
