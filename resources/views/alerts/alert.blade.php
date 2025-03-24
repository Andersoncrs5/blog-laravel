<div id="alert-container" class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1050;">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> {{ session('warning') }}
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            let alerts = document.querySelectorAll(".alert");
    
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.classList.remove("show");
                    alert.classList.add("fade");
                    setTimeout(() => alert.remove(), 500);
                });
            }, 4000);
        });
    </script>
</div>
