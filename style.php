/* Стили для попапа подписки */
.popup {
    display: none;
    position: fixed;
    left: 20px;
    bottom: 20px;
    z-index: 1000;
}

.popup-content {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    width: 300px;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.popup h3 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 18px;
}

.popup p {
    margin: 0;
    color: #666;
    font-size: 14px;
    line-height: 1.4;
}

#subscribedEmail {
    font-weight: 500;
    color: #333;
}

.popup-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 18px;
    color: #999;
    cursor: pointer;
    padding: 5px;
    line-height: 1;
    transition: color 0.2s;
}

.popup-close:hover {
    color: #333;
}

@media (max-width: 480px) {
    .popup {
        left: 10px;
        right: 10px;
        bottom: 10px;
    }

    .popup-content {
        width: auto;
    }
} 