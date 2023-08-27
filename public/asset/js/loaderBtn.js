function loadBtn(btn, type = '', content = '', stage = true) {
     if (stage) {
          btn.disabled = true;
          btn.innerHTML = `
               <div class="spinner-border ${type}" role="status">
                    <span class="visually-hidden">Loading...</span>
               </div>
          `;
     } else {
          btn.disabled = false;
          btn.innerHTML = content;
     }
}