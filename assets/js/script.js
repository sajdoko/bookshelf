function increaseCartItemValue() {
    const cartItems = document.getElementById("cartItems");
    cartItems.innerHTML = parseInt(cartItems.innerHTML) + 1;
}
function showToast(data) {
    document.querySelector('[data-toast-title]').innerHTML = data.status.charAt(0).toUpperCase() + data.status.substring(1);
    document.querySelector('[data-toast-body]').innerHTML = data.message;
    const toast = new bootstrap.Toast(toastLiveExample)
    toastLiveExample.classList.add(`bg-${data.status}-subtle`, `border`, `border-${data.status}-subtle`);
    toast.show();
}

const toastLiveExample = document.getElementById('liveToast')

const addBookToCartForms = document.getElementsByClassName("add-book-to-cart");
for (let i = 0; i < addBookToCartForms.length; i++) {
    addBookToCartForms[i].addEventListener("submit", function (event) {
        event.preventDefault();

        const Boo_ISBN = this.elements.Boo_ISBN.value;
        const quantity = this.elements.quantity.value;

        fetch('/includes/handle_fetch.php', {
            method: 'POST', // or 'PUT'
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({add_to_cart: 'aa', Boo_ISBN, quantity}),
        })
            .then((response) => response.json())
            .then((data) => {
                showToast(data)
                if (data.status === 'success') {
                    increaseCartItemValue();
                }
            })
            .catch((error) => {
                document.querySelector('main').insertAdjacentHTML('afterbegin', `<div class="alert alert-danger" role="alert">${error}</div>`);
            });
    });
}