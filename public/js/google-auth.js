(() => {
    const clientId = window.GOOGLE_CLIENT_ID || '';
    const buttonIds = ['google-register-btn', 'google-login-btn'];

    const handleCredentialResponse = async (response) => {
        try {
            const endpoint = new URL('index.php', window.location.href);
            endpoint.searchParams.set('page', 'googleLogin');

            const res = await fetch(endpoint.toString(), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ credential: response.credential })
            });

            const raw = await res.text();
            let data;
            try {
                data = JSON.parse(raw);
            } catch (e) {
                console.error('Response not JSON:', raw);
                throw new Error('Phản hồi không hợp lệ từ máy chủ.');
            }

            if (!res.ok || !data.success) {
                const msg = (data && data.message) ? data.message : 'Không thể đăng nhập bằng Google';
                alert(msg);
                return;
            }

            alert(data.message || 'Đăng nhập thành công');
            window.location.href = data.redirect || 'index.php';
        } catch (error) {
            console.error('Google sign-in error', error);
            alert(error.message || 'Không thể kết nối tới máy chủ. Vui lòng thử lại.');
        }
    };

    const renderButtons = () => {
        if (!window.google || !google.accounts || !google.accounts.id) {
            setTimeout(renderButtons, 150);
            return;
        }

        google.accounts.id.initialize({
            client_id: clientId,
            callback: handleCredentialResponse
        });

        const buttonOptions = {
            type: 'standard',
            theme: 'outline',
            size: 'large',
            text: 'continue_with', // “Tiếp tục với Google”
            shape: 'pill',
            logo_alignment: 'left',
            width: 360,
            locale: 'vi'
        };

        buttonIds.forEach((id) => {
            const el = document.getElementById(id);
            if (el) {
                google.accounts.id.renderButton(el, buttonOptions);
                el.style.display = 'block';
            }
        });
    };

    const boot = () => {
        if (!clientId) {
            console.warn('GOOGLE_CLIENT_ID chưa được cấu hình.');
            return;
        }
        renderButtons();
    };

    if (document.readyState === 'loading') {
        window.addEventListener('DOMContentLoaded', boot);
    } else {
        // DOM đã sẵn sàng trước khi script được load
        boot();
    }
})();
