function toggle_mobile_menu() {
    const nav = document.querySelector('.navbar-nav');
    nav.classList.toggle('show');
}

function confirm_delete(message) {
    return confirm(message || 'Are you sure you want to delete this?');
}

function refresh_chat() {
    const chatMessages = document.getElementById('chat-messages');
    const currentUser = document.getElementById('current-user-id').value;
    const selectedUser = document.getElementById('selected-user-id').value;

    if (chatMessages && currentUser && selectedUser) {
        fetch(`get_messages.php?from=${currentUser}&to=${selectedUser}`)
            .then(response => response.text())
            .then(html => {
                chatMessages.innerHTML = html;

                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(error => console.error('Error refreshing chat:', error));
    }
}


function start_chat_refresh() {

    refresh_chat();

    setInterval(refresh_chat, 2000);
}


function select_chat_user(user_id, user_name) {
    document.getElementById('selected-user-id').value = user_id;
    document.getElementById('selected-user-name').textContent = user_name;


    document.querySelectorAll('.chat-user').forEach(user => {
        user.classList.remove('active');
    });
    event.target.classList.add('active');

    refresh_chat();
}


function send_message() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    const selectedUserId = document.getElementById('selected-user-id').value;

    if (!message || !selectedUserId) {
        alert('Please select a user and enter a message.');
        return;
    }

    const form = document.getElementById('message-form');
    const formData = new FormData(form);


    const sendButton = document.querySelector('button[onclick="send_message()"]');
    const originalText = sendButton.textContent;
    sendButton.disabled = true;
    sendButton.textContent = 'Sending...';

    fetch('send_message.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {

                messageInput.value = '';


                setTimeout(() => {
                    refresh_chat();
                }, 100);


                sendButton.disabled = false;
                sendButton.textContent = originalText;
            } else {
                alert('Failed to send message. Please try again.');
                sendButton.disabled = false;
                sendButton.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Error sending message. Please try again.');
            sendButton.disabled = false;
            sendButton.textContent = originalText;
        });
}


function handle_message_keypress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        send_message();
    }
}


function init_page() {
    const mobileBtn = document.querySelector('.mobile-menu-btn');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', toggle_mobile_menu);
    }


    if (document.getElementById('chat-messages')) {
        start_chat_refresh();
    }

    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!validate_form(form.id)) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });


    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword) {
        confirmPassword.addEventListener('input', validate_password_match);
    }
    const messageInput = document.getElementById('message-input');
    if (messageInput) {
        messageInput.addEventListener('keypress', handle_message_keypress);
    }
}


document.addEventListener('DOMContentLoaded', init_page);