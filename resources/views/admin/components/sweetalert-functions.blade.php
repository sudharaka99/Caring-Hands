<script>
    function showSuccess(message) {
        Swal.fire({
            title: "Success!",
            text: message,
            icon: "success",
            confirmButtonColor: "#FF9CA9",
            confirmButtonText: "OK"
        });
    }

    function showError(message) {
        Swal.fire({
            title: "Oops!",
            text: message,
            icon: "error",
            confirmButtonColor: "#dc3545",
            confirmButtonText: "OK"
        });
    }

    function showWarning(message) {
        Swal.fire({
            title: "Warning!",
            text: message,
            icon: "warning",
            confirmButtonColor: "#FF9800",
            confirmButtonText: "OK"
        });
    }

    function showInfo(message) {
        Swal.fire({
            title: "Information",
            text: message,
            icon: "info",
            confirmButtonColor: "#2196F3",
            confirmButtonText: "OK"
        });
    }

    // Delete Confirmation
    function confirmDelete(name, callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to delete " + name + ". You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: name + " has been deleted successfully.",
                    icon: "success",
                    confirmButtonColor: "#FF9CA9",
                    confirmButtonText: "OK"
                });
                
                setTimeout(() => {
                    if (callback) callback();
                }, 500);
            }
        });
    }

    // Custom Confirmation
    function confirmAction(title, text, callback) {
        Swal.fire({
            title: title,
            text: text,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#FF9CA9",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, proceed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                if (callback) callback();
            }
        });
    }

    // Save Success (Clean Style)
    function showSaved(message = "Your work has been saved") {
        Swal.fire({
            title: "Good job!",
            text: message,
            icon: "success",
            confirmButtonColor: "#FF9CA9",
            confirmButtonText: "OK"
        });
    }

    // Delete with custom style (like your example)
    function deleteWithStyle(id, name, callback) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: name + " has been deleted.",
                    icon: "success",
                    confirmButtonColor: "#FF9CA9",
                    confirmButtonText: "OK"
                });
                
                setTimeout(() => {
                    if (callback) callback();
                }, 500);
            }
        });
    }

    function showLoading(message = 'Processing...') {
        Swal.fire({
            title: message,
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function closeAlert() {
        Swal.close();
    }
</script>