//Using resources for stripe API from https://stripe.com/docs

// A reference to Stripe.js initialized with your real test publishable API key.
var stripe = Stripe("pk_test_51JgjfaK4Dwx6WmWzd7jJLt6zEKuUsgg2m3UxbECtEnVunYnadj9SSCT65yE2mDfNe4el8qiq1Oa9mblIA4pPhZ3d00X1cfuiAr");



// Disable the button until we have Stripe set up on the page
const btn = document.querySelector("#submitButton")
btn.addEventListener('click', ()=>{
    fetch('../../payment/stripe.php', {
        method: "POST",
        headers: {
            'Content-Type':'application/json',
        },
        body: JSON.stringify({})
    }).then(res=> res.json()).then(payload => {
        stripe.redirectToCheckout({sessionId: payload.id})
    })
})