function calculateTotal(){
    var total = 0;
    var rows = document.querySelectorAll('table tbody tr');
    rows.forEach(function(row){
        var priceElement = row.querySelector('.price');
        var quantityElement = row.querySelector('.quantity');
        if(priceElement && quantityElement){
            var price = priceElement.textContent.replace(' đ', '').replace(/,/g, '');
            var quantity = quantityElement.textContent;
            total += price * quantity;
        }
    });
    document.getElementById('total').textContent = total + 'đ';
}
window.onload = function() {
    calculateTotal();
};