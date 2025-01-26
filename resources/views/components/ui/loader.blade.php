<div id="loader" class="loader" style="display: none;"></div>
<div id="toast" class="toast" style="display: none;"></div>

<style>
    .loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Toast styles */
    .toast {
        position: fixed;
        top: 10px; /* Distance from the top */
        right: 20px; /* Distance from the right */
        background-color: #333;
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        opacity: 0.9;
        transition: opacity 0.5s ease;
        z-index: 10000; /* Ensure it's above other elements */
        display: flex;
        justify-content: center; /* Center the text inside */
        align-items: center; /* Center the text vertically */
    }
</style>

<script>
    function showLoaderAndToast() {
        const loader = document.getElementById('loader');
        loader.style.display = 'block';

        setTimeout(() => {
            toast.style.display = 'none';
        }, 2000);
    }

    function hideLoader() {
        const loader = document.getElementById('loader');
        loader.style.display = 'none';
    }

    window.addEventListener('load', function() {
        document.addEventListener('ajaxStart', function() {
            showLoaderAndToast();
        });

        document.addEventListener('ajaxEnd', function() {
            hideLoader();
        });
    });
</script>
