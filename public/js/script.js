document.addEventListener('DOMContentLoaded', function() {
    var bookImage = document.getElementById('bookImage');
    bookImage.onerror = function() {
        this.src = '/img/default_book.jpg';
    };
});
