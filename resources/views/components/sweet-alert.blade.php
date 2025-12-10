 <script src="{{ asset('js/sweetalert2.js') }}"></script>
 <script>
   document.addEventListener('DOMContentLoaded', function() {
     document.addEventListener('click', function(event) {
       const target = event.target.closest('.delete-confirm');
       if (!target) return;

       event.preventDefault();
       event.stopPropagation();

       const form = target.closest('form.delete-form');
       if (!form) return;

       Swal.fire({
         title: 'Are you sure?',
         text: "You won't be able to revert this!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#dc2626',
         cancelButtonColor: '#6b7280',
         confirmButtonText: 'Yes, delete it!',
         cancelButtonText: 'Cancel',
         reverseButtons: true
       }).then((result) => {
         if (result.isConfirmed) {
           form.submit();
         }
       });
     });
   });
 </script>
