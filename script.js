const ws = new WebSocket('ws://localhost:8080');
const picker = new EmojiButton();

document.addEventListener('DOMContentLoaded', function() {
    // Load previous messages
    fetch('load_messages.php?user_id=1')
        .then(response => response.json())
        .then(messages => {
            const chatBox = document.querySelector('#chat-box');
            messages.forEach(message => {
                appendMessage(message.message, message.sender_type);
            });
        });

    document.querySelector('#send-message').addEventListener('click', sendMessage);
    document.querySelector('#send-file').addEventListener('click', function() {
        console.log('File button clicked');
        sendMessage();
        document.querySelector('#file-input').click();
    });

    document.querySelector('#file-input').addEventListener('change', uploadFile);

    // Initialize Emoji Picker
    picker.on('emoji', emoji => {
        document.querySelector('#message-input').value += emoji;
    });
    document.querySelector('#emoji-button').addEventListener('click', () => {
        picker.togglePicker(document.querySelector('#emoji-button'));
    });
});

ws.onmessage = function(event) {
    const data = JSON.parse(event.data);
    appendMessage(data.message, data.sender_type);
};

function sendMessage() {
    const input = document.querySelector('#message-input');
    const message = input.value.trim();
    if (message === '') return;

    const data = {
        user_id: 1,
        message: message,
        file_path: '',
        sender_type: 'client'
    };

    ws.send(JSON.stringify(data));
    input.value = '';
    appendMessage(message, 'client');
}

// ... (rest of the code remains the same)


function uploadFile() {
    const fileInput = document.querySelector('#file-input');
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('file', file);

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const message = `[File: ${file.name}]`;
            const fileData = {
                user_id: 1,
                message: '',
                file_path: data.file_path,
                sender_type: 'client'
            };
            ws.send(JSON.stringify(fileData));
            appendFile(fileData.file_path, 'client');
        }
    });
}

function appendMessage(message, senderType) {
    const chatBox = document.querySelector('#chat-box');
    const messageElement = document.createElement('div');
    messageElement.className = `chat-message ${senderType}`;
    messageElement.innerText = message;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function appendFile(filePath, senderType) {
    const chatBox = document.querySelector('#chat-box');
    const fileElement = document.createElement('div');
    fileElement.className = `chat-message ${senderType}`;
    
    if (filePath.match(/\.(jpg|jpeg|png|gif)$/)) {
        fileElement.innerHTML = `<img src="${filePath}" alt="File" />`;
    } else {
        fileElement.innerHTML = `<a href="${filePath}" download>Download File</a>`;
    }

    chatBox.appendChild(fileElement);
    chatBox.scrollTop = chatBox.scrollHeight;
}



// dont touch *********************
let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
   menu.classList.toggle('fa-times');
   navbar.classList.toggle('active');
};

window.onscroll = () =>{
   menu.classList.remove('fa-times');
   navbar.classList.remove('active');
};


document.querySelector('#close-edit').onclick = () =>{
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'admin.php';
};


