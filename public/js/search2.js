const optionMenu = document.querySelector(".select-menu");
      selectBtn  = optionMenu.querySelector(".select-btn");
      options    = optionMenu.querySelectorAll(".option");
      sBtn_text  = optionMenu.querySelector(".sBtn-text");
      custom_input_forum = optionMenu.querySelector(".custom-input-forum");

selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));
selectBtn.addEventListener("click", () => sBtn_text.classList.add("active"));
selectBtn.addEventListener("click", () => custom_input_forum.classList.toggle("active"));


options.forEach(option => {
    option.addEventListener("click", () =>{
        let selectedOption = option.querySelector(".option-text").innerText;
        sBtn_text.innerText = selectedOption;
        document.querySelector(".option-text").style.opacity = '1';
        optionMenu.classList.remove("active");
    })
})

// Function to check if a click occurred inside the search input or search button
function isClickInsideSearch(event) {
    var searchInput = document.getElementById('searchInputForum');
    var searchButton = document.getElementById('searchButton');

    return (event.target === searchInput || event.target === searchButton);
}

// Listen for click events on the document
document.addEventListener('click', function(event) {
    var searchResultsDropdown = document.getElementById('searchResultsDropdownForum');

    // If the click occurred inside the search input or search button, show the dropdown
    if (isClickInsideSearch(event)) {
        var query = document.getElementById('searchInputForum').value.trim();
        if (query !== '') {
            searchResultsDropdown.style.display = 'block';
        }
    } else {
        // If the click occurred outside of the search input and search button, hide the dropdown
        searchResultsDropdown.style.display = 'none';
    }
});

document.getElementById('searchInputForum').addEventListener('input', function() {
    // Get the search query
    var query = this.value.trim();

    // If the query is not empty, make an AJAX request
    if (query !== '') {
        // Send AJAX request to the server
        $.ajax({
            type: 'GET',
            url: '/buatforum/search/' + query,
            success: function(response) {
                // Display search results in the dropdown
                $('#searchResultsDropdownForum').html(response);
                $('#searchResultsDropdownForum').show(); // Show the dropdown

                // document.querySelectorAll('.search-result-item').forEach(item => {
                //     item.addEventListener('click', function() {
                //         let selectedOption = this.querySelector('.option-text').innerText;
                //         let selectedOptionId = this.querySelector('.option-id').innerText;
                //         let sBtnTextElement = document.querySelector('.sBtn-text');
                //         document.querySelector('.sBtn-text').innerText = selectedOption;
                //         document.querySelector('.sBtn-text-id').innerText = selectedOptionId;
                //         document.getElementById('searchResultsDropdownForum').style.display = 'none';
                //
                //         optionMenu.classList.remove("active");
                //         custom_input_forum.classList.remove("active");
                //     });
                // });

                document.querySelectorAll('.search-result-item').forEach(item => {
                    item.addEventListener('click', function() {
                        let selectedOption = this.querySelector('.option-text').innerText;
                        let selectedOptionId = this.querySelector('.option-id').innerText;

                        document.querySelector('.sBtn-text').innerText = selectedOption;
                        document.querySelector('.sBtn-text-id').value = selectedOptionId;  // Set the value correctly

                        document.getElementById('searchResultsDropdownForum').style.display = 'none';
                        optionMenu.classList.remove("active");
                        custom_input_forum.classList.remove("active");
                    });
                });
            }
        });
    } else {
        // If the query is empty, hide the dropdown
        $('#searchResultsDropdownForum').hide();
    }
});


