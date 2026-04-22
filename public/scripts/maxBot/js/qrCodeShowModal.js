    document.addEventListener('DOMContentLoaded', function() {
    const showQrModalBtn = document.getElementById('showQrModalBtn');

    showQrModalBtn.addEventListener('click', function() {
    fetch('/qr-modal?description=Отсканируйте QR код')
    .then(response => response.json())
    .then(data => {
    if (data.success) {
    Swal.fire({
    title: 'АФ КРиММ - INFORMER',
    html: `
                            <div style="text-align: center;">
                                <img src="${data.image_path}" alt="QR Code" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px;">
                                <p style="margin-top: 15px; font-size: 16px; color: #555;">${data.description}</p>
                            </div>
                        `,
    showConfirmButton: true,
    confirmButtonText: 'Закрыть',
    customClass: {
    popup: 'swal2-popup-custom',
    title: 'swal2-title-custom',
    htmlContainer: 'swal2-html-custom'
},
    width: '400px'
});
} else {
    Swal.fire('Ошибка', 'Не удалось загрузить изображение.', 'error');
}
})
    .catch(error => {
    console.error('Error:', error);
    Swal.fire('Ошибка', 'Произошла ошибка при загрузке изображения.', 'error');
});
});
});

