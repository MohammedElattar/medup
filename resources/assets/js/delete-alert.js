document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            showSweetAlert(() => {
                const form = button.closest('a').querySelector('.delete-form');
                if (form) {
                    form.submit();
                } else {
                    console.error('Delete form not found');
                }
            });
        });
    });
});
