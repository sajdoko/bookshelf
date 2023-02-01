/* globals Chart:false, feather:false */

/* global bootstrap: false */
(() => {
    'use strict'
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })
})()

const bookForms = document.getElementsByClassName("bookForm");
for (let i = 0; i < bookForms.length; i++) {
    bookForms[i].addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const dataF = {};
        for (const [key, value] of formData) {
            dataF[key] = value;
        }

        if (dataF['form_action'] === 'delete_book') {
            if (!confirm("Are you sure you want to delete this book?")) {
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
                    if (dataF['form_action'] === 'insert_book') {
                        this.reset();
                    }
                }
            })
            .catch((error) => {
                this.insertAdjacentHTML('afterbegin', `<div class="alert alert-danger" role="alert">${error}</div>`);
            });
    });
}