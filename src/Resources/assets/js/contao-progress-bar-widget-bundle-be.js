import '@hundh/contao-utils-bundle';
import '../scss/contao-progress-bar-widget-bundle-be.scss';

class ContaoProgressBarWidgetBundleBackend {
    static init() {
        ContaoProgressBarWidgetBundleBackend.initAjaxReload();
    }

    static initAjaxReload() {
        const widgets = document.querySelectorAll('.huh-progress-bar');

        if (widgets.length < 1) {
            return;
        }

        setInterval(() => {
            widgets.forEach((widget) => {
                utilsBundle.ajax.get(widget.getAttribute('data-progress-url'), {}, {
                    onSuccess: (response) => {
                        let data = JSON.parse(response.responseText);

                        widget.setAttribute('data-state', data.state);

                        widget.querySelector('.progress-bar > span').style = 'width: ' + (100 * data.currentProgress / data.totalCount) + '%';
                        widget.querySelector('.current-progress').innerHTML = data.currentProgress;
                        widget.querySelector('.total-count').innerHTML = data.totalCount;
                        widget.querySelector('.skipped-count').innerHTML = data.skippedCount;
                    }
                });
            });
        }, 2000);
    }
}

document.addEventListener('DOMContentLoaded', ContaoProgressBarWidgetBundleBackend.init);
