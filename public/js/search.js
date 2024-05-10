// Function to check if a click occurred inside the search input or search button
function isClickInsideSearch(event) {
    var searchInput = document.getElementById('searchInput');
    var searchButton = document.getElementById('searchButton');

    return (event.target === searchInput || event.target === searchButton);
}

// Listen for click events on the document
document.addEventListener('click', function(event) {
    var searchResultsDropdown = document.getElementById('searchResultsDropdown');

    // If the click occurred inside the search input or search button, show the dropdown
    if (isClickInsideSearch(event)) {
        var query = document.getElementById('searchInput').value.trim();
        if (query !== '') {
            searchResultsDropdown.style.display = 'block';
        }
    } else {
        // If the click occurred outside of the search input and search button, hide the dropdown
        searchResultsDropdown.style.display = 'none';
    }
});

// Listen for input in the search field
document.getElementById('searchInput').addEventListener('input', function() {
    // Get the search query
    var query = this.value.trim();

    // If the query is not empty, make an AJAX request
    if (query !== '') {
        // Send AJAX request to the server
        $.ajax({
            type: 'GET',
            url: '/search/' + query,
            success: function(response) {
                // Display search results in the dropdown
                $('#searchResultsDropdown').html(response);
                $('#searchResultsDropdown').show(); // Show the dropdown
            }
        });
    } else {
        // If the query is empty, hide the dropdown
        $('#searchResultsDropdown').hide();
    }
});
