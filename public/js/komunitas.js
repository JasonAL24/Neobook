function redirectToSearch() {
    const query = document.getElementById('searchCommunityInput').value;
    if(query) {
    window.location.href = `/komunitas/search/${encodeURIComponent(query)}`;
    } else {
        alert('Tolong masukan komunitas yang ingin dicari');
    }
    return false; // Prevent form submission
}
