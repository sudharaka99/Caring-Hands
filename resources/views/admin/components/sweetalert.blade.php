@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#FF9CA9",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Oops!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonColor: "#dc3545",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif

@if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Warning!",
                text: "{{ session('warning') }}",
                icon: "warning",
                confirmButtonColor: "#FF9800",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif

@if(session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Information",
                text: "{{ session('info') }}",
                icon: "info",
                confirmButtonColor: "#2196F3",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif

@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let errorMessage = '';
            @foreach($errors->all() as $error)
                errorMessage += '• {{ $error }}\n';
            @endforeach
            
            Swal.fire({
                title: "Validation Error!",
                text: errorMessage,
                icon: "error",
                confirmButtonColor: "#dc3545",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif