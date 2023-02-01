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
        const data = {};
        for (const [key, value] of formData) {
            data[key] = value;
        }
        // for (const [name, value] of formData.entries()) {
        //   console.log(`Name: ${name}, Value: ${value}`);
        // }

        fetch('/admin/includes/admin_handle_fetch.php', {
            method: 'POST', // or 'PUT'
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                showToast(data)
            })
            .catch((error) => {
                this.insertAdjacentHTML('afterbegin', `<div class="alert alert-danger" role="alert">${error}</div>`);
            });
    });
}