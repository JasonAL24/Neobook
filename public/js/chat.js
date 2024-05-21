document.addEventListener('DOMContentLoaded', function() {
    const communityList = document.getElementById('community-list');
    const chatContent = document.getElementById('chat-content');
    const chatArea = document.getElementById('chat-area');
    const backButton = document.getElementById('back-button');

    // Attach event listeners to community links
    document.querySelectorAll('.community-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const communityId = this.getAttribute('data-id');

            fetch(`/chats/${communityId}`)
                .then(response => response.text())
                .then(data => {
                    chatArea.innerHTML = data;
                    communityList.style.display = 'none';
                    chatContent.style.display = 'block';
                })
                .catch(error => console.error('Error fetching chat content:', error));
        });
    });

    // Handle back button click
    backButton.addEventListener('click', function() {
        chatContent.style.display = 'none';
        communityList.style.display = 'block';
    });

    // Function to dynamically attach event listeners to newly loaded chat content
    const attachChatEventListeners = () => {
        const messageForm = document.getElementById('messageForm');
        const chatMessages = document.getElementById('chat-messages');

        messageForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const options = { hour: 'numeric', minute: '2-digit', hour12: true };
                        const formattedTime = new Date(data.message.created_at).toLocaleTimeString('id-ID', options);

                        const newMessageHtml = `
                        <div class="d-flex justify-content-end mb-2">
                            <div class="p-2 rounded bg-light" style="max-width: 75%;">
                                ${data.message.content}
                                <br>
                                <small class="text-muted">${formattedTime}</small>
                            </div>
                        </div>
                    `;

                        chatMessages.insertAdjacentHTML('beforeend', newMessageHtml);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                        messageForm.reset();
                    } else {
                        console.error('Failed to send message');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Attach real-time updates using Laravel Echo
        const communityId = messageForm.dataset.communityId;
        window.Echo.private('chat.' + communityId)
            .listen('MessageSent', (e) => {
                const options = { hour: 'numeric', minute: '2-digit', hour12: true };
                const formattedTime = new Date(e.message.created_at).toLocaleTimeString('id-ID', options);
                const newMessageHtml = `
                    <div class="d-flex justify-content-start mb-2">
                        <div class="p-2 rounded bg-secondary" style="max-width: 75%;">
                            ${e.message.content}
                            <br>
                            <small class="text-muted">${formattedTime}</small>
                        </div>
                    </div>
                `;

                chatMessages.insertAdjacentHTML('beforeend', newMessageHtml);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    };

    // Observe changes in chat area to reattach event listeners
    const observer = new MutationObserver(attachChatEventListeners);
    observer.observe(chatArea, { childList: true });
});
