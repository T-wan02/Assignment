function showToast(toastContainer, message, type = ''){
     let color = 'primary';
     if(type === 'red'){
          color = 'danger'
     }

     toastContainer.innerHTML = `
          <div class="toast align-items-center text-bg-${color} border-0" id="live-toast" role="alert" aria-live="assertive" aria-atomic="true">
               <div class="d-flex">
                    <div class="toast-body">
                         ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
               </div>
          </div>
     `;

     const toast = document.getElementById('live-toast');
     const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
     toastBootstrap.show();
}