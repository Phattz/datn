document.addEventListener("DOMContentLoaded", function () {

    const icon = document.getElementById("chatbot-icon");
    const box = document.getElementById("chatbox-box");
    const closeBtn = document.getElementById("chat-close");
    const sendBtn = document.getElementById("chat-send");
    const input = document.getElementById("chat-input");
    const chatContent = document.getElementById("chat-content");

    /* ===== MỞ / ĐÓNG CHAT ===== */
    icon.addEventListener("click", () => {
        box.style.display = "flex";
        input.focus();
    });

    closeBtn.addEventListener("click", () => {
        box.style.display = "none";
    });

    /* ===== GỬI TIN NHẮN ===== */
    sendBtn.addEventListener("click", sendMessage);
    input.addEventListener("keypress", function(e) {
        if (e.key === "Enter") sendMessage();
    });

    function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        addMessage(text, "user");
        input.value = "";

        showTyping();

        fetch(`app/view/chatbox.php?q=${encodeURIComponent(text)}`)
            .then(res => res.json())
            .then(data => {
                removeTyping();

                if (data.length > 0) {
                    addMessage("Tui tìm thấy mấy sản phẩm này nè 🧶", "bot");

                    data.forEach(product => {
                       const card = `
<div class="chat-product">
    <img src="${product.img}">
    <div class="chat-product-info">
        <h4>${product.name}</h4>
        ${product.star ? `<div class="rating">⭐ ${product.star} / 5</div>` : ``}
        ${product.review ? `<div class="review-text">${product.review}</div>` : ``}
        <a href="index.php?page=productDetail&id=${product.id}" 
           class="chat-buy-btn">Mua ngay</a>
    </div>
</div>
`;
                        addMessage(card, "bot");
                    });
                } else {
                    addMessage("Xin lỗi, tui chưa tìm thấy sản phẩm phù hợp 😥", "bot");
                }
            })
            .catch(() => {
                removeTyping();
                addMessage("Có lỗi khi kết nối đến hệ thống.", "bot");
            });
    }

    /* ===== HIỂN THỊ TIN NHẮN ===== */
    function addMessage(content, sender) {
        const msg = document.createElement("div");
        msg.className = sender === "bot" ? "bot-msg" : "user-msg";
        msg.innerHTML = content;
        chatContent.appendChild(msg);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    /* ===== HIỆU ỨNG ĐANG GÕ ===== */
    function showTyping() {
        const typing = document.createElement("div");
        typing.id = "typing";
        typing.className = "bot-msg";
        typing.innerText = "Đang tìm sản phẩm...";
        chatContent.appendChild(typing);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    function removeTyping() {
        const typing = document.getElementById("typing");
        if (typing) typing.remove();
    }

});
