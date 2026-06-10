{{-- resources/views/wl-admin/layouts/sessionmessage.blade.php --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.custom-alert {
    padding: 16px 20px;
    margin: 20px auto;
    border-radius: 10px;
    position: relative;
    font-size: 15px;
    font-weight: 500;
    max-width: 600px;
    color: #fff;
    animation: fadeIn 0.5s ease-in-out;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: linear-gradient(135deg, #28a745, #218838);
}

.alert-error {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.custom-alert .close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    color: #fff;
    transition: color 0.3s ease;
}

.custom-alert .close-btn:hover {
    color: #000;
}

.custom-alert i {
    font-size: 20px;
    margin-right: 8px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media screen and (max-width: 768px) {
    .custom-alert {
        font-size: 14px;
        padding: 14px 16px;
    }
}
</style>

@if(Session::has('error')) 
    <div class="custom-alert alert-error">
        <i class="fa fa-exclamation-circle"></i>
        <span><strong>Error:</strong> {{ Session::get('error') }}</span>
        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
@endif

@if(Session::has('success'))
    <div class="custom-alert alert-success">
        <i class="fa fa-check-circle"></i>
        <span><strong>Success:</strong> {{ Session::get('success') }}</span>
        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
@endif

<script>
    setTimeout(() => {
        const alerts = document.querySelectorAll('.custom-alert');
        alerts.forEach(alert => alert.style.display = 'none');
    }, 5000);
</script>