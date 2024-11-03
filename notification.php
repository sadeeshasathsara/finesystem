<?php
function callNotification($text)
{

    $encodedText = json_encode($text);

    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification($encodedText);
        });
    </script>
    ";
}
?>

<style>
    .custom-notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        overflow: hidden;
        user-select: none;
        cursor: pointer;
        font-family: sans-serif;

    }

    .custom-notification {
        background-color: #4CAF50;

        color: white;
        padding: 15px;
        margin: 10px;
        border-radius: 5px;
        opacity: 0;
        position: relative;
        animation: customSlideIn 0.5s forwards;

    }

    .custom-notification.error {
        background-color: #f44336;

    }

    @keyframes customSlideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes customSlideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>

<div class="custom-notification-container"></div>

<script>
    function showNotification(message, isSuccess = true) {
        const notificationContainer = document.querySelector('.custom-notification-container');


        const notification = document.createElement('div');
        notification.className = `custom-notification ${isSuccess ? '' : 'error'}`;
        notification.textContent = message;


        notification.addEventListener('click', () => {
            notification.style.animation = 'customSlideOut 0.5s forwards';
            setTimeout(() => {
                notification.remove();
            }, 500);
        });


        notificationContainer.appendChild(notification);


        setTimeout(() => {
            notification.style.opacity = 1;
        }, 10);


        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'customSlideOut 0.5s forwards';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }
        }, 3000);
    }
</script>