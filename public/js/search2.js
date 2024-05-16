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

                document.querySelectorAll('.search-result-item').forEach(item => {
                    item.addEventListener('click', function() {
                        let selectedOption = this.querySelector('.option-text').innerText;
                        let sBtnTextElement = document.querySelector('.sBtn-text');
                        document.querySelector('.sBtn-text').innerText = selectedOption;
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


// const wrapper = document.querySelector(".wrapper"),
//     selectBtn = wrapper.querySelector(".select-btn"),
//     searchInp = wrapper.querySelector("input"),
//     optionz = wrapper.querySelector(".optionz");
//
// let countries = ["Afghanistan", "Algeria", "Argentina", "Australia", "Bangladesh", "Belgium", "Bhutan",
//     "Brazil", "Canada", "China", "Denmark", "Ethiopia", "Finland", "France", "Germany",
//     "Hungary", "Iceland", "India", "Indonesia", "Iran", "Italy", "Japan", "Malaysia",
//     "Maldives", "Mexico", "Morocco", "Nepal", "Netherlands", "Nigeria", "Norway", "Pakistan",
//     "Peru", "Russia", "Romania", "South Africa", "Spain", "Sri Lanka", "Sweden", "Switzerland",
//     "Thailand", "Turkey", "Uganda", "Ukraine", "United States", "United Kingdom", "Vietnam"];
//
//
// function addCountry(selectedCountry) {
//     optionz.innerHTML = "";
//     countries.forEach(country => {
//         let isSelected = country == selectedCountry ? "selected" : "";
//         let li = `<li onclick="updateName(this)" class="${isSelected}">${country}</li>`;
//         optionz.insertAdjacentHTML("beforeend", li);
//     });
// }
// addCountry();
//
// function updateName(selectedLi) {
//     searchInp.value = "";
//     addCountry(selectedLi.innerText);
//     wrapper.classList.remove("active");
//     selectBtn.firstElementChild.innerText = selectedLi.innerText;
// }
//
// searchInp.addEventListener("keyup", () => {
//     let arr = [];
//     let searchWord = searchInp.value.toLowerCase();
//     arr = countries.filter(data => {
//         return data.toLowerCase().startsWith(searchWord);
//     }).map(data => {
//         let isSelected = data == selectBtn.firstElementChild.innerText ? "selected" : "";
//         return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
//     }).join("");
//     optionz.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Country not found</p>`;
// });
//
// selectBtn.addEventListener("click", () => wrapper.classList.toggle("active"));
