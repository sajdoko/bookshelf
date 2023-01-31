/* globals Chart:false, feather:false */

/* global bootstrap: false */
(() => {
    'use strict'
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })
})()

const toastLiveExample = document.getElementById('liveToast')
document.querySelector("#editBookForm").addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    const data = {};
    for (const [key, value] of formData) {
        data[key] = value;
    }
    // for (const [name, value] of formData.entries()) {
    //   console.log(`Name: ${name}, Value: ${value}`);
    // }

    fetch('/admin/includes/handle_fetch.php', {
        method: 'POST', // or 'PUT'
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            document.querySelector('[data-toast-title]').innerHTML = data.status.charAt(0).toUpperCase() + data.status.substring(1);
            document.querySelector('[data-toast-body]').innerHTML = data.message;
            const toast = new bootstrap.Toast(toastLiveExample)
            toastLiveExample.classList.add(`bg-${data.status}-subtle`, `border`, `border-${data.status}-subtle`);
            toast.show()
        })
        .catch((error) => {
            this.insertAdjacentHTML('afterbegin', `<div class="alert alert-danger" role="alert">${error}</div>`);
        });
});