

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const apiHeaders = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
};

function getValue(object, path) {
    return path.split('.').reduce((value, key) => {
        if (key === 'length') {
            return Array.isArray(value) ? value.length : '';
        }

        return value?.[key];
    }, object);
}

function showMessage(container, message, isError = true) {
    const target = container.tagName === 'DL' ? container.parentElement : container;
    let messageElement = target.querySelector('[data-ajax-message]');

    if (!messageElement) {
        messageElement = document.createElement('div');
        messageElement.dataset.ajaxMessage = '';
        target.prepend(messageElement);
    }

    messageElement.setAttribute('role', isError ? 'alert' : 'status');
    messageElement.className = isError
        ? 'mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/30 dark:text-red-200'
        : 'mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200';
    messageElement.textContent = message;
}

const pageParams = new URLSearchParams(window.location.search);
if (pageParams.get('ajax_success') === '1') {
    pageParams.delete('ajax_success');
    const query = pageParams.toString();
    window.history.replaceState(null, '', `${window.location.pathname}${query ? `?${query}` : ''}${window.location.hash}`);
    showMessage(document.querySelector('main'), 'Data berhasil disimpan.', false);
}

async function readResponse(response) {
    const body = await response.json().catch(() => ({}));

    if (!response.ok) {
        const validationMessages = Object.values(body.errors || {}).flat();
        throw new Error(validationMessages.join(' ') || body.message || 'Permintaan gagal diproses.');
    }

    return body;
}

document.querySelectorAll('[data-api-list]').forEach(async (tbody) => {
    try {
        const response = await fetch(tbody.dataset.apiList, { headers: { Accept: 'application/json' } });
        const result = await readResponse(response);
        const records = result.data;

        if (!Array.isArray(records)) {
            throw new Error('Format data dari server tidak sesuai.');
        }

        const byId = new Map(records.map((record) => [String(record.id), record]));
        tbody.querySelectorAll('[data-api-id]').forEach((row) => {
            const record = byId.get(row.dataset.apiId);

            if (!record) {
                return;
            }

            row.querySelectorAll('[data-api-field]').forEach((cell) => {
                const value = getValue(record, cell.dataset.apiField);
                cell.textContent = value == null
                    ? cell.dataset.apiDefault ?? ''
                    : `${cell.dataset.apiPrefix || ''}${value}${cell.dataset.apiSuffix || ''}`;
            });
        });
    } catch (error) {
        showMessage(tbody.closest('[data-api-container]') || tbody.parentElement.parentElement, error.message);
    }
});

document.querySelectorAll('[data-api-get]').forEach(async (container) => {
    try {
        const response = await fetch(container.dataset.apiGet, { headers: { Accept: 'application/json' } });
        const result = await readResponse(response);

        container.querySelectorAll('[data-api-field]').forEach((element) => {
            const value = getValue(result.data, element.dataset.apiField);
            element.textContent = value == null
                ? element.dataset.apiDefault ?? ''
                : `${element.dataset.apiPrefix || ''}${value}${element.dataset.apiSuffix || ''}`;
        });
    } catch (error) {
        showMessage(container, error.message);
    }
});

document.addEventListener('submit', async (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement)) {
        return;
    }

    if (form.matches('[data-api-form]')) {
        event.preventDefault();
        const submitButton = form.querySelector('[type="submit"]');
        const method = form.querySelector('[name="_method"]')?.value || form.method || 'POST';
        const payload = Object.fromEntries(new FormData(form).entries());
        delete payload._token;
        delete payload._method;

        if (submitButton) {
            submitButton.disabled = true;
        }

        try {
            const response = await fetch(form.dataset.apiForm, {
                method: method.toUpperCase(),
                headers: apiHeaders,
                body: JSON.stringify(payload),
            });
            await readResponse(response);
            const redirect = new URL(form.dataset.redirect, window.location.href);
            redirect.searchParams.set('ajax_success', '1');
            window.location.assign(redirect);
        } catch (error) {
            showMessage(form, error.message);
            if (submitButton) {
                submitButton.disabled = false;
            }
        }

        return;
    }

    if (form.matches('[data-api-delete]')) {
        event.preventDefault();

        if (!window.confirm(form.dataset.confirm || 'Apakah Anda yakin ingin menghapus data ini?')) {
            return;
        }

        const button = form.querySelector('[type="submit"]');
        if (button) {
            button.disabled = true;
        }

        try {
            const response = await fetch(form.dataset.apiDelete, {
                method: 'DELETE',
                headers: { Accept: 'application/json' },
            });
            await readResponse(response);
            form.closest('tr')?.remove();
            showMessage(
                form.closest('[data-api-container]') || form.closest('table')?.parentElement || form.parentElement,
                'Data berhasil dihapus.',
                false,
            );
        } catch (error) {
            showMessage(form.closest('[data-api-container]') || form.parentElement, error.message);
            if (button) {
                button.disabled = false;
            }
        }
    }
});

Alpine.start();
