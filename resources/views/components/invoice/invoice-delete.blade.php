<!-- <div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-gradient-success" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     async  function  itemDelete(){
            let id=document.getElementById('deleteID').value;
            document.getElementById('delete-modal-close').click();
            showLoader();
            let res=await axios.post("/invoice-delete",{inv_id:id})
            hideLoader();
            if(res.data===1){
                successToast("Request completed")
                await getList();
            }
            else{
                errorToast("Request fail!")
            }
     }
</script> -->
<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class="mt-3 text-warning">Delete!</h3>
                <p class="mb-3">Once deleted, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>
                
                <!-- Password Input Field -->
                <input type="password" id="deletePassword" class="form-control mt-2" placeholder="Enter your password">
                <small class="text-danger d-none" id="passwordError">Password is required!</small>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-gradient-success" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     async function itemDelete() {
        let id = document.getElementById('deleteID').value;
        let password = document.getElementById('deletePassword').value;
        let passwordError = document.getElementById('passwordError');

        // Check if password is empty
        if (password === '') {
            passwordError.classList.remove('d-none');
            return;
        } else {
            passwordError.classList.add('d-none');
        }

        document.getElementById('delete-modal-close').click();
        showLoader();

        try {
            let res = await axios.post("/invoice-delete", {
                inv_id: id,
                password: password  // Send password for validation
            });

            hideLoader();

            if (res.data.status === "success") {
                successToast("Request completed");
                await getList();
            } else {
                errorToast(res.data.message || "Request failed!");
            }
        } catch (error) {
            hideLoader();
            errorToast("Something went wrong!");
        }
     }
</script>
