import Swal from "sweetalert2";
export const Sweetalert = {
    success(message) {
        Swal.fire({
            icon: "success",
            toast: true,
            showConfirmButton: false,
            timer: 2000,
            title: message,
            position: "top-right",
            timerProgressBar: true,
        });
    },
    error(message) {
        Swal.fire({
            icon: "error",
            toast: true,
            showConfirmButton: false,
            timer: 2000,
            title: message,
            position: "top-right",
            timerProgressBar: true,
        });
    },
    confirm(message) {
        return Swal.fire({
            title: message,
            text: "Are you sure you want to delete?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        });
    },
};

export default Sweetalert;
