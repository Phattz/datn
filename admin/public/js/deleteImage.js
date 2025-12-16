document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-image");
    const hiddenInput = document.querySelector("input[name='listImages_old']");
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const imageToDelete = this.dataset.image;
            const currentImages = hiddenInput.value.split(',');
            const updatedImages = currentImages.filter(img => img !== imageToDelete);
            hiddenInput.value = updatedImages.join(',');
            this.parentElement.remove();
        });
    });
});