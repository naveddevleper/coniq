//alert("hello");

function addDiscount()
{
    console.log("Add discount btn");
}
var discountbtn = document.querySelector('.discount-btn');

discountbtn.addEventListener('click',function() {
    this.classList.add('active');

    addDiscount();
})


