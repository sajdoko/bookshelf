/* globals Chart:false, feather:false */

/* global bootstrap: false */
(() => {
    'use strict'
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })
})()

const recordForms = document.getElementsByClassName("recordForm");
for (let i = 0; i < recordForms.length; i++) {
    recordForms[i].addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const dataF = {};
        for (const [key, value] of formData) {
            dataF[key] = value;
        }

        if (dataF['form_action'] === 'delete') {
            if (!confirm(`Are you sure you want to delete this ${dataF['model']}?`)) {
                return;
            }
        }

        fetch('/admin/includes/admin_handle_fetch.php', {
            method: 'POST', // or 'PUT'
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(dataF),
        })
            .then((response) => response.json())
            .then((data) => {
                showToast(data)
                if (data.status === 'success') {
                    if (dataF['form_action'] === 'insert') {
                        this.reset();
                    }
                }
            })
            .catch((error) => {
                this.insertAdjacentHTML('afterbegin', `<div class="alert alert-danger" role="alert">${error}</div>`);
            });
    });
}