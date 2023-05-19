function UpdateQty_Cart(id, q, max) {
    if (q != 0 && (q<max+1))
        window.location = "updtQuantityCart.php?ID=" + id + "&q=" + q;
}

function RemoveFrom_Cart(id) {
    window.location = "rmvFromCart.php?ID=" + id;
}

function CleanCart() {
    window.location = "cleanCart.php";
}

function Checkout() {
    window.location = "checkoutPage.php";
}
function AddTo_Cart(id, q) {
    window.location = "addToShpCart.php?ID=" + id + "&q=" + q;
}

function RemoveFrom_Wishlist(id) {
    window.location = "rmvFromWishList.php?ID=" + id;
}

function Delete_Product(id) {
    window.location = "dltProduct.php?ID=" + id;
}
function Update_Product(id) {
    window.location = "UpdateProduct.php?ID=" + id;
}

function Delete_PaymentMethod(id) {
    window.location = "dltPaymentMethod.php?ID=" + id;
}