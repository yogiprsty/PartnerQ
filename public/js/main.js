const BASE_URL = 'http://127.0.0.1:8000'

const container = document.getElementById('chat-container')
const refreshBtn = document.getElementById('refresh-button')
const listChat = document.getElementById('list-chat')
const sendBtn = document.getElementById('send-button')
const username = container.dataset.name

function readChat(slug) {
    container.innerHTML = ''
    fetch(`${BASE_URL}/read-chat/${slug}`)
        .then(res => res.json())
        .then(datas => {
            datas.forEach(data => {
                const item = document.createElement("DIV")
                const spacer = document.createElement('DIV')
                spacer.style.clear = 'both'
                item.classList.add('chat-bubble', 'bg-light', 'my-4', 'p-2', 'shadow', 'rounded-pill')
                if (data['username'] == username) {
                    item.classList.add('float-right')
                    item.append(`${data['chat_text']} | you`)
                        // item.innerHTML(`${data['username']}`)
                } else {
                    item.append(`${data['username']} | ${data['chat_text']}`)
                }
                container.append(item)
                container.append(spacer)
            });
        });
};

async function sendChat(slug, chat_text, token) {
    fetch(`${BASE_URL}/send-chat/${slug}`, {
        method: 'post',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': token,
        },
        body: `chat_text=${chat_text}`
    })
}

if (container) {
    const slug = container.dataset.slug
    readChat(slug)
    refreshBtn.addEventListener('click', () => {
        readChat(slug)
    })

    const chat_text = document.getElementById('chat_text')
    var csrf = document.querySelector('meta[name="csrf-token"]').content

    sendBtn.addEventListener('click', () => {
        sendChat(slug, chat_text.value, csrf)
        chat_text.value = ''
    })
}