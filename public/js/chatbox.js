document.addEventListener("DOMContentLoaded", function () {
    const icon = document.getElementById("chatbot-icon");
    const box = document.getElementById("chatbox-box");
    const closeBtn = document.getElementById("chat-close");
    const sendBtn = document.getElementById("chat-send");
    const input = document.getElementById("chat-input");
    const chatContent = document.getElementById("chat-content");

    // Khi bấm icon → mở hộp chat
    icon.addEventListener("click", () => {
        box.style.display = "flex";
    });

    // Khi bấm X → đóng hộp chat
    closeBtn.addEventListener("click", () => {
        box.style.display = "none";
    });

    // Khi bấm Gửi hoặc Enter → thêm tin nhắn
    sendBtn.addEventListener("click", sendMessage);
    input.addEventListener("keypress", function(e) {
        if (e.key === "Enter") sendMessage();
    });

    function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        addMessage(text, "user");
        input.value = "";

        handleBotResponse(text);
    }

    function addMessage(content, sender) {
        const msg = document.createElement("div");
        msg.className = sender === "bot" ? "bot-msg" : "user-msg";
        msg.innerHTML = content;
        chatContent.appendChild(msg);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    // ✅ Chỉ giữ lại 1 hàm handleBotResponse
   function handleBotResponse(text) {
    fetch(`app/view/chatbox.php?q=${encodeURIComponent(text)}`)
        .then(res => res.json())
        .then(data => {
            if (data.length > 0) {
                data.forEach(product => {
                    addMessage(`
                        <div class="product-card">
                            <img src="${product.img}" width="100"/>
                            <h4>${product.name}</h4>
                            <a href="index.php?page=productDetail&id=${product.id}" class="buy-button">Mua ngay</a>
                        </div>
                    `, "bot");
                });
            } else {
                addMessage("Xin lỗi, mình chưa có thông tin sản phẩm này.", "bot");
            }
        })
        .catch(err => {
            addMessage("Có lỗi khi truy vấn sản phẩm.", "bot");
            console.error(err);
        });
}




});
