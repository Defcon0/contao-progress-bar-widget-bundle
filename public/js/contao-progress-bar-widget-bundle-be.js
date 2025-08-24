class ContaoProgressBarWidgetBundleBackend {
    static init() {
        ContaoProgressBarWidgetBundleBackend.initAjaxReload();
    }

    static initAjaxReload() {
        const widgets = document.querySelectorAll('.huh-progress-bar');

        if (widgets.length < 1) {
            return;
        }

        ContaoProgressBarWidgetBundleBackend.updateWidgets(widgets);

        setInterval(() => {
            ContaoProgressBarWidgetBundleBackend.updateWidgets(widgets);
        }, 2000);
    }

    static updateWidgets(widgets) {
        widgets.forEach((widget) => {
            if (widget.getAttribute('data-state') !== 'in_progress') {
                return;
            }

            fetch(widget.getAttribute('data-progress-url'))
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    return response.text();
                })
                .then(data => {
                    data = JSON.parse(data);

                    widget.setAttribute('data-state', data.state);

                    widget.querySelector('.progress-bar > span').style = 'width: ' + (100 * data.currentProgress / data.totalCount) + '%';

                    if (widget.querySelector('.numbers') !== null) {
                        widget.querySelector('.numbers .current-progress').innerHTML = data.currentProgress;
                        widget.querySelector('.numbers .total-count').innerHTML = data.totalCount;
                        widget.querySelector('.numbers .skipped-count').innerHTML = data.skippedCount;
                    }

                    if (widget.querySelector('.messages') !== null && data.hasOwnProperty('messages') && data.messages.length > 0) {
                        let outputMessages = [];

                        if (widget.querySelector('.messages').classList.contains('invisible')) {
                            widget.querySelector('.messages').classList.remove('invisible');
                        }

                        for (const [key, message] of Object.entries(data.messages)) {
                            console.log(message);
                            outputMessages.push('<p class="' + message.class + '">' + message.text + '</p>');
                        }

                        widget.querySelector('.messages .wrapper').innerHTML = outputMessages.join('');
                    } else {
                        if (!widget.querySelector('.messages').classList.contains('invisible')) {
                            widget.querySelector('.messages').classList.add('invisible');
                        }
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                });
        });
    }
}

document.addEventListener('DOMContentLoaded', ContaoProgressBarWidgetBundleBackend.init);
